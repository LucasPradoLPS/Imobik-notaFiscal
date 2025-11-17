param(
    [string]$BaseUrl = "http://127.0.0.1:8888",
    [string]$ApiKey = "",
    [ValidateSet("apikey","bearer")] [string]$AuthType = "apikey",
    [int]$ConnectTimeout = 5,
    [int]$Timeout = 15,
    [switch]$NoEnvWrite,
    [switch]$SkipViewTest,
    [switch]$Verbose
)

function Write-Info($msg){ Write-Host "[INFO] $msg" -ForegroundColor Cyan }
function Write-Warn($msg){ Write-Host "[WARN] $msg" -ForegroundColor Yellow }
function Write-Err($msg){ Write-Host "[ERROR] $msg" -ForegroundColor Red }

$root = Split-Path -Parent $PSCommandPath | Split-Path -Parent  # go up from app/scripts/
$envFile = Join-Path $root '.env'
$logFile = Join-Path $root 'tmp' 'espocrm_last.json'

if (-not $ApiKey) {
    Write-Warn 'Nenhuma chave fornecida via -ApiKey. Você pode digitá-la agora.'
    $ApiKey = Read-Host 'Informe ESPOCRM_API_KEY'
}
if (-not $ApiKey) { Write-Err 'Chave obrigatória.'; exit 1 }

Write-Info "Base URL: $BaseUrl"
Write-Info "Auth Type solicitado: $AuthType"

# Testar metadata com o header escolhido
function Test-Metadata($mode){
    $headers = @{}
    if ($mode -eq 'bearer') { $headers['Authorization'] = "Bearer $ApiKey" } else { $headers['X-Api-Key'] = $ApiKey }
    try {
        $r = Invoke-WebRequest -Uri ("$BaseUrl/api/v1/metadata") -Headers $headers -TimeoutSec $Timeout -UseBasicParsing
        return @{ Status=$r.StatusCode; Body=$r.Content; Mode=$mode }
    }
    catch {
        return @{ Status=0; Error=$_.Exception.Message; Mode=$mode }
    }
}

Write-Info 'Testando endpoint /api/v1/metadata ...'
$result = Test-Metadata $AuthType
if ($result.Status -eq 0 -or $result.Status -eq 401) {
    Write-Warn "Falha com modo '$AuthType' (Status: $($result.Status); Error: $($result.Error))"
    $alt = if ($AuthType -eq 'apikey') { 'bearer' } else { 'apikey' }
    Write-Info "Tentando novamente com modo alternativo: $alt"
    $resultAlt = Test-Metadata $alt
    if ($resultAlt.Status -ge 200 -and $resultAlt.Status -lt 300) {
        Write-Info "Sucesso com modo alternativo '$alt' (Status $($resultAlt.Status))"
        $AuthType = $alt
        $result = $resultAlt
    } else {
        Write-Err "Falha também com modo alternativo '$alt'. Verifique URL ou chave."
        Write-Warn "Detalhes alt: Status=$($resultAlt.Status) Error=$($resultAlt.Error)"
    }
}
else {
    Write-Info "Metadata OK (Status $($result.Status)) usando '$AuthType'"
}

if (-not $NoEnvWrite) {
    Write-Info 'Escrevendo arquivo .env (backup se existir)...'
    if (Test-Path $envFile) {
        Copy-Item $envFile ($envFile + '.bak') -Force
        Write-Info "Backup criado: $envFile.bak"
    }
    $lines = @(
        "ESPOCRM_BASE_URL=$BaseUrl",
        "ESPOCRM_API_KEY=$ApiKey",
        "ESPOCRM_AUTH_TYPE=$AuthType",
        "ESPOCRM_CONNECT_TIMEOUT=$ConnectTimeout",
        "ESPOCRM_TIMEOUT=$Timeout",
        "ESPOCRM_LOG=1"
    )
    $lines | Out-File -FilePath $envFile -Encoding UTF8 -Force
    Write-Info ".env atualizado"
} else {
    Write-Warn 'Skip gravação .env (--NoEnvWrite)'
}

Write-Info 'Exportando variáveis para sessão atual PowerShell.'
$env:ESPOCRM_BASE_URL = $BaseUrl
$env:ESPOCRM_API_KEY = $ApiKey
$env:ESPOCRM_AUTH_TYPE = $AuthType
$env:ESPOCRM_CONNECT_TIMEOUT = "$ConnectTimeout"
$env:ESPOCRM_TIMEOUT = "$Timeout"
$env:ESPOCRM_LOG = '1'

Write-Info 'Variáveis definidas:'
$show = 'ESPOCRM_BASE_URL','ESPOCRM_API_KEY','ESPOCRM_AUTH_TYPE','ESPOCRM_CONNECT_TIMEOUT','ESPOCRM_TIMEOUT','ESPOCRM_LOG'
foreach ($k in $show){ Write-Host ("  $k=" + ($env:$k)) }

if (-not $SkipViewTest) {
    Write-Info 'Teste da view (engine.php?class=EspoCrmView) requer servidor PHP ativo na porta 8080.'
    $running = (Get-NetTCPConnection -State Listen -ErrorAction SilentlyContinue | Where-Object { $_.LocalPort -eq 8080 })
    if (-not $running) {
        Write-Warn 'Porta 8080 não está escutando. Inicie seu servidor PHP antes do teste.'
    } else {
        Write-Info 'Consultando view...'
        try {
            $viewResp = Invoke-WebRequest -Uri 'http://127.0.0.1:8080/engine.php?class=EspoCrmView' -TimeoutSec 10 -UseBasicParsing
            Write-Info "View status: $($viewResp.StatusCode) (tamanho conteúdo: $($viewResp.Content.Length))"
        } catch { Write-Warn "Falha ao consultar view: $($_.Exception.Message)" }
    }
}

Write-Info 'Pronto. Se ESPOCRM_LOG=1, após usar a view verifique:'
Write-Host "  $logFile"
if (Test-Path $logFile) {
    Write-Info 'Último log de requisição:'
    Get-Content $logFile | Select-Object -First 40 | ForEach-Object { $_ }
}

if ($Verbose) {
    Write-Info 'Dump parcial do metadata recebido:'
    if ($result.Body) {
        $trim = $result.Body.Substring(0, [Math]::Min(500, $result.Body.Length))
        Write-Host $trim
    }
}

Write-Info 'Script finalizado.'
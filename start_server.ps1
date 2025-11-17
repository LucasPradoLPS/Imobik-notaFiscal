param(
    [int]$Port = 8080,
    [string]$DocRoot = "$PSScriptRoot\imobi_k_V2_12-04-2025",
    [switch]$NoBrowser,
    [switch]$Quiet
)

$ErrorActionPreference = 'Stop'

function Get-PhpPidsOnPort([int]$Port){
    netstat -ano | findstr ":$Port" | ForEach-Object {
        $parts = ($_ -split '\s+') | Where-Object { $_ -ne '' }
        if($parts.Length -ge 5){ $parts[-1] }
    } | Select-Object -Unique | ForEach-Object {
        try {
            $p = Get-Process -Id $_ -ErrorAction Stop
            if($p.Path -like '*php*'){ $p.Id }
        } catch { }
    } | Select-Object -Unique
}

try {
    if(-not (Test-Path $DocRoot)) { throw "DocRoot não encontrado: $DocRoot" }

    $existing = Get-PhpPidsOnPort $Port
    foreach($phpPid in $existing){
        try { Stop-Process -Id $phpPid -Force -ErrorAction SilentlyContinue } catch {}
    }

    if(-not $Quiet){ Write-Host "Iniciando servidor PHP em 127.0.0.1:$Port (root: $DocRoot)" -ForegroundColor Cyan }

    $logOutPath = Join-Path $PSScriptRoot 'php_server.out.log'
    $logErrPath = Join-Path $PSScriptRoot 'php_server.err.log'
    $args = @('-S',"127.0.0.1:$Port",'-t', $DocRoot)

    $proc = Start-Process -FilePath php -ArgumentList $args -PassThru -WindowStyle Hidden -RedirectStandardOutput $logOutPath -RedirectStandardError $logErrPath

    $started = $false
    for($i=0; $i -lt 10; $i++){
        Start-Sleep -Milliseconds 500
        $pids = Get-PhpPidsOnPort $Port
        if($pids){ $started = $true; break }
    }

    if(-not $started){ throw "Falha ao iniciar servidor na porta $Port" }

    if(-not $Quiet){ Write-Host "Servidor ativo. PID(s): $(($pids -join ', '))" -ForegroundColor Green }

    if(-not $NoBrowser){
        $url = "http://127.0.0.1:$Port/"
        if(-not $Quiet){ Write-Host "Abrindo navegador em $url" -ForegroundColor Yellow }
        Start-Process $url
    }

    if(-not $Quiet){ Write-Host "Logs: $logOutPath / $logErrPath" }
}
catch {
    Write-Error $_.Exception.Message
    exit 1
}
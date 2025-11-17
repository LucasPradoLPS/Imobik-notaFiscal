param(
    [int]$Port = 8080,
    [switch]$Quiet
)

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
    $pids = Get-PhpPidsOnPort $Port
    if(-not $pids){ if(-not $Quiet){ Write-Host "Nenhum servidor PHP na porta $Port" -ForegroundColor Yellow }; return }
    foreach($phpProcessId in $pids){
        try { Stop-Process -Id $phpProcessId -Force -ErrorAction SilentlyContinue } catch {}
    }
    if(-not $Quiet){ Write-Host "Encerrados PIDs: $(($pids -join ', '))" -ForegroundColor Green }
}
catch {
    Write-Error $_.Exception.Message
    exit 1
}
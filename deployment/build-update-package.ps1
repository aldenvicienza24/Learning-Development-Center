param(
    [switch] $IncludeBrowserActivation
)

$ErrorActionPreference = 'Stop'
$projectRoot = Split-Path -Parent $PSScriptRoot
if (-not (Test-Path -LiteralPath (Join-Path $projectRoot 'public/build/manifest.json'))) {
    throw 'Jalankan npm run build sebelum membuat paket.'
}
if ($IncludeBrowserActivation -and -not (Test-Path -LiteralPath (Join-Path $projectRoot 'dist/aktivasi-browser/aktifkan-update-uisi-20260918.php'))) {
    throw 'Salinan aktivator dengan hash kunci harus disiapkan terlebih dahulu.'
}
$stamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$stage = Join-Path $projectRoot "dist/update-$stamp"
$appStage = Join-Path $stage 'laravel'
$webStage = Join-Path $stage 'public_html'
New-Item -ItemType Directory -Force -Path $appStage, $webStage | Out-Null
foreach ($name in @('app', 'config', 'resources', 'routes', 'vendor', 'artisan', 'composer.json', 'composer.lock')) {
    Copy-Item -LiteralPath (Join-Path $projectRoot $name) -Destination $appStage -Recurse -Force
}
New-Item -ItemType Directory -Force -Path "$appStage/bootstrap/cache", "$appStage/database", "$appStage/analytics" | Out-Null
foreach ($name in @('app.php', 'providers.php')) {
    Copy-Item -LiteralPath (Join-Path $projectRoot "bootstrap/$name") -Destination "$appStage/bootstrap"
}
Copy-Item -LiteralPath (Join-Path $projectRoot 'database/migrations') -Destination "$appStage/database" -Recurse
Copy-Item -LiteralPath (Join-Path $projectRoot 'analytics/dashboard.py') -Destination "$appStage/analytics"
foreach ($name in @('build', 'images', 'vendor', '.htaccess', 'favicon.ico.png', 'favicon.svg', 'index.php', 'payment-reminders-sw.js', 'payment.webmanifest', 'robots.txt')) {
    Copy-Item -LiteralPath (Join-Path $projectRoot "public/$name") -Destination $webStage -Recurse -Force
}
$indexPath = Join-Path $webStage 'index.php'
$index = [IO.File]::ReadAllText($indexPath)
foreach ($name in @('storage', 'vendor', 'bootstrap')) {
    $index = $index.Replace("__DIR__.'/../$name", "__DIR__.'/../laravel/$name")
}
[IO.File]::WriteAllText($indexPath, $index, [Text.UTF8Encoding]::new($false))
composer install --working-dir="$appStage" --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-scripts --no-progress
if ($LASTEXITCODE -ne 0) { throw 'Gagal menyiapkan dependensi produksi.' }
Copy-Item -LiteralPath (Join-Path $PSScriptRoot 'UPDATE-HOSTING.md') -Destination $stage
if ($IncludeBrowserActivation) {
    Copy-Item -LiteralPath (Join-Path $projectRoot 'dist/aktivasi-browser/aktifkan-update-uisi-20260918.php') -Destination $webStage
    Copy-Item -LiteralPath (Join-Path $PSScriptRoot 'CARA-PASANG-PAKET-LENGKAP.txt') -Destination $stage
}
$archiveName = if ($IncludeBrowserActivation) { "uisi-hosting-siap-upload-$stamp.zip" } else { "uisi-update-$stamp.zip" }
$archivePath = Join-Path $projectRoot "dist/$archiveName"
Add-Type -AssemblyName System.IO.Compression.FileSystem
Add-Type -AssemblyName System.IO.Compression
$zipStream = [IO.File]::Open($archivePath, [IO.FileMode]::CreateNew)
$zipWriter = [IO.Compression.ZipArchive]::new($zipStream, [IO.Compression.ZipArchiveMode]::Create, $false)
try {
    foreach ($file in Get-ChildItem -LiteralPath $stage -Recurse -Force -File) {
        $relative = $file.FullName.Substring($stage.Length + 1).Replace('\', '/')
        [IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zipWriter, $file.FullName, $relative, [IO.Compression.CompressionLevel]::Optimal) | Out-Null
    }
} finally { $zipWriter.Dispose(); $zipStream.Dispose() }
$archive = [IO.Compression.ZipFile]::OpenRead($archivePath)
try {
    $forbidden = @($archive.Entries | Where-Object { $_.FullName -match '(^|/)(\.env|database\.sqlite|auth\.json)$|^(laravel/storage/|public_html/storage/|laravel/bootstrap/cache/.+)' })
    if ($forbidden.Count) { throw 'Paket berisi data atau cache yang tidak boleh diunggah.' }
    Write-Output "Paket terverifikasi: $archivePath"
    Write-Output ("Ukuran: {0:N1} MB; {1} file" -f ((Get-Item -LiteralPath $archivePath).Length / 1MB), $archive.Entries.Count)
} finally { $archive.Dispose() }

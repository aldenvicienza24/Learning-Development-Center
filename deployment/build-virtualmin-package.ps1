param(
    [string] $Domain = 'biz.partnership.uisi.ac.id',
    [string] $Account = 'biz.partnership'
)

$ErrorActionPreference = 'Stop'

$projectRoot = Split-Path -Parent $PSScriptRoot
$distRoot = Join-Path $projectRoot 'dist'
$stageRoot = Join-Path $distRoot ('.virtualmin-stage-' + [guid]::NewGuid().ToString('N'))
$laravelRoot = Join-Path $stageRoot 'laravel'
$publicRoot = Join-Path $stageRoot 'public_html'
$archivePath = Join-Path $distRoot ("uisi-$($Domain.Replace('.', '-'))-virtualmin.zip")

if (-not (Test-Path -LiteralPath (Join-Path $projectRoot 'public/build/manifest.json'))) {
    throw 'Aset Vite belum dibangun. Jalankan: npm run build'
}

New-Item -ItemType Directory -Force -Path $laravelRoot, $publicRoot | Out-Null

try {
    $applicationPaths = @(
        'app',
        'bootstrap',
        'config',
        'database',
        'resources',
        'routes',
        'vendor',
        'artisan',
        'composer.json',
        'composer.lock'
    )

    foreach ($relativePath in $applicationPaths) {
        Copy-Item -LiteralPath (Join-Path $projectRoot $relativePath) -Destination $laravelRoot -Recurse -Force
    }

    Get-ChildItem -LiteralPath (Join-Path $projectRoot 'public') -Force |
        Copy-Item -Destination $publicRoot -Recurse -Force

    $runtimeDirectories = @(
        'storage/app/private',
        'storage/framework/cache/data',
        'storage/framework/sessions',
        'storage/framework/testing',
        'storage/framework/views',
        'storage/logs'
    )

    foreach ($relativePath in $runtimeDirectories) {
        New-Item -ItemType Directory -Force -Path (Join-Path $laravelRoot $relativePath) | Out-Null
    }

    $uploadSource = Join-Path $projectRoot 'storage/app/public'
    $uploadDestination = Join-Path $publicRoot 'storage'
    New-Item -ItemType Directory -Force -Path $uploadDestination | Out-Null
    if (Test-Path -LiteralPath $uploadSource) {
        Get-ChildItem -LiteralPath $uploadSource -Force |
            Copy-Item -Destination $uploadDestination -Recurse -Force
    }

    $frontControllerPath = Join-Path $publicRoot 'index.php'
    $frontController = [IO.File]::ReadAllText($frontControllerPath)
    $frontController = $frontController.Replace("__DIR__.'/../storage", "__DIR__.'/../laravel/storage")
    $frontController = $frontController.Replace("__DIR__.'/../vendor", "__DIR__.'/../laravel/vendor")
    $frontController = $frontController.Replace("__DIR__.'/../bootstrap", "__DIR__.'/../laravel/bootstrap")
    [IO.File]::WriteAllText($frontControllerPath, $frontController, [Text.UTF8Encoding]::new($false))

    $appKeyBytes = New-Object byte[] 32
    $randomNumberGenerator = [Security.Cryptography.RandomNumberGenerator]::Create()
    try {
        $randomNumberGenerator.GetBytes($appKeyBytes)
    }
    finally {
        $randomNumberGenerator.Dispose()
    }
    $appKey = 'base64:' + [Convert]::ToBase64String($appKeyBytes)
    $homePath = "/home/$Account"
    $environment = @"
APP_NAME="UISI Pusat Layanan"
APP_ENV=production
APP_KEY=$appKey
APP_DEBUG=false
APP_URL=https://$Domain
APP_TIMEZONE=Asia/Jakarta

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

APP_MAINTENANCE_DRIVER=file
BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error

DB_CONNECTION=sqlite
DB_FOREIGN_KEYS=true

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
PUBLIC_STORAGE_PATH=$homePath/public_html/storage
QUEUE_CONNECTION=sync
CACHE_STORE=file

MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@$Domain"
MAIL_FROM_NAME="`${APP_NAME}"

VITE_APP_NAME="`${APP_NAME}"
"@
    [IO.File]::WriteAllText((Join-Path $laravelRoot '.env'), $environment, [Text.UTF8Encoding]::new($false))

    composer install --working-dir="$laravelRoot" --no-dev --prefer-dist --optimize-autoloader --no-interaction
    if ($LASTEXITCODE -ne 0) {
        throw "Composer gagal dengan exit code $LASTEXITCODE."
    }

    Copy-Item -LiteralPath (Join-Path $PSScriptRoot 'README-VIRTUALMIN.md') -Destination (Join-Path $stageRoot 'README-VIRTUALMIN.md') -Force

    if (Test-Path -LiteralPath $archivePath) {
        Remove-Item -LiteralPath $archivePath -Force
    }

    Get-ChildItem -LiteralPath $stageRoot -Force | Compress-Archive -DestinationPath $archivePath -CompressionLevel Optimal

    $archive = Get-Item -LiteralPath $archivePath
    [pscustomobject]@{
        Archive = $archive.FullName
        SizeMiB = [math]::Round($archive.Length / 1MB, 2)
        Domain = $Domain
        Account = $Account
    } | Format-List
}
finally {
    $resolvedDist = [IO.Path]::GetFullPath($distRoot).TrimEnd([IO.Path]::DirectorySeparatorChar) + [IO.Path]::DirectorySeparatorChar
    $resolvedStage = [IO.Path]::GetFullPath($stageRoot)
    if ((Test-Path -LiteralPath $stageRoot) -and $resolvedStage.StartsWith($resolvedDist, [StringComparison]::OrdinalIgnoreCase)) {
        Remove-Item -LiteralPath $stageRoot -Recurse -Force
    }
}

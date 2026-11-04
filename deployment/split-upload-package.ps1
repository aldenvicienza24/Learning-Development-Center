param(
    [string] $SourceArchive = (Join-Path (Split-Path -Parent $PSScriptRoot) 'hosting-virtualmin.zip'),
    [int64] $TargetCompressedBytes = 4500000
)

$ErrorActionPreference = 'Stop'

$projectRoot = Split-Path -Parent $PSScriptRoot
$outputRoot = Join-Path $projectRoot 'hosting-parts-small'
New-Item -ItemType Directory -Force -Path $outputRoot | Out-Null

Get-ChildItem -LiteralPath $outputRoot -Filter 'hosting-part-*.zip' -File -ErrorAction SilentlyContinue |
    Remove-Item -Force

Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$source = [IO.Compression.ZipFile]::OpenRead((Resolve-Path -LiteralPath $SourceArchive))
$partArchive = $null
$partStream = $null
$partNumber = 0
$estimatedSize = 0L

function Open-NextPart {
    if ($script:partArchive) {
        $script:partArchive.Dispose()
        $script:partStream.Dispose()
    }

    $script:partNumber++
    $partPath = Join-Path $outputRoot ('hosting-part-{0:D2}.zip' -f $script:partNumber)
    $script:partStream = [IO.File]::Open($partPath, [IO.FileMode]::CreateNew)
    $script:partArchive = [IO.Compression.ZipArchive]::new(
        $script:partStream,
        [IO.Compression.ZipArchiveMode]::Create,
        $false
    )
    $script:estimatedSize = 0L
}

try {
    Open-NextPart

    foreach ($sourceEntry in $source.Entries) {
        if ([string]::IsNullOrEmpty($sourceEntry.Name)) {
            continue
        }

        if ($estimatedSize -gt 0 -and ($estimatedSize + $sourceEntry.CompressedLength) -gt $TargetCompressedBytes) {
            Open-NextPart
        }

        $entryName = $sourceEntry.FullName.Replace('\', '/')
        $destinationEntry = $partArchive.CreateEntry($entryName, [IO.Compression.CompressionLevel]::Optimal)
        $sourceEntryStream = $sourceEntry.Open()
        $destinationEntryStream = $destinationEntry.Open()
        try {
            $sourceEntryStream.CopyTo($destinationEntryStream)
        }
        finally {
            $destinationEntryStream.Dispose()
            $sourceEntryStream.Dispose()
        }

        $estimatedSize += $sourceEntry.CompressedLength
    }
}
finally {
    if ($partArchive) {
        $partArchive.Dispose()
    }
    if ($partStream) {
        $partStream.Dispose()
    }
    $source.Dispose()
}

Get-ChildItem -LiteralPath $outputRoot -Filter 'hosting-part-*.zip' -File |
    Sort-Object Name |
    Select-Object Name, @{Name = 'SizeMiB'; Expression = { [math]::Round($_.Length / 1MB, 2) } } |
    Format-Table -AutoSize

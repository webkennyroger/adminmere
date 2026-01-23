
$ErrorActionPreference = "Stop"

function Get-RenderServiceId {
    param ($headers, $serviceName)
    $response = Invoke-RestMethod -Uri "https://api.render.com/v1/services" -Headers $headers
    $service = $response | Where-Object { $_.service.name -eq $serviceName } | Select-Object -ExpandProperty service
    return $service
}

function Update-RenderEnvVar {
    param ($headers, $serviceId, $key, $value)
    
    Write-Host "Checking $key..."
    $envVars = Invoke-RestMethod -Uri "https://api.render.com/v1/services/$serviceId/env-vars" -Headers $headers
    $existingVar = $envVars | Where-Object { $_.envVar.key -eq $key } | Select-Object -ExpandProperty envVar

    if ($existingVar) {
        Write-Host "Updating existing $key..."
        $body = @{ value = $value } | ConvertTo-Json
        Invoke-RestMethod -Uri "https://api.render.com/v1/services/$serviceId/env-vars/$($existingVar.id)" -Method Patch -Headers $headers -Body $body
    } else {
        Write-Host "Creating new $key..."
        $body = @{ key = $key; value = $value } | ConvertTo-Json
        Invoke-RestMethod -Uri "https://api.render.com/v1/services/$serviceId/env-vars" -Method Post -Headers $headers -Body $body
    }
    Write-Host "$key set to $value"
}

# --- Main Script ---

Write-Host "Render Deployment Fix Tool"
Write-Host "--------------------------"
Write-Host "This script will update your Render service environment variables to fix the connection issues."
Write-Host ""

$apiKey = Read-Host "1. Paste your Render API Key (HIDDEN)" -AsSecureString
$apiKeyPlain = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto([System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($apiKey))

if (-not $apiKeyPlain) {
    Write-Error "API Key is required."
    exit 1
}

$headers = @{
    "Authorization" = "Bearer $apiKeyPlain"
    "Accept"        = "application/json"
    "Content-Type"  = "application/json"
}

$serviceName = "adminmere"
Write-Host "Finding service '$serviceName'..."

try {
    $service = Get-RenderServiceId -headers $headers -serviceName $serviceName
    if (-not $service) {
        Write-Error "Service '$serviceName' not found. Make sure your Render service is named exactly '$serviceName'."
        exit 1
    }
    Write-Host "Found service: $($service.name) ($($service.id))"
} catch {
    Write-Error "Failed to connect to Render API. Check your API Key."
    Write-Error $_
    exit 1
}

Write-Host ""
Write-Host "2. Get your Pooler Host from Supabase:"
Write-Host "   Go to Supabase Dashboard -> Settings -> Database -> Connection Pooling."
Write-Host "   Copy the 'Host' (e.g., aws-0-us-east-1.pooler.supabase.com)"
$poolerHost = Read-Host "Paste the Pooler Host here"

if (-not $poolerHost) {
    Write-Error "Pooler Host is required to fix the connection."
    exit 1
}

try {
    # 1. Update DB_PORT to 6543
    Update-RenderEnvVar -headers $headers -serviceId $service.id -key "DB_PORT" -value "6543"

    # 2. Update DB_HOST to pooler host
    Update-RenderEnvVar -headers $headers -serviceId $service.id -key "DB_HOST" -value $poolerHost

    Write-Host ""
    Write-Host "SUCCESS! Environment variables updated."
    Write-Host "Render should automatically trigger a new deployment."
    Write-Host "Monitor the deployment URL: https://dashboard.render.com/web/$($service.id)"
} catch {
    Write-Error "An error occurred while updating variables."
    Write-Error $_
}

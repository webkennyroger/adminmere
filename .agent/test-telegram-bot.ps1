# Script de Diagnóstico do Bot Telegram
# Criado em: 2026-02-06

$botToken = "8206205202:AAHIvQDpwoFsACDWO-2LPuI6XREGcJiCMz8"

Write-Host "`n🦞 DIAGNÓSTICO DO BOT TELEGRAM" -ForegroundColor Cyan
Write-Host "================================`n" -ForegroundColor Cyan

# 1. Informações do Bot
Write-Host "1️⃣ Informações do Bot:" -ForegroundColor Yellow
$botInfo = Invoke-RestMethod -Uri "https://api.telegram.org/bot$botToken/getMe"
if ($botInfo.ok) {
    Write-Host "  ✅ Bot: @$($botInfo.result.username)" -ForegroundColor Green
    Write-Host "  ✅ Nome: $($botInfo.result.first_name)" -ForegroundColor Green
    Write-Host "  ✅ ID: $($botInfo.result.id)" -ForegroundColor Green
} else {
    Write-Host "  ❌ Erro ao obter informações do bot" -ForegroundColor Red
}

# 2. Status do Webhook
Write-Host "`n2️⃣ Status do Webhook:" -ForegroundColor Yellow
$webhookInfo = Invoke-RestMethod -Uri "https://api.telegram.org/bot$botToken/getWebhookInfo"
if ($webhookInfo.result.url -eq "") {
    Write-Host "  ✅ Webhook não configurado (modo polling - correto)" -ForegroundColor Green
} else {
    Write-Host "  ⚠️  Webhook configurado: $($webhookInfo.result.url)" -ForegroundColor Yellow
    Write-Host "  ⚠️  Isso pode impedir o bot de receber mensagens via polling!" -ForegroundColor Yellow
}

# 3. Updates Pendentes
Write-Host "`n3️⃣ Mensagens Pendentes:" -ForegroundColor Yellow
$updates = Invoke-RestMethod -Uri "https://api.telegram.org/bot$botToken/getUpdates"
if ($updates.result.Count -gt 0) {
    Write-Host "  ✅ $($updates.result.Count) mensagem(ns) encontrada(s)" -ForegroundColor Green
    Write-Host "`n  📨 Última mensagem:" -ForegroundColor Cyan
    $lastUpdate = $updates.result | Select-Object -Last 1
    if ($lastUpdate.message) {
        Write-Host "    De: @$($lastUpdate.message.from.username)" -ForegroundColor White
        Write-Host "    Chat ID: $($lastUpdate.message.chat.id)" -ForegroundColor White
        Write-Host "    Mensagem: $($lastUpdate.message.text)" -ForegroundColor White
        Write-Host "`n  💡 Use este comando para enviar mensagem de teste:" -ForegroundColor Magenta
        Write-Host "     Invoke-RestMethod -Uri `"https://api.telegram.org/bot$botToken/sendMessage?chat_id=$($lastUpdate.message.chat.id)&text=Teste do OpenClaw!`"" -ForegroundColor Gray
    }
} else {
    Write-Host "  ⚠️  Nenhuma mensagem pendente" -ForegroundColor Yellow
    Write-Host "  💡 Envie uma mensagem para @clawdbotmere_bot no Telegram e execute este script novamente" -ForegroundColor Cyan
}

# 4. Status do Gateway OpenClaw
Write-Host "`n4️⃣ Status do Gateway OpenClaw:" -ForegroundColor Yellow
try {
    $gatewayProcess = Get-Process -Name node -ErrorAction Stop
    Write-Host "  ✅ Gateway rodando (PID: $($gatewayProcess.Id))" -ForegroundColor Green
} catch {
    Write-Host "  ❌ Gateway não está rodando!" -ForegroundColor Red
    Write-Host "  💡 Execute: openclaw gateway" -ForegroundColor Cyan
}

Write-Host "`n================================" -ForegroundColor Cyan
Write-Host "Diagnóstico concluído!`n" -ForegroundColor Cyan

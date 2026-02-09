# 🦞 Guia de Configuração OpenClaw + Telegram

## ✅ Status da Instalação

### Componentes Instalados
- ✅ **OpenClaw CLI** - Versão 2026.2.3-1
- ✅ **Gateway** - Rodando em `http://127.0.0.1:18789`
- ✅ **Plugin Telegram** - Habilitado e configurado
- ✅ **Workspace** - `C:\Users\Defensoria\.openclaw\workspace`

### Configuração do Telegram
```json
{
  "telegram": {
    "enabled": true,
    "dmPolicy": "pairing",
    "botToken": "8206205202:AAHIvQDpwoFsACDWO-2LPuI6XREGcJiCMz8",
    "allowFrom": ["webkennyroger"],
    "groupPolicy": "allowlist",
    "streamMode": "partial"
  }
}
```

## 📱 Como Usar o Bot no Telegram

### 1. Encontrar o Bot
1. Abra o Telegram
2. Procure pelo nome do seu bot (você precisa ter criado ele com o BotFather)
3. Ou use o link direto se você tiver

### 2. Iniciar Conversa com o Bot
1. Envie `/start` para o bot
2. O bot deve responder e fazer o "pairing" com seu usuário `@webkennyroger`

### 3. Comandos Disponíveis
- Envie qualquer mensagem para o bot e ele processará como uma conversa com a AI
- O bot suporta mensagens diretas (DM)
- Pode ser adicionado a grupos (com allowlist)

## 🔧 Comandos Úteis do OpenClaw

### Verificar Status
```powershell
# Ver saúde geral do sistema
openclaw health

# Diagnóstico completo
openclaw doctor
```

### Gerenciar o Gateway
```powershell
# Iniciar Gateway
openclaw gateway

# Parar Gateway (Ctrl+C no terminal onde está rodando)
```

### Testar Envio de Mensagem via Telegram
```powershell
# Enviar uma mensagem de teste
openclaw message --channel telegram --target @webkennyroger "Olá do OpenClaw!"
```

### Gerenciar Hooks (Automações)
```powershell
# Listar hooks instalados
openclaw hooks list

# Procurar novos hooks
openclaw hooks

# Instalar um hook
openclaw hooks install <nome-do-hook>
```

### Skills (Ferramentas Adicionais)
```powershell
# Ver skills instaladas
openclaw skills

# Verificar dependências
openclaw skills check
```

## 🚀 Iniciar o OpenClaw Automaticamente

### Opção 1: Comando Manual
Sempre que quiser usar o OpenClaw, execute:
```powershell
Start-Process powershell -WindowStyle Hidden -ArgumentList "-Command", "openclaw gateway"
```

### Opção 2: Criar Atalho de Inicialização
1. Abra PowerShell como **Administrador**
2. Execute:
```powershell
openclaw onboard --install-daemon
```

Isso criará uma tarefa agendada que inicia o Gateway automaticamente no boot.

## 🔍 Solução de Problemas

### Gateway não responde
```powershell
# Verificar processos do OpenClaw
Get-Process | Where-Object {$_.ProcessName -like "*node*" -or $_.ProcessName -like "*openclaw*"}

# Reiniciar Gateway
# 1. Fechar o processo existente (se houver)
# 2. Iniciar novamente:
openclaw gateway
```

### Telegram não recebe mensagens
1. Verifique se o Gateway está rodando: `openclaw health`
2. Confirme que seu username do Telegram está na lista `allowFrom`
3. Verifique se fez o "pairing" inicial enviando `/start` para o bot

### Token do Bot Inválido
Se precisar atualizar o token do bot:
1. Abra: `C:\Users\Defensoria\.openclaw\openclaw.json`
2. Localize a seção `"channels" > "telegram" > "botToken"`
3. Substitua pelo novo token do BotFather
4. Reinicie o Gateway

## 📚 Recursos Adicionais

- **Documentação**: https://docs.openclaw.ai
- **CLI Reference**: https://docs.openclaw.ai/cli
- **Telegram Setup**: https://docs.openclaw.ai/cli/message

## 🎯 Próximos Passos

1. **Testar o Bot**: Envie uma mensagem para o bot no Telegram
2. **Explorar Hooks**: Configure automações para eventos específicos
3. **Adicionar Skills**: Instale ferramentas adicionais conforme necessário
4. **Configurar Grupos**: Se quiser usar em grupos do Telegram, adicione os IDs dos grupos na config

---

**Criado em**: 2026-02-06
**Versão OpenClaw**: 2026.2.3-1

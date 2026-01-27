# 🛑 PARE! VOCÊ ESTÁ NO LUGAR ERRADO

Você está digitando os comandos **dentro do servidor VPS** (a tela preta com `root@srv...`).
O servidor não consegue acessar o seu computador (disco C:\).

**Você precisa SAIR do servidor primeiro.**

## 1. Como Sair do VPS

No terminal onde aparece `root@srv1299798`, digite:

```bash
exit
```

E aperte ENTER.
O prompt deve mudar para algo como `PS C:\Users\Defensoria...`.

## 2. AGORA sim, baixe os arquivos

**Só depois** de sair (quando estiver no `PS C:\...`), rode o comando de download:

```powershell
scp -r root@76.13.168.33:/var/www/adminmere/* c:\Users\Defensoria\Herd\adminmere\
```

_(Digite a senha do VPS quando pedir)_

## 3. Depois, envie para o Git

Quando o download terminar (o terminal vai parar de passar letras e voltar ao prompt), rode:

```powershell
cd c:\Users\Defensoria\Herd\adminmere
git init
git add .
git commit -m "Backup versão VPS recuperada"
git branch -M main
git remote add origin https://github.com/webkennyroger/adminmere.git
git push -u origin main --force
```

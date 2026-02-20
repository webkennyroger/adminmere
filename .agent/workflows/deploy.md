---
description: Deployment command for production releases. Pre-flight checks and deployment execution.
---

# /deploy - Production Deployment

$ARGUMENTS

---

## Purpose

This command handles production deployment with pre-flight checks, deployment execution, and verification.

---

## 🚀 Deploy MERE App → GitHub + VPS

**Pasta local obrigatória:** `c:\Users\Defensoria\Herd\adminmere`

### Passo 1: Commit e Push para GitHub

// turbo

```
git add . && git commit -m "feat: <descrição da mudança>" && git push origin main
```

### Passo 2: Sincronizar e limpar cache no VPS

```
ssh -o StrictHostKeyChecking=no root@76.13.168.33 "cd /var/www/adminmere && git pull origin main && php artisan view:clear && php artisan cache:clear && php artisan config:clear && rm -rf storage/framework/views/*"
```

> Quando pedir senha, use: `Mere-887521.`

### ⚠️ ATENÇÃO

- Sempre rode os comandos a partir de `c:\Users\Defensoria\Herd\adminmere`
- NUNCA rode `git` a partir de `c:\var\www\adminmere` — essa é a pasta do servidor, não a local
- Se mudar arquivos PHP/Controllers, reinicie o PHP: `systemctl restart php8.3-fpm`

---

## Sub-commands

```
/deploy            - Interactive deployment wizard
/deploy check      - Run pre-deployment checks only
/deploy preview    - Deploy to preview/staging
/deploy production - Deploy to production
/deploy rollback   - Rollback to previous version
```

---

## Pre-Deployment Checklist

Before any deployment:

```markdown
## 🚀 Pre-Deploy Checklist

### Code Quality

- [ ] No TypeScript errors (`npx tsc --noEmit`)
- [ ] ESLint passing (`npx eslint .`)
- [ ] All tests passing (`npm test`)

### Security

- [ ] No hardcoded secrets
- [ ] Environment variables documented
- [ ] Dependencies audited (`npm audit`)

### Performance

- [ ] Bundle size acceptable
- [ ] No console.log statements
- [ ] Images optimized

### Documentation

- [ ] README updated
- [ ] CHANGELOG updated
- [ ] API docs current

### Ready to deploy? (y/n)
```

---

## Deployment Flow

```
┌─────────────────┐
│  /deploy        │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Pre-flight     │
│  checks         │
└────────┬────────┘
         │
    Pass? ──No──► Fix issues
         │
        Yes
         │
         ▼
┌─────────────────┐
│  Build          │
│  application    │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Deploy to      │
│  platform       │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Health check   │
│  & verify       │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  ✅ Complete    │
└─────────────────┘
```

---

## Output Format

### Successful Deploy

```markdown
## 🚀 Deployment Complete

### Summary

- **Version:** v1.2.3
- **Environment:** production
- **Duration:** 47 seconds
- **Platform:** Vercel

### URLs

- 🌐 Production: https://app.example.com
- 📊 Dashboard: https://vercel.com/project

### What Changed

- Added user profile feature
- Fixed login bug
- Updated dependencies

### Health Check

✅ API responding (200 OK)
✅ Database connected
✅ All services healthy
```

### Failed Deploy

```markdown
## ❌ Deployment Failed

### Error

Build failed at step: TypeScript compilation

### Details
```

error TS2345: Argument of type 'string' is not assignable...

```

### Resolution
1. Fix TypeScript error in `src/services/user.ts:45`
2. Run `npm run build` locally to verify
3. Try `/deploy` again

### Rollback Available
Previous version (v1.2.2) is still active.
Run `/deploy rollback` if needed.
```

---

## Platform Support

| Platform | Command                | Notes                     |
| -------- | ---------------------- | ------------------------- |
| Vercel   | `vercel --prod`        | Auto-detected for Next.js |
| Railway  | `railway up`           | Needs Railway CLI         |
| Fly.io   | `fly deploy`           | Needs flyctl              |
| Docker   | `docker compose up -d` | For self-hosted           |

---

## Examples

```
/deploy
/deploy check
/deploy preview
/deploy production --skip-tests
/deploy rollback
```

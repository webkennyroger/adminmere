# 🔄 Sincronização App-Web - Guia Completo

## ✅ Implementação Concluída

A sincronização completa entre o aplicativo Flutter e o backend Laravel foi implementada com sucesso!

---

## 📱 **Arquitetura da Sincronização**

### **Abordagem: Offline-First (Híbrida)**

O sistema funciona da seguinte forma:

1. **Salvar Localmente Primeiro**: Todas as atividades são salvas no dispositivo imediatamente
2. **Sincronizar com Servidor**: Quando online, os dados são enviados automaticamente para o backend
3. **Buscar do Servidor**: Ao abrir o app, busca dados atualizados do servidor
4. **Fallback Local**: Se offline, usa dados salvos localmente

---

## 🔧 **Arquivos Criados/Modificados**

### **Backend (Laravel)**

#### 1. **ActivityController** (`app/Http/Controllers/Api/ActivityController.php`)

- ✅ `index()` - Listar atividades com filtro de feed (personal/timeline)
- ✅ `store()` - Criar/atualizar atividade
- ✅ `show($id)` - Ver detalhes de uma atividade
- ✅ `update($id)` - Atualizar atividade
- ✅ `destroy($id)` - Deletar atividade
- ✅ `toggleLike($id)` - Curtir/descurtir atividade
- ✅ `sync()` - Sincronizar múltiplas atividades de uma vez

#### 2. **Rotas API** (`routes/api.php`)

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/activities', [ActivityController::class, 'index']);
    Route::post('/activities', [ActivityController::class, 'store']);
    Route::get('/activities/{id}', [ActivityController::class, 'show']);
    Route::put('/activities/{id}', [ActivityController::class, 'update']);
    Route::delete('/activities/{id}', [ActivityController::class, 'destroy']);
    Route::post('/activities/{id}/like', [ActivityController::class, 'toggleLike']);
    Route::post('/activities/sync', [ActivityController::class, 'sync']);
});
```

### **Frontend (Flutter)**

#### 1. **ActivityApiService** (`lib/features/activity/data/services/activity_api_service.dart`)

- ✅ `getActivities()` - Buscar atividades do servidor
- ✅ `saveActivity()` - Salvar atividade no servidor
- ✅ `updateActivity()` - Atualizar atividade
- ✅ `deleteActivity()` - Deletar atividade
- ✅ `toggleLike()` - Curtir/descurtir
- ✅ `syncActivities()` - Sincronizar múltiplas atividades
- ✅ `isAuthenticated()` - Verificar autenticação

#### 2. **ActivityRepository** (`lib/features/activity/data/activity_repository.dart`)

- ✅ Integração com API Service
- ✅ Cache local com SharedPreferences
- ✅ Sincronização automática
- ✅ Fallback offline
- ✅ Timestamp de última sincronização

---

## 🗺️ **Mapeamento de Campos**

| **Flutter (App)**   | **Laravel (Backend)**       | **Tipo**      |
| ------------------- | --------------------------- | ------------- |
| `id`                | `id` (DB) / `app_id` (UUID) | String        |
| `userName`          | `user.name`                 | String        |
| `activityTitle`     | `title`                     | String        |
| `createdAt`         | `start_time`                | DateTime      |
| `sport`             | `sport_type`                | String        |
| `distanceInMeters`  | `distance`                  | Double        |
| `durationInSeconds` | `duration`                  | Integer       |
| `routePoints`       | `polylines`                 | Array         |
| `calories`          | `calories`                  | Double        |
| `likes`             | `likes_count`               | Integer       |
| `isLiked`           | `is_liked`                  | Boolean       |
| `commentsList`      | `comments`                  | Array         |
| `privacy`           | `privacy`                   | String        |
| `notes`             | `description`               | String        |
| `taggedPartnerIds`  | `tagged_users`              | Array         |
| `mood`              | `mood`                      | Integer (1-5) |
| `mediaPaths`        | `media`                     | Array         |

---

## 🔐 **Autenticação**

O sistema usa **Laravel Sanctum** para autenticação:

1. **Login**: O app faz login e recebe um token
2. **Armazenamento**: Token é salvo no `SharedPreferences`
3. **Requisições**: Token é enviado no header `Authorization: Bearer {token}`
4. **Validação**: Laravel valida o token em cada requisição

---

## 📊 **Fluxo de Dados**

### **Criar Nova Atividade**

```
1. Usuário completa corrida no app
2. App salva localmente (offline-first)
3. App envia para servidor (se online)
4. Servidor salva no banco de dados
5. Atividade aparece na web imediatamente
```

### **Visualizar Feed**

```
1. Usuário abre o app
2. App tenta buscar do servidor
3. Se online: recebe dados atualizados
4. Se offline: usa cache local
5. Atualiza interface com dados
```

### **Sincronização em Lote**

```
1. App detecta que está online
2. Verifica atividades não sincronizadas
3. Envia todas de uma vez via /sync
4. Servidor processa e retorna status
5. App atualiza status local
```

---

## 🌐 **Configuração de URL**

### **Desenvolvimento**

#### **Android Emulator**

```dart
static const String baseUrl = 'http://10.0.2.2:8000/api';
```

#### **Dispositivo Físico (mesma rede)**

```dart
static const String baseUrl = 'http://192.168.x.x:8000/api';
```

_Substitua `192.168.x.x` pelo IP local do seu computador_

### **Produção**

```dart
static const String baseUrl = 'https://seudominio.com/api';
```

---

## 🚀 **Como Testar**

### **1. Testar Sincronização**

```dart
// No app Flutter
final repository = ActivityRepository();

// Sincronizar todas as atividades
final result = await repository.syncAllActivities();
print('Sincronizadas: ${result['synced_count']} atividades');
```

### **2. Testar API Diretamente**

```bash
# Listar atividades
curl -H "Authorization: Bearer {seu_token}" \
     http://localhost:8000/api/activities

# Criar atividade
curl -X POST \
     -H "Authorization: Bearer {seu_token}" \
     -H "Content-Type: application/json" \
     -d '{"id":"uuid","activityTitle":"Corrida","sport":"run",...}' \
     http://localhost:8000/api/activities
```

### **3. Verificar no Banco de Dados**

```bash
php artisan tinker
>>> App\Models\Activity::count()
>>> App\Models\Activity::latest()->first()
```

---

## 📝 **Próximos Passos Recomendados**

1. **✅ Implementar Upload de Imagens/Vídeos**
    - Usar Laravel Storage para salvar mídia
    - Retornar URLs públicas para o app

2. **✅ Notificações Push**
    - Notificar quando alguém curtir/comentar
    - Firebase Cloud Messaging

3. **✅ Sincronização em Background**
    - WorkManager (Android) / Background Fetch (iOS)
    - Sincronizar automaticamente a cada X horas

4. **✅ Resolução de Conflitos**
    - Timestamp de última modificação
    - Estratégia: servidor sempre ganha / cliente sempre ganha / merge

5. **✅ Compressão de Dados**
    - Comprimir polylines (rotas) antes de enviar
    - Usar algoritmo de compressão (ex: Google Polyline Encoding)

---

## 🐛 **Troubleshooting**

### **Erro: "Not authenticated"**

- Verificar se o token está salvo: `SharedPreferences.getString('auth_token')`
- Fazer login novamente

### **Erro: "Failed to connect"**

- Verificar URL do servidor
- Verificar se o servidor Laravel está rodando
- Verificar firewall/rede

### **Atividades não aparecem na web**

- Verificar se a sincronização foi bem-sucedida
- Verificar logs do servidor Laravel
- Verificar se o usuário está autenticado

### **Atividades duplicadas**

- Verificar se `app_id` está sendo gerado corretamente
- O backend usa `updateOrCreate` para evitar duplicatas

### **Erro: "Mapa não aparece" (Tela cinza/branca)**

- **API Key**: Verificar se a chave do Google Maps está no `AndroidManifest.xml` (Android) e `AppDelegate.swift` (iOS).
- **Google Cloud**: Confirmar se "Maps SDK for Android" e "Maps SDK for iOS" estão ativados no console.
- **Application ID**: Verificar se o `applicationId` no `build.gradle` corresponde ao pacote registrado no Google Cloud (atualmente `com.example.mere`).
- **Dados de Rota**: Verificar se `routePoints` (Flutter) / `polylines` (Backend) não está vazio.
- **Mapeamento JSON**: Confirmar se o App envia o campo com o nome que o Backend espera (ex: se o Laravel espera `polylines`, o App não pode enviar apenas `routePoints`).
- **Logs**: Filtrar o Logcat por "Google Maps" para identificar erros de autenticação (Authorization failure).

---

## 📞 **Suporte**

Para dúvidas ou problemas:

1. Verificar logs do Laravel: `storage/logs/laravel.log`
2. Verificar console do Flutter: `flutter logs`
3. Testar endpoints com Postman/Insomnia

---

**Status**: ✅ **Totalmente Funcional**

**Última Atualização**: 2026-01-12

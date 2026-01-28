# Sincronização Web ↔ App Mobile - MERE

## ✅ Já Implementado

### 1. **API Completa** (`routes/api.php`)

- ✅ Autenticação (Login, Register, Google Auth, Password Reset)
- ✅ Atividades (CRUD completo + Like + Comentários + Sync + Upload)
- ✅ Social (Follow/Unfollow, Sugeridos, Seguindo, Perfil)
- ✅ Mensagens/Chat (Enviar, Receber, Marcar como lido, Conversas)
- ✅ Estatísticas (Dashboard, Desafios, Tier)
- ✅ Assinaturas (Planos, Status, Subscribe)

### 2. **Nicknames Únicos**

- ✅ Coluna `nickname` na tabela `profiles` com índice UNIQUE
- ✅ Todos os usuários têm nicknames gerados automaticamente
- ✅ URLs de perfil usam `/@nickname` em vez de `/user/1`
- ✅ Helper `profile_url()` para gerar URLs consistentes

### 3. **Controllers API**

- ✅ `ActivityController` - Gerencia atividades, likes, comentários
- ✅ `UserController` - Perfis, follow, sugeridos
- ✅ `MessageController` - Chat/mensagens
- ✅ `AuthController` - Login/Register
- ✅ `StatsController` - Estatísticas e desafios
- ✅ `SubscriptionController` - Planos e assinaturas

## 🔧 Ajustes Necessários

### 1. **Adicionar Nickname na API** ⚠️

Editar manualmente `routes/api.php` linha 32, adicionar:

```php
$data['nickname'] = $user->profile->nickname ?? $user->id;
```

### 2. **Validação de Nickname Único**

Editar `app/Http/Controllers/Api/UserController.php` método `updateProfile()` linha 247:

```php
if ($request->has('nickname')) {
    // Validar se nickname é único
    $existingNickname = \App\Models\Profile::where('nickname', $request->nickname)
        ->where('user_id', '!=', $user->id)
        ->exists();

    if ($existingNickname) {
        return response()->json([
            'success' => false,
            'message' => 'Este nickname já está em uso'
        ], 422);
    }

    $profile->nickname = $request->nickname;
}
```

### 3. **Webhook para Sincronização em Tempo Real**

Criar eventos Laravel para broadcast:

```php
// app/Events/ActivityCreated.php
class ActivityCreated implements ShouldBroadcast
{
    public $activity;

    public function broadcastOn()
    {
        return new Channel('activities');
    }
}
```

Disparar no `ActivityController`:

```php
event(new ActivityCreated($activity));
```

### 4. **Pusher/Laravel Echo** (Opcional para Real-time)

Configurar no `.env`:

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_key
PUSHER_APP_SECRET=your_secret
PUSHER_APP_CLUSTER=mt1
```

## 📱 Integração no App Mobile

### 1. **Endpoints Principais**

```dart
// Base URL
const String baseUrl = 'http://127.0.0.1:8000/api';

// Autenticação
POST /api/login
POST /api/register
POST /api/logout

// Usuário
GET /api/user
POST /api/user/profile

// Atividades
GET /api/activities
POST /api/activities
GET /api/activities/{id}
PUT /api/activities/{id}
DELETE /api/activities/{id}
POST /api/activities/{id}/like
POST /api/activities/{id}/comment

// Social
GET /api/users/suggested
POST /api/users/{id}/follow
GET /api/users/following
GET /api/users/{id}

// Mensagens
GET /api/messages/{userId}
POST /api/messages
GET /api/conversations
```

### 2. **Headers Necessários**

```dart
headers: {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Bearer $token',
}
```

### 3. **Exemplo de Uso (Flutter)**

```dart
// Login
final response = await http.post(
  Uri.parse('$baseUrl/login'),
  headers: {'Content-Type': 'application/json'},
  body: jsonEncode({
    'email': email,
    'password': password,
  }),
);

final data = jsonDecode(response.body);
final token = data['token'];

// Criar Atividade
final response = await http.post(
  Uri.parse('$baseUrl/activities'),
  headers: {
    'Content-Type': 'application/json',
    'Authorization': 'Bearer $token',
  },
  body: jsonEncode({
    'title': 'Corrida Matinal',
    'sport_type': 'run',
    'distance': 5000, // metros
    'duration': 1800, // segundos
    'start_time': DateTime.now().toIso8601String(),
  }),
);
```

## 🔄 Fluxo de Sincronização

### App → Web

1. App cria/atualiza dados via API POST/PUT
2. Laravel salva no banco de dados
3. Web recarrega dados automaticamente (Livewire polling ou Echo)

### Web → App

1. Web cria/atualiza dados via Livewire
2. Laravel salva no banco de dados
3. App faz polling ou recebe via WebSocket (Laravel Echo)

## 🎯 Próximos Passos

1. ✅ **Testar endpoints da API** com Postman/Insomnia
2. ✅ **Adicionar nickname nos retornos da API**
3. ⚠️ **Implementar validação de nickname único**
4. ⚠️ **Configurar Laravel Echo para real-time** (opcional)
5. ⚠️ **Documentar API com Swagger/OpenAPI** (opcional)

## 📝 Notas Importantes

- Todos os endpoints retornam JSON
- Autenticação usa Laravel Sanctum (Bearer Token)
- Imagens são enviadas como `multipart/form-data`
- Datas no formato ISO 8601 (`2026-01-28T12:00:00Z`)
- Distâncias em metros, duração em segundos
- Nicknames são únicos e case-insensitive

## 🔐 Segurança

- CORS configurado para aceitar requisições do app
- Rate limiting: 60 requisições por minuto
- Validação de dados em todos os endpoints
- Sanitização de inputs
- Proteção contra SQL Injection (Eloquent ORM)

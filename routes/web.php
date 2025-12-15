<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\Chat\ChatApp;
use App\Livewire\Schedule\ScheduleIndex;
use App\Livewire\Challenges\ChallengeIndex;
use App\Livewire\Categories\CategoryIndex;
use App\Livewire\Users\UserIndex;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    // Regular users go to profile, admins/managers see dashboard
    if (!auth()->user()->isAdmin() && !auth()->user()->isManager()) {
        return redirect()->route('profile');
    }
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // ===== ADMIN/MANAGER ONLY ROUTES =====
    Route::middleware(['check.admin.or.manager'])->group(function () {
        // Rota da Agenda/Calendário
        Route::get('/schedule', ScheduleIndex::class)->name('schedule.index');
    
    // API routes for calendar events
    Route::get('/api/events', function () {
        return response()->json(
            \App\Models\Schedule::where('user_id', auth()->id())
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'start' => $event->event_date->format('Y-m-d'),
                        'end' => $event->event_date->format('Y-m-d'),
                        'extendedProps' => [
                            'calendar' => $event->color ?? 'Primary',
                            'description' => $event->description,
                            'photo' => $event->photo,
                            'time' => $event->event_time,
                        ]
                    ];
                })
        );
    })->name('api.events.index');
    
    Route::post('/api/events', function (\Illuminate\Http\Request $request) {
        $data = [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description ?? '',
            'event_date' => $request->start_date,
            'event_time' => $request->event_time ?? '00:00',
            'color' => $request->event_level ?? 'Primary',
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('events', 'public');
        }
        
        $event = \App\Models\Schedule::create($data);
        
        return response()->json(['id' => $event->id, 'success' => true]);
    })->name('api.events.store');
    
    Route::put('/api/events/{id}', function (\Illuminate\Http\Request $request, $id) {
        $event = \App\Models\Schedule::where('user_id', auth()->id())->findOrFail($id);
        
        $data = [
            'title' => $request->title,
            'description' => $request->description ?? '',
            'event_date' => $request->start_date,
            'event_time' => $request->event_time ?? '00:00',
            'color' => $request->event_level ?? 'Primary',
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('events', 'public');
        }
        
        $event->update($data);
        
        return response()->json(['success' => true]);
    })->name('api.events.update');
    
    Route::delete('/api/events/{id}', function ($id) {
        $event = \App\Models\Schedule::where('user_id', auth()->id())->findOrFail($id);
        $event->delete();
        
        return response()->json(['success' => true]);
    })->name('api.events.destroy');
        
        // Rota de Gerenciamento de Desafios Mensais
        Route::get('/challenges', ChallengeIndex::class)->name('challenges.index');
        
        // Rota de Gerenciamento de Categorias
        Route::get('/categories', CategoryIndex::class)->name('categories.index');
        Route::view('/categories/create', 'livewire.categories.create')->name('categories.create');
        Route::get('/categories/{category}/edit', function ($category) {
            return view('livewire.categories.edit', compact('category'));
        })->name('categories.edit');
        
        // Goals (Metas)
        Route::get('/goals', \App\Livewire\Goals\GoalIndex::class)->name('goals.index');

        // Subscriptions (Assinaturas)
        Route::get('/subscriptions', \App\Livewire\Subscriptions\SubscriptionIndex::class)->name('subscriptions.index');

        // Rota de Gerenciamento de Usuários
        Route::get('/users', UserIndex::class)->name('users.index');
        Route::get('/users/{user}', function (\App\Models\User $user) {
            return view('pages.profile.profile-index', compact('user'));
        })->name('users.show');
    });
    
    // ===== PUBLIC ROUTES (All authenticated users) =====
    // Rota do Aplicativo de Chat
    Route::get('/chat', ChatApp::class)->name('chat.index');
    
    // Rota do Perfil do Usuário
    Route::get('/profile', \App\Livewire\Profile\UserProfile::class)->name('profile');




    // Rota para o componente Support/Index
    Route::get('/support', \App\Livewire\Support\SupportIndex::class)->name('support.index');
    Route::post('/support', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'subject' => 'required|min:5|max:100',
            'priority' => 'required|in:low,medium,high',
            'message' => 'required|min:10',
        ]);
        
        \App\Models\Support::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'priority' => $request->priority,
            'message' => $request->message,
            'status' => 'pending',
        ]);
        
        return redirect()->route('support.list')->with('status', 'Ticket criado com sucesso!');
    })->name('support.store');
    
    Route::get('/support-list', \App\Livewire\Support\SupportList::class)->name('support.list');
    
    Route::get('/support/{support}', \App\Livewire\Support\SupportShow::class)->name('support.show');
    Route::post('/support/{support}/reply', function (\App\Models\Support $support, \Illuminate\Http\Request $request) {
        // Ensure user owns the ticket or is admin
        if ($support->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }
        
        $request->validate([
            'message' => 'required|string|min:2'
        ]);
        
        $support->replies()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);
        
        return redirect()->route('support.show', $support)->with('message', 'Resposta enviada com sucesso!');
    })->name('support.reply');
    
    Route::patch('/support/{support}/status', function (\App\Models\Support $support, \Illuminate\Http\Request $request) {
        if (!auth()->user()->is_admin) {
            abort(403);
        }
        
        $request->validate([
            'status' => 'required|in:open,pending,resolved,closed'
        ]);
        
        $support->update(['status' => $request->status]);
        
        return redirect()->route('support.show', $support)->with('message', 'Status atualizado com sucesso!');
    })->name('support.update-status');
    Route::redirect('/support-show', '/support-show'); 

    // Rotas de faq
    Route::view('/faq', 'pages.faq')->name('faq');
    // Rotas de coming
    Route::view('/coming', 'pages.coming-soon')->name('coming');





    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    // Volt::route('/test-volt', function () {
    //     return 'Volt Routing Works';
    // });
});

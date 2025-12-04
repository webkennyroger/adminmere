<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;
// use App\Models\SupportTicket; // Crie este Model se for salvar no banco de dados

new #[Layout('layouts.app', ['title' => 'Suporte e Ajuda'])] class extends Component 
{
    // Propriedades do Formulário
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

    // Regras de Validação
    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ];

    public function submitSupportForm()
    {
        // 1. Validação dos dados
        $this->validate();

        // 2. Lógica de Envio
        // Exemplo: Salvar no Banco de Dados (se você tiver um modelo SupportTicket)
        /*
        SupportTicket::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);
        */
        
        // Exemplo: Enviar E-mail (se você tiver uma classe Mailable)
        // Mail::to('support@seuapp.com')->send(new SupportRequestMail($this->name, $this->email, $this->subject, $this->message));


        // 3. Feedback e Redirecionamento
        session()->flash('status', 'Sua solicitação de suporte foi enviada com sucesso! Responderemos em breve.');

        // Limpa o formulário após o envio
        $this->reset(['name', 'email', 'subject', 'message']);

        // Opcional: Redirecionar para uma página de confirmação
        // return $this->redirect(route('dashboard'), navigate: true);
    }
}; 

?>
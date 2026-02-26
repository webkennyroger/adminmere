# Resumo de Alterações - 26 de Fevereiro de 2026

## 🚀 O que foi concluído hoje

### 🌐 Ambiente Web (Laravel & Livewire)

**1. Correções no Comentário e Upload de Mídia:**

- **Remoção de Outlines/Bordas Duplas:** Limpamos as imperfeições visuais (`focus-within`) e a borda preta do campo de comentário para dar o aspecto de "pílula contínua" ao input.
- **Correção do Bug `ERRO 500` ao enviar Imagem:** Descobrimos que a presença de vários botões de upload de comentários gerava IDs duplicados no HTML (`commentImage-1`). O sistema não sabia qual foto associar a qual input e isso causava falha interna no Livewire. Alteramos a estrutura para incluir o `class_basename` e sanamos o problema.
- **Validação Visível de Erros:** Adicionamos as diretivas `@error` logo abaixo do input. Se a imagem enviada passar de 10MB ou o comentário não puder ser processado, o site vai apontar em vermelho ao invés de simplesmente "não fazer nada" ou estourar a tela.

**2. Visualização Dinâmica do Mapa do Google:**

- Em atividades mais antigas, o aplicativo Flutter inseria as coordenadas (lat, lng), mas não salvava a _polyline_ formatada que a API do Google aceitava. Atualizamos o `Component` do feed. Se o mapa não achar uma `summary_polyline`, ele pega as coordenadas isoladas brutas e as costura dinamicamente (`color:0xff0000ff|weight:4|lat,lng...`) em uma string "pipe" até o limite suportado na URL, corrigindo assim o bug visual de "Mapa indisponível".

### 📱 Ambiente Mobile (App Flutter)

**1. Tela Vermelha de Crash Resolvida:**

- Corrigimos graves falhas de formatação (Typecasting Exception) na renderização ao baixar o feed de postagens e atividades (`ActivityData.fromJson` e `PostData.fromJson`). Muitas imagens vinham mastigadas em um formato de _String jsonificada_, estourando erro ao invés de listar. Adicionamos suporte de _Fallback_ que renderiza com segurança a timeline independente de sujeiras no banco de dados.

**2. Nova Regra Dinâmica no Envio de Comentários:**

- A lógica de upload de imagens (Câmera, Galeria) nos comentários foi reescrita. O botão de "_Enviar_" ficava travado caso não existisse texto digitado (Mesmo com a foto escolhida). Passamos a utilizar um observador inteligente (`ListenableBuilder`) integrado com o _TextField_ para habilitar e acender o botão de submeter o comentário assim que _QUALQUER_ mídia (foto ou texto) surgir.
- Após o disparo do comentário, a nova mensagem atualiza o layout em tempo real (Refresh SetState com objeto unificado formatado).

---

## 🎯 Próximos Passos

- **Realizar os Testes Finais:** Confirmar que no celular e na web o envio de comentários, anexos e edição estão perfeitamente rodando sem mais travas.
- Ajustar o que for necessário para manter o Layout consistente através das telas seguindo o seu design focado na realeza do verde bandeira da sua UI.

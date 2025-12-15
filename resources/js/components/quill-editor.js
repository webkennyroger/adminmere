/**
 * Quill Editor - Componente Alpine.js
 * Editor de texto rico integrado com Livewire
 */

export function initQuillEditor() {
    document.addEventListener('alpine:init', () => {
        Alpine.data('quillEditor', (
            model, // wire:model
            elementId, // ID único
            initialValue = '', // valor do backend
            livewireComponent // para emitir eventos
        ) => ({
            quill: null,
            content: initialValue,

            init() {
                // Aguardar Quill carregar do CDN
                if (typeof window.Quill === 'undefined') {
                    console.error('Quill não está carregado. Certifique-se de que o script CDN está incluído.');
                    return;
                }

                this.quill = new window.Quill(this.$refs.editor, {
                    theme: 'snow',
                    placeholder: this.$el.getAttribute('placeholder') || 'Escreva algo...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ 'header': 1 }, { 'header': 2 }],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            [{ 'script': 'sub' }, { 'script': 'super' }],
                            [{ 'indent': '-1' }, { 'indent': '+1' }],
                            [{ 'direction': 'rtl' }],
                            [{ 'size': ['small', false, 'large', 'huge'] }],
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'font': [] }],
                            [{ 'align': [] }],
                            ['clean']
                        ]
                    }
                });

                // Definir conteúdo inicial
                if (this.content) {
                    this.quill.root.innerHTML = this.content;
                }

                // Sincronizar mudanças com Livewire
                this.quill.on('text-change', () => {
                    this.content = this.quill.root.innerHTML;
                    
                    // Atualizar wire:model
                    if (model) {
                        this.$wire.set(model, this.content);
                    }
                    
                    // Despachar evento para outros listeners
                    this.$dispatch('input', this.content);
                });

                // Escutar atualizações externas (ex: do Livewire)
                this.$watch('content', (value) => {
                    if (this.quill.root.innerHTML !== value) {
                        this.quill.root.innerHTML = value;
                    }
                });
                
                // Escutar evento customizado para resetar/atualizar conteúdo
                window.addEventListener('update-quill-event-description', (e) => {
                    if (e.detail.id === elementId) {
                        this.quill.root.innerHTML = e.detail.content;
                    }
                });
            }
        }));
    });
}

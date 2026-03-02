@props(['label' => null, 'height' => 'h-48', 'name' => null, 'value' => '', 'id' => null])

@php
 $wireModel = $attributes->whereStartsWith('wire:model')->first();
@endphp

<div wire:ignore x-data="{
 content: @if($wireModel) @entangle($attributes->wire('model')) @else {{ json_encode($value) }} @endif,
 quill: null,
 init() {
 const editor = this.$refs.editor;
 
 this.quill = new Quill(editor, {
 theme: 'snow',
 placeholder: '{{ addslashes($attributes->get('placeholder', 'Digite aqui...')) }}',
 modules: {
 toolbar: [
 ['bold', 'italic', 'underline', 'strike'],
 ['blockquote', 'code-block'],
 [{ 'header': 1 }, { 'header': 2 }],
 [{ 'list': 'ordered'}, { 'list': 'bullet' }],
 [{ 'indent': '-1'}, { 'indent': '+1' }],
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

 if (this.content) {
 this.quill.root.innerHTML = this.content;
 }

 this.quill.on('text-change', () => {
 this.content = this.quill.root.innerHTML;
 if (this.$refs.hiddenInput) {
 this.$refs.hiddenInput.value = this.content;
 this.$refs.hiddenInput.dispatchEvent(new Event('input'));
 }
 });

 this.$watch('content', (value) => {
 if (value !== this.quill.root.innerHTML) {
 this.quill.root.innerHTML = value || '';
 }
 });

 if (this.$refs.hiddenInput) {
 const input = this.$refs.hiddenInput;
 const descriptor = Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value');
 const self = this;
 
 Object.defineProperty(input, 'value', {
 get: function() { 
 return descriptor.get.call(this); 
 },
 set: function(val) {
 descriptor.set.call(this, val);
 if (self.quill && val !== self.quill.root.innerHTML) {
 self.content = val;
 self.quill.root.innerHTML = val || '';
 }
 }
 });
 }
 }
 }" class="w-full" {{ $attributes->whereDoesntStartWith(['wire:model', 'class', 'id']) }}>

 @if($label)
 <label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-400">
 {{ $label }}
 </label>
 @endif

 <div
 class="relative bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-700 overflow-hidden">
 <div x-ref="editor" class="{{ $height }} text-zinc-800 dark:text-zinc-200" style="font-family: inherit;"></div>
 </div>

 @if($name)
 <input type="hidden" name="{{ $name }}" x-ref="hiddenInput" value="{{ $value }}" @if($id) id="{{ $id }}" @endif>
 @endif

 <style>
 .ql-toolbar.ql-snow {
 border-top-left-radius: 0.5rem;
 border-top-right-radius: 0.5rem;
 border-color: #e4e4e7;
 }

 .dark .ql-toolbar.ql-snow {
 background-color: #18181b;
 border-color: #3f3f46;
 }

 .ql-container.ql-snow {
 border-bottom-left-radius: 0.5rem;
 border-bottom-right-radius: 0.5rem;
 border-color: #e4e4e7;
 background-color: transparent;
 }

 .dark .ql-container.ql-snow {
 border-color: #3f3f46;
 background-color: #18181b;
 color: #e4e4e7;
 }

 .dark .ql-stroke {
 stroke: #a1a1aa !important;
 }

 .dark .ql-fill {
 fill: #a1a1aa !important;
 }

 .dark .ql-picker {
 color: #a1a1aa !important;
 }

 .dark .ql-picker-options {
 background-color: #18181b !important;
 border-color: #3f3f46 !important;
 }

 /* Placeholder Color: text-gray-400 */
 .ql-editor.ql-blank::before {
 color: #9ca3af !important;
 font-style: normal !important;
 }

 /* Dark Mode Placeholder: text-white/30 */
 .dark .ql-editor.ql-blank::before {
 color: rgba(255, 255, 255, 0.3) !important;
 }
 </style>
</div>
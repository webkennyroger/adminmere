<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75" 
                     wire:click="closeModal" aria-hidden="true"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white dark:bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="saveEvent">
                        <div class="bg-white dark:bg-zinc-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                    {{ $editMode ? 'Editar Evento' : 'Criar Novo Evento' }}
                                </h3>
                            </div>

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Título <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="title" 
                                       wire:model.defer="title"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white"
                                       placeholder="Nome do evento">
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Descrição
                                </label>
                                <textarea id="description" 
                                          wire:model.defer="description"
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white"
                                          placeholder="Descrição do evento"></textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Date and Time -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="event_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Data <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" 
                                           id="event_date" 
                                           wire:model.defer="event_date"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white">
                                    @error('event_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="event_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Hora <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" 
                                           id="event_time" 
                                           wire:model.defer="event_time"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white">
                                    @error('event_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Color Picker -->
                            <div class="mb-4">
                                <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cor do Evento <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="color" 
                                           id="color" 
                                           wire:model.defer="color"
                                           class="h-10 w-20 cursor-pointer rounded border border-gray-300 dark:border-zinc-700">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $color }}</span>
                                </div>
                                @error('color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Photo Upload -->
                            <div class="mb-4">
                                <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Foto do Evento
                                </label>
                                
                                @if($existingPhoto && !$photo)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $existingPhoto) }}" 
                                             alt="Foto atual" 
                                             class="h-32 w-32 object-cover rounded-md border border-gray-300 dark:border-zinc-700">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Foto atual</p>
                                    </div>
                                @endif

                                @if($photo)
                                    <div class="mb-3">
                                        <img src="{{ $photo->temporaryUrl() }}" 
                                             alt="Preview" 
                                             class="h-32 w-32 object-cover rounded-md border border-gray-300 dark:border-zinc-700">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nova foto</p>
                                    </div>
                                @endif

                                <input type="file" 
                                       id="photo" 
                                       wire:model="photo"
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white">
                                @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                
                                <div wire:loading wire:target="photo" class="text-sm text-blue-500 mt-1">
                                    Carregando...
                                </div>
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="bg-gray-50 dark:bg-zinc-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ $editMode ? 'Atualizar' : 'Criar' }}
                            </button>
                            
                            @if($editMode)
                                <button type="button"
                                        wire:click="deleteEvent"
                                        wire:confirm="Tem certeza que deseja excluir este evento?"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                    Excluir
                                </button>
                            @endif
                            
                            <button type="button"
                                    wire:click="closeModal"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-zinc-600 shadow-sm px-4 py-2 bg-white dark:bg-zinc-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                    Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

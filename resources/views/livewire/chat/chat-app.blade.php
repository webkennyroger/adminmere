<div x-data="{ chat: 'aberto' }">
    <x-common.page-breadcrumb title="Chat" />
    <!-- Conteúdo Principal -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md transition-transform shadow-md overflow-hidden !p-0 col-span-12 md:col-span-4 xl:col-span-3">
            <div class="flex items-center justify-between gap-2 px-5 pt-5 pb-4">
                <div class="flex items-center gap-4">
                    <div class=" h-10 w-10 rounded-full overflow-hidden flex items-center justify-center">
                        <img alt="image" loading="lazy" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                    </div>
                    <div class="">
                        <h6 class="text-base mb-0">Mere app</h6>
                        <p class="mb-0 text-green-500 dark:text-green-100">Disponível</p>
                    </div>
                </div>
                <button class="cursor-pointer" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="20" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-ellipsis-vertical text-zinc-500 dark:text-zinc-100">
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="12" cy="5" r="1"></circle>
                        <circle cx="12" cy="19" r="1"></circle>
                    </svg>
                </button>
            </div>
            <div class="flex h-full w-full flex-col overflow-hidden rounded-md">
                <div class="border-t border-zinc-200">
                    <div class="flex h-12 items-center gap-2 border-b px-3">
                        <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-search size-4 shrink-0 opacity-50">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input class="placeholder:text-muted-foreground flex h-16 w-full rounded-md bg-transparent py-3 text-sm outline-hidden disabled:cursor-not-allowed disabled:opacity-50"
                            placeholder="Buscar..." id="" type="text" value="" >
                    </div>
                </div>
                <div class="scroll-py-1 overflow-x-hidden overflow-y-auto max-h-[580px]">
                    <a class="flex items-center justify-between gap-2 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700 px-6 py-2.5 w-full active"
                        href="#">
                        <div class="flex items-center gap-2">
                            <div class="">
                                    <img class="h-10 w-10 rounded-full" alt="image" loading="lazy" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                            </div>
                            <div class="info">
                                <h6 class="text-sm mb-1 line-clamp-1">Kathryn Murphy</h6>
                                <p class="mb-0 text-xs line-clamp-1">hey! there i'm...</p>
                            </div>
                        </div>
                        <div class="shrink-0 text-end">
                            <p class="mb-0 text-zinc-400 text-xs lh-1">12:30 PM</p><span
                                class="w-4 h-4 text-xs rounded-full bg-yellow-500 text-white inline-flex items-center justify-center">8</span>
                        </div>
                    </a>
                   
                    <a class="flex items-center justify-between gap-2 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700 px-6 py-2.5 w-full active"
                        href="#">
                        <div class="flex items-center gap-2">
                            <div class="">
                                    <img class="h-10 w-10 rounded-full" alt="image" loading="lazy" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                            </div>
                            <div class="info">
                                <h6 class="text-sm mb-1 line-clamp-1">Kathryn Murphy</h6>
                                <p class="mb-0 text-xs line-clamp-1">hey! there i'm...</p>
                            </div>
                        </div>
                        <div class="shrink-0 text-end">
                            <p class="mb-0 text-zinc-400 text-xs lh-1">12:30 PM</p><span
                                class="w-4 h-4 text-xs rounded-full bg-yellow-500 text-white inline-flex items-center justify-center">8</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class=" col-span-12 md:col-span-8 xl:col-span-9">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md transition-transform overflow-hidden !p-0 flex flex-col">
                <div class="flex items-center justify-between gap-2  px-6 py-2.5 active border-b border-zinc-200 dark:border-zinc-600">
                    <div class="flex items-center gap-2">
                        <div class="h-10 w-10 rounded-full overflow-hidden flex items-center justify-center">
                           <img alt="image" loading="lazy" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                        </div>
                        <div class="info">
                            <h6 class="text-base mb-0">Mere app</h6>
                            <p class="mb-0 text-green-500 dark:text-green-100">Disponível</p>
                        </div>
                    </div>
                    <div class="action inline-flex items-center gap-3">
                        <button class=" items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive active:scale-[.95] cursor-pointer shadow-xs h-9 px-4 py-2 has-[&gt;svg]:px-3 text-xl text-zinc-600 dark:text-zinc-200 flex !p-0 bg-transparent hover:bg-transparent"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-phone text-zinc-500 dark:text-zinc-100">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </button>
                        <button class="items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive active:scale-[.95] cursor-pointer shadow-xs h-9 px-4 py-2 has-[&gt;svg]:px-3 text-xl text-zinc-600 dark:text-zinc-200 flex !p-0 bg-transparent hover:bg-transparent"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-video text-zinc-500 dark:text-zinc-100">
                                <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5">
                                </path>
                                <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                            </svg>
                        </button>
                        <button class="cursor-pointer" type="button" id="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-ellipsis-vertical text-zinc-500 dark:text-zinc-100">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="chat-message-list max-h-[568px] overflow-y-auto flex flex-col p-6 gap-6">
                    <div class="max-w-[700px] duration-500 text-zinc-900 flex items-end gap-3">
                       <img class="h-10 w-10 object-cover rounded-full" alt="image" loading="lazy" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                        <div class="bg-zinc-50 dark:bg-zinc-800 dark:text-white rounded-2xl rounded-es-none p-5">
                            <p class="mb-3">Olá!</p>
                            <p class="chat-time mb-0 text-xs text-end text-zinc-500 dark:text-zinc-100">
                                <span>6:30 pm</span>
                            </p>
                        </div>
                    </div>
                    <div class="max-w-[700px] duration-500 ms-auto text-white">
                        <div class="bg-green-300 rounded-2xl rounded-ee-none p-5">
                            <p class="mb-3">Olá! Prazer em conhecê-lo(a)! Como vai, querido(a)?</p>
                            <p class="chat-time mb-0 text-xs"><span>6:31 pm</span></p>
                        </div>
                    </div>
                    <div class="max-w-[700px] duration-500 text-zinc-900 flex items-end gap-3">
                        <img class="h-10 w-10 object-cover rounded-full" alt="image" loading="lazy" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                        <div class="bg-zinc-50 dark:bg-zinc-800 dark:text-white rounded-2xl rounded-es-none p-5">
                            <p class="mb-3">Estou muito bem. E você?</p>
                            <p class="chat-time mb-0 text-xs text-end text-zinc-500 dark:text-zinc-100">
                                <span>6:32 pm</span>
                            </p>
                        </div>
                    </div>
                    <div class="max-w-[700px] duration-500 ms-auto text-white">
                        <div class="bg-green-300 rounded-2xl rounded-ee-none p-5">
                            <p class="mb-3">Eu também estou muito bem. E você, como estão seus estudos?</p>
                            <p class="chat-time mb-0 text-xs"><span>6:33 pm</span></p>
                        </div>
                    </div>
                    <div class="max-w-[700px] duration-500 text-zinc-900 flex items-end gap-3">
                      <img class="h-10 w-10 object-cover rounded-full" alt="image" loading="lazy" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                        <div class="bg-zinc-50 dark:bg-zinc-800 dark:text-white rounded-2xl rounded-es-none p-5">
                            <p class="mb-3">Meus estudos estão indo bem. Há alguns dias fiz minha prova final e meu resultado já foi divulgado.</p>
                            <p class="chat-time mb-0 text-xs text-end text-zinc-500 dark:text-zinc-100">
                                <span>6:34 pm</span>
                            </p>
                        </div>
                    </div>
                    <div class="max-w-[700px] duration-500 ms-auto text-white">
                        <div class="bg-green-300 rounded-2xl rounded-ee-none p-5">
                            <p class="mb-3">Que ótimo! E o seu resultado?</p>
                            <p class="chat-time mb-0 text-xs"><span>6:35 pm</span></p>
                        </div>
                    </div>
                    <div class="max-w-[700px] duration-500 text-zinc-900 flex items-end gap-3">
                        <img class="h-10 w-10 object-cover rounded-full" alt="image" loading="lazy" src="{{ asset('assets/images/users/avatar-2.jpg') }}">
                        <div class="bg-zinc-50 dark:bg-zinc-800 dark:text-white rounded-2xl rounded-es-none p-5">
                            <p class="mb-3">Eu tirei nota máxima (A+) no exame.</p>
                            <p class="chat-time mb-0 text-xs text-end text-zinc-500 dark:text-zinc-100">
                                <span>6:36 pm</span>
                            </p>
                        </div>
                    </div>
                    <div class="max-w-[700px] duration-500 ms-auto text-white">
                        <div class="bg-green-300 rounded-2xl rounded-ee-none p-5">
                            <p class="mb-3">Uau!! Que notícia!</p>
                            <p class="chat-time mb-0 text-xs"><span>6:37 pm</span></p>
                        </div>
                    </div>
                </div>
                <form class="flex items-center justify-between py-4 border-t border-zinc-200 dark:border-zinc-600 mt-auto px-3">
                    <textarea class="border-input placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive flex field-sizing-content min-h-16 w-full rounded-md text-base transition-[color,box-shadow] outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm border-0 focus:border-0 grow bg-white dark:bg-transparent focus:outline-none focus:ring-0 py-2 px-3 focus-visible:ring-0 resize-none shadow-none h-5" name="" placeholder="Escreva uma mensagem..." required=""></textarea>
                    <div class="chat-message-box-action flex items-center gap-4">
                        <label class="items-center gap-2 font-medium select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 text-xl flex !p-0 bg-transparent hover:bg-transparent cursor-pointer"
                            for="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-link text-zinc-500 dark:text-zinc-100 hover:text-green-300">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                            </svg>
                            <input class="file:text-foreground placeholder:text-muted-foreground selection:bg-green-300 selection:text-green-300-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive"
                                id="addAttachment" hidden="" type="file">
                        </label>
                        <label class="items-center gap-2 font-medium select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 text-xl flex !p-0 bg-transparent hover:bg-transparent cursor-pointer"
                            for="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-image text-zinc-500 dark:text-zinc-100 hover:text-green-300">
                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                <circle cx="9" cy="9" r="2"></circle>
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                            </svg>
                            <input class="file:text-foreground placeholder:text-muted-foreground selection:bg-green-300 selection:text-green-300-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive"
                                id="addImage" hidden="" type="file">
                        </label>
                        <button class="justify-center whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*='size-'])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive active:scale-[.95] cursor-pointer bg-green-300 text-green-300-foreground shadow-xs hover:bg-green-300/90 dark:text-white h-9 px-4 py-2 has-[&gt;svg]:px-3 rounded-lg inline-flex items-center gap-1"
                            type="submit">
                            Enviar
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send">
                                <path
                                    d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z">
                                </path>
                                <path d="m21.854 2.147-10.94 10.939"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
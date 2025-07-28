<header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex-1 max-w-lg">
                        <div class="relative">
                            <input type="text" placeholder="rechercher transaction..." class="w-full pl-4 pr-12 py-3 bg-gray-100 border-0 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-maxit text-gray-600">
                            <svg class="absolute right-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <div class="bg-gray-light text-black px-4 py-2 rounded-lg font-bold text-sm">
                                <div class="text-sm text-gray-600"><?=  $this->session->get('comptes', 'numerocompte') ?></div>
                        </div>
                        
                            <img src="./assets/icons/notif.svg" alt="user" class="w-7 h-7">
                       
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gray-light rounded-full flex items-center justify-center mr-3">
                                <div class="w-8 h-8 bg-orange-500 rounded-full"></div>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800"><?= $this->session->get('user', 'prenom')  .' ' . $this->session->get('user', 'nom')?></div>
                                <div class="text-sm text-gray-600"><?=  $this->session->get('comptes', 'numero') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
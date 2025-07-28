
        <div class=" lg:flex lg:w-1/4  relative overflow-hidden">
            <div class="w-full relative">
                <div class="absolute inset-7  bg-gray-200 opacity-90"></div>
                
                <div class="relative z-10 flex flex-col justify-center items-center h-full p-8">
                    <div class="bg-orange-500 rounded-full w-80 h-80 flex flex-col items-center justify-center mb-12 shadow-2xl">
                        <h1 class="text-white text-4xl font-bold text-center leading-tight logo-shadow">
                            Mon appli<br>
                            du quotidien
                        </h1>
                    </div>
                    
                    <div class="absolute bottom-8 left-8">
                        <div class="bg-orange-500 rounded-lg p-4 shadow-lg">
                            <span class="text-white text-2xl font-bold">MaxiI</span>
                        </div>
                    </div>
                </div>
                
                <div class="absolute top-1/3 right-1/4 w-4 h-4 bg-white rounded-full opacity-60"></div>
                <div class="absolute top-1/2 right-1/3 w-3 h-3 bg-black rounded-full opacity-40"></div>
                <div class="absolute bottom-1/3 left-1/4 w-2 h-2 bg-white rounded-full opacity-80"></div>
            </div>
        </div>
        
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-xl max-h-[70%] w-full space-y-8">
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-block bg-orange-500 rounded-lg p-3 shadow-lg">
                        <span class="text-white text-xl font-bold">Maxit</span>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl card-shadow p-8 border border-orange-200">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-orange-600 mb-2">Connectez-vous</h2>
                        <p class="text-gray-600">Connectez-vous pour accéder à votre espace<br>MAXITSA</p>
                    </div>
                    
                    <form class="space-y-6" action="login" method="post">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Login
                            </label>
                            <input 
                                type="login" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-200 bg-gray-50"
                                placeholder="Entrez votre login"
                                name="login"
                            >
                            <?php if(!empty($_SESSION['errors']['login'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['login']; ?> <p>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mot de passe
                            </label>
                            <input 
                                type="password" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none input-focus transition-all duration-200 bg-gray-50"
                                placeholder="Entrez votre mot de passe"
                                name="password"
                            >
                            <?php if(!empty($_SESSION['errors']['password'])): ?>
                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                            <p class="text-sm text-white "><?= $_SESSION['errors']['password']; ?> <p>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <button 
                            type="submit" 
                            class="w-full bg-orange-600 text-white py-3 px-4 rounded-lg font-medium btn-hover transition-all duration-200 shadow-lg"
                        >
                            Connexion
                        </button>
                    </form>
                    
                    <div class="text-center mt-6">
                        <p class="text-gray-600">
                            Vous n'avez pas de compte ? 
                            <a href="/comptePrincipal" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-200">
                                Créer un compte
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

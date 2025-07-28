<div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-custom overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <div class="lg:w-1/2 bg-gradient-to-br from-gray-800 to-gray-900 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-40"></div>
                    <div class="relative z-10 p-8 h-full flex flex-col justify-center">
                        <div class="text-white mb-8">
                            <h1 class="text-4xl lg:text-5xl font-bold mb-4">
                                Max tes offres<br>
                                <span class="text-orange-500">et services</span>
                            </h1>
                            <div class="flex items-center mb-6">
                                <div class="bg-orange-500 p-2 rounded mr-3">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <span class="text-2xl font-bold">Max it</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-center items-center flex-1">
                            <div class="relative">
                                <div class="w-48 h-80 bg-gradient-orange rounded-3xl shadow-2xl transform rotate-12 relative overflow-hidden">
                                    <div class="absolute top-4 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-black rounded-full opacity-20"></div>
                                    <div class="p-6 pt-8 text-white text-center">
                                        <div class="text-sm font-semibold mb-2">Max it</div>
                                        <div class="text-xs opacity-90">Tes offres et services</div>
                                    </div>
                                </div>
                                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-orange-500 rounded-full opacity-20"></div>
                            </div>
                        </div>
                        
                        <div class="text-white text-sm mt-8">
                            <p class="mb-2">Test Orange au même temps</p>
                            <p>avec la nouvelle application</p>
                            <div class="flex items-center mt-4 space-x-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-white rounded mr-2"></div>
                                    <span class="text-xs">Disponible sur</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-white rounded mr-2"></div>
                                    <span class="text-xs">App Store</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2 p-8">
                    <div class="max-w-md mx-auto">
                        <form class="space-y-6" action="principalCreated" method="post" enctype="multipart/form-data">
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Numéro CNI</label>
                                <div class="relative">
                                    <input type="text" 
                                           name="numeroCNI" 
                                           id="numeroCNI"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                                           placeholder="Entrez le numéro CNI et appuyez sur Entrée">
                                    <div id="loading" class="absolute right-3 top-1/2 transform -translate-y-1/2 loading hidden"></div>
                                </div>
                                
                                <button type="button" 
                                        id="searchBtn"
                                        class="mt-2 w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                                    🔍 Rechercher CNI
                                </button>
                                
                                <div id="cni-error" class="flex items-center mt-2 bg-red-400 justify-center px-4 py-2 rounded-md hidden">
                                    <p class="text-sm text-white">CNI non trouvée dans la base de données</p>
                                </div>
                                
                                <div id="cni-success" class="flex items-center mt-2 bg-green-400 justify-center px-4 py-2 rounded-md hidden">
                                    <p class="text-sm text-white">Citoyen trouvé ! Informations pré-remplies.</p>
                                </div>
                                
                                <?php if(!empty($_SESSION['errors']['numeroCNI'])): ?>
                                    <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white"><?= $_SESSION['errors']['numeroCNI']; ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                                    <input type="text" name="prenom" id="prenom" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" readonly>
                                    <?php if(!empty($_SESSION['errors']['prenom'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                            <p class="text-sm text-white"><?= $_SESSION['errors']['prenom']; ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                    <input type="text" name="nom" id="nom" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors" readonly>
                                    <?php if(!empty($_SESSION['errors']['nom'])): ?>
                                        <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                            <p class="text-sm text-white"><?= $_SESSION['errors']['nom']; ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Login</label>
                                <input type="text" name="login" id="login" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                <?php if(!empty($_SESSION['errors']['login'])): ?>
                                    <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white"><?= $_SESSION['errors']['login']; ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                <?php if(!empty($_SESSION['errors']['password'])): ?>
                                    <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white"><?= $_SESSION['errors']['password']; ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo identité recto</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition-colors cursor-pointer">
                                        <input type="file" accept="image/*" name="photoRecto">
                                        <p class="text-gray-500 text-sm">Télécharger l'image</p>
                                        <?php if(!empty($_SESSION['errors']['photoRecto'])): ?>
                                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                                <p class="text-sm text-white"><?= $_SESSION['errors']['photoRecto']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo identité verso</label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition-colors cursor-pointer">
                                        <input type="file" accept="image/*" name="photoVerso">
                                        <p class="text-gray-500 text-sm">Télécharger l'image</p>
                                        <?php if(!empty($_SESSION['errors']['photoVerso'])): ?>
                                            <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                                <p class="text-sm text-white"><?= $_SESSION['errors']['photoVerso']; ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <input type="text" name="adresse" id="adresse" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                <?php if(!empty($_SESSION['errors']['adresse'])): ?>
                                    <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white"><?= $_SESSION['errors']['adresse']; ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                <input type="text" name="telephone" id="telephone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                <?php if(!empty($_SESSION['errors']['telephone'])): ?>
                                    <div class="flex items-center mt-1 bg-red-400 justify-center px-4 py-2 rounded-md">
                                        <p class="text-sm text-white"><?= $_SESSION['errors']['telephone']; ?></p>
                                    </div>comptePrincipal
                                <?php endif; ?>
                            </div>
                            
                            <button type="submit" class="w-full bg-gradient-orange text-white font-bold py-4 px-6 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                Enregistrer
                            </button>
                        </form>
                        <a href="/" class="mt-3 text-orange-500 hover:text-orange-600 transition-colors">
                            <p class="">J'ai déjà un compte</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    document.getElementById('searchBtn').addEventListener('click', function () {
    const cni = document.getElementById('numeroCNI').value.trim();

    document.getElementById('cni-error').classList.add('hidden');
    document.getElementById('cni-success').classList.add('hidden');

    if (cni !== '') {
        fetch(`https://appdafapi.onrender.com/api/citoyens/${cni}`)
            .then(response => {
                if (!response.ok) throw new Error("CNI non trouvée");
                return response.json();
            })
            .then(data => {
                if (data && data.data) {
                    const citoyen = data.data;

                    document.getElementById('prenom').value = citoyen.prenom || '';
                    document.getElementById('nom').value = citoyen.nom || '';
                    document.getElementById('adresse').value = citoyen.adresse || '';
                    document.getElementById('telephone').value = citoyen.telephone || '';

                    document.getElementById('cni-success').classList.remove('hidden');
                } else {
                    document.getElementById('cni-error').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error("Erreur :", error);
                document.getElementById('cni-error').classList.remove('hidden');
            });
    }
});
</script>


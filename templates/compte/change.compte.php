<!-- Section pour changer de compte principal -->
<div class="bg-gray-50 p-6 rounded-lg border border-gray-200 my-6">
    <h3 class="text-lg font-semibold mb-4 flex items-center">
        <span class="mr-2">🔄</span>
        Changer de compte principal
    </h3>
    
    <div class="mb-4">
        <label for="searchCompte" class="block text-sm font-medium text-gray-700 mb-2">
            Rechercher un compte secondaire (par numéro) :
        </label>
        <input 
            type="text" 
            id="searchCompte" 
            placeholder="Tapez le numéro du compte..." 
            autocomplete="off"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        >
        <div id="comptesList" class="hidden max-h-48 overflow-y-auto border border-gray-300 border-t-0 bg-white rounded-b-md"></div>
    </div>
    
    <div id="compteSelectionne" class="hidden bg-blue-50 p-4 rounded-md border border-blue-200 mt-4">
        <p class="mb-2">
            <span class="font-semibold">Compte sélectionné :</span> 
            <span id="nomCompteSelectionne" class="text-blue-700"></span>
        </p>
        <p class="mb-2">
            <span class="font-semibold">Numéro :</span> 
            <span id="numeroCompteSelectionne" class="text-blue-600"></span>
        </p>
        <p class="mb-2">
            <span class="font-semibold">Solde :</span> 
            <span id="soldeCompteSelectionne" class="text-green-600"></span>
        </p>
        <p class="text-yellow-600 text-sm mb-4 flex items-center">
            <span class="mr-1">⚠️</span>
            Ce compte deviendra votre compte principal
        </p>
        
        <form method="POST" action="<?= APP_URL ?>/changerEnComptePrincipal">
            <input type="hidden" id="compteIdInput" name="compteId" value="">
            <button 
                type="submit" 
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md mr-2 transition-colors"
            >
                Confirmer le changement
            </button>
            <button 
                type="button" 
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors" 
                onclick="annulerSelection()"
            >
                Annuler
            </button>
        </form>
    </div>
</div>




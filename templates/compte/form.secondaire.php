    <div class="container mx-auto mt-9 px-4 py-8 align-self-center">
        <div class="max-w-md mx-auto bg-gray-200 rounded-xl shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-center">Créer un Compte Secondaire</h1>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['errors']['general'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= $_SESSION['errors']['general'] ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="secondaireCreated" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Numéro de téléphone *
                    </label>
                    <input 
                        type="text" 
                        name="telephone" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        value="<?= isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : '' ?>"
                        required
                    >
                    <?php if (isset($_SESSION['errors']['telephone'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $_SESSION['errors']['telephone'] ?></p>
                    <?php endif; ?>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Solde initial (optionnel)
                    </label>
                    <input 
                        type="number" 
                        name="solde" 
                        min="0" 
                        step="0.01" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        value="<?= isset($_POST['solde']) ? htmlspecialchars($_POST['solde']) : '0' ?>"
                    >
                    <?php if (isset($_SESSION['errors']['solde'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $_SESSION['errors']['solde'] ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="flex gap-4 pt-4">
                    <a href="<?= APP_URL ?>/compte" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md text-center hover:bg-gray-400">
                        Annuler
                    </a>
                    <button type="submit" class="flex-1 bg-orange-500 text-white py-2 px-4 rounded-md hover:bg-orange-600">
                        Créer le compte
                    </button>
                </div>
            </form>
        </div>
    </div>
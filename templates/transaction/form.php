<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - Transaction de Dépôt</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-gray-100 rounded-lg shadow-lg p-8 w-full mx-auto max-w-md">
        <div id="successMessage" class="hidden mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
            ✅ <span id="successText">Transaction enregistrée avec succès !</span>
        </div>

        <div id="loadingIndicator" class="hidden mb-4 p-4 bg-gray-100 border border-gray-400 text-gray-700 rounded-md text-center">
            <div class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Traitement en cours...
            </div>
        </div>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
        ❌ <?= htmlspecialchars($_SESSION['error_message']); ?>
        <?php unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
        ✅ <?= htmlspecialchars($_SESSION['success_message']); ?>
        <?php unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>


        <form id="transactionForm" class="space-y-6" method="POST" action="createTransaction">
            <div id="frais-info" class="hidden mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
    <div class="text-sm text-yellow-800">
        <div>💰 <strong>Récapitulatif du transfert :</strong></div>
        <div class="mt-1">
            <span>Montant à transférer : <span id="montant-display">0</span> FCFA</span><br>
            <span>Frais de transfert : <span id="frais-display">0</span> FCFA</span><br>
            <strong>Total à débiter : <span id="total-display">0</span> FCFA</strong>
        </div>
    </div>
</div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Type de transaction
                </label>
                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-700">
                    📤 Dépôt entre comptes
                </div>
                <input type="hidden" name="typeTransaction" value="depot">
            </div>

            <div>
                <label for="compte_expediteur_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Compte expéditeur *
                </label>
                <select
                    id="compte_expediteur_id"
                    name="compte_expediteur_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                >
                    <option value="">Sélectionnez le compte expéditeur</option>
                    

                    <?php if (isset($comptesClient)) : ?>
                        <?php foreach ($comptesClient as $compte) : ?>
                            <option value="<?= htmlspecialchars($compte['compte_id']) ?>" 
                                    data-type="<?= htmlspecialchars($compte['typecompte']) ?>"
                                    data-solde="<?= htmlspecialchars($compte['solde']) ?>"
                                    <?= (isset($_SESSION['form_data']['compte_expediteur_id']) && $_SESSION['form_data']['compte_expediteur_id'] == $compte['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($compte['numerocompte']) ?> - 
                                <?= htmlspecialchars($compte['typecompte']) ?> 
                                (<?= number_format($compte['solde'], 0, ',', ' ') ?> FCFA)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="compte_destinataire_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Compte destinataire *
                </label>
                <select
                    id="compte_destinataire_id"
                    name="compte_destinataire_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                >
                    <option value="">Sélectionnez le compte destinataire</option>
                    
                   
                    <?php if (isset($allComptes)) : ?>
                        <?php foreach ($allComptes as $compte) : ?>
                            <option value="<?= htmlspecialchars($compte['compte_id']) ?>"
                                    data-type="<?= htmlspecialchars($compte['typecompte']) ?>"
                                    data-solde="<?= htmlspecialchars($compte['solde']) ?>"
                                    <?= (isset($_SESSION['form_data']['compte_destinataire_id']) && $_SESSION['form_data']['compte_destinataire_id'] == $compte['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($compte['numerocompte']) ?> - 
                                <?= htmlspecialchars($compte['typecompte']) ?>
                                (<?= number_format($compte['solde'], 0, ',', ' ') ?> FCFA)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="montant" class="block text-sm font-medium text-gray-700 mb-2">
                    Montant (FCFA) *
                </label>
                <input
                    type="number"
                    id="montant"
                    name="montant"
                    placeholder="0"
                    min="1"
                    step="1"
                    value="<?= isset($_SESSION['form_data']['montant']) ? htmlspecialchars($_SESSION['form_data']['montant']) : '' ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                >
            </div>

            <div>
                <label for="libelle" class="block text-sm font-medium text-gray-700 mb-2">
                    Libellé (optionnel)
                </label>
                <input
                    type="text"
                    id="libelle"
                    name="libelle"
                    placeholder="Description de la transaction"
                    maxlength="255"
                    value="<?= isset($_SESSION['form_data']['libelle']) ? htmlspecialchars($_SESSION['form_data']['libelle']) : 'Dépôt entre comptes' ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                >
            </div>

            <div class="flex space-x-4 pt-4">
                <button
                    type="button"
                    onclick="resetForm()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors"
                >
                    Annuler
                </button>
                <button
                    type="submit"
                    id="submitButton"
                    class="flex-1 px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                >
                    Effectuer le dépôt
                </button>
            </div>
        </form>

    </div>

    <script>
function calculerEtAfficherFrais() {
    const compteExp = document.getElementById('compte_expediteur_id').value;
    const compteDest = document.getElementById('compte_destinataire_id').value;
    const montant = parseFloat(document.getElementById('montant').value) || 0;
    
    if (compteExp && compteDest && montant > 0) {
        fetch('/calculer-frais', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `compte_expediteur_id=${compteExp}&compte_destinataire_id=${compteDest}&montant=${montant}`
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('montant-display').textContent = new Intl.NumberFormat('fr-FR').format(data.montant);
                document.getElementById('frais-display').textContent = new Intl.NumberFormat('fr-FR').format(data.frais);
                document.getElementById('total-display').textContent = new Intl.NumberFormat('fr-FR').format(data.total);
                document.getElementById('frais-info').classList.remove('hidden');
            }
        });
    } else {
        document.getElementById('frais-info').classList.add('hidden');
    }
}

document.getElementById('compte_expediteur_id').addEventListener('change', calculerEtAfficherFrais);
document.getElementById('compte_destinataire_id').addEventListener('change', calculerEtAfficherFrais);
document.getElementById('montant').addEventListener('input', calculerEtAfficherFrais);
</script>


</body>
</html>
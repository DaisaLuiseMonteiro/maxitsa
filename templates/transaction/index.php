   <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900">Liste des transactions</h1>
            
            <!-- Formulaire de recherche -->
            <!-- Remplacez le formulaire actuel par celui-ci -->
<form method="post" action="/listTransactions" class="flex gap-4">
    <div class="relative">
        <input 
            type="date" 
            name="date_filter"
            value="<?= htmlspecialchars($dateFilter ?? '') ?>"
            placeholder="Rechercher par date" 
            class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>
    
    <div class="relative">
        <select 
            name="type_filter"
            class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">Tous les types</option>
            <?php foreach ($typesDisponibles as $type): ?>
                <option value="<?= htmlspecialchars($type) ?>" 
                        <?= ($typeFilter === $type) ? 'selected' : '' ?>>
                    <?= htmlspecialchars(ucfirst($type)) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
        Rechercher
    </button>
    
    <a href="/listTransactions" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
        Réinitialiser
    </a>
</form>

        </div>
        
        <?php if ($dateFilter || $typeFilter): ?>
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                <div class="text-sm text-blue-800">
                    <strong>Filtres actifs :</strong>
                    <?php if ($dateFilter): ?>
                        <span class="inline-block bg-blue-100 px-2 py-1 rounded mr-2">
                            Date: <?= htmlspecialchars($dateFilter) ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($typeFilter): ?>
                        <span class="inline-block bg-blue-100 px-2 py-1 rounded mr-2">
                            Type: <?= htmlspecialchars($typeFilter) ?>
                        </span>
                    <?php endif; ?>
                    <span class="text-blue-600">(<?= count($transactions) ?> résultat(s))</span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type transaction</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Libellé</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date transaction</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (empty($transactions)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Aucune transaction trouvée
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($transactions as $transaction): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 rounded">
                                <?= htmlspecialchars($transaction['typetransaction']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 text-xs font-medium text-orange-600 bg-orange-100 rounded-full border border-orange-200">
                                <?= number_format($transaction['montant'], 0, ',', ' ') ?> FCFA
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <?= htmlspecialchars($transaction['libelle']) ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <?= date('d/m/Y H:i', strtotime($transaction['datetransaction'])) ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php 
                            $status = $transaction['status'];
                            if ($status === 'annulee'): ?>
                                <span class="inline-block px-2 py-1 text-xs font-medium text-red-600 bg-red-100 rounded">
                                    Annulée
                                </span>
                            <?php elseif ($status === true || $status === 't'): ?>
                                <span class="inline-block px-2 py-1 text-xs font-medium text-green-600 bg-green-100 rounded">
                                    Confirmée
                                </span>
                            <?php else: ?>
                                <span class="inline-block px-2 py-1 text-xs font-medium text-yellow-600 bg-yellow-100 rounded">
                                    En attente
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php 
                            $peutAnnuler = in_array($transaction['typetransaction'], ['depot', 'depot_entrant', 'depot_sortant']) 
                                        && ($transaction['status'] === false || $transaction['status'] === 'f' || $transaction['status'] === null)
                                        && $transaction['status'] !== 'annulee';
                            
                            $dateTransaction = new DateTime($transaction['datetransaction']);
                            $maintenant = new DateTime();
                            $diff = $maintenant->diff($dateTransaction);
                            $peutAnnuler = $peutAnnuler && $diff->days < 1;
                            ?>
                            
                            <?php if ($peutAnnuler): ?>
    <form method="POST" action="/listTransactions" style="display: inline;">
        <input type="hidden" name="action" value="annuler">
        <input type="hidden" name="transaction_id" value="<?= $transaction['id'] ?>">
        <button type="submit" 
                onclick="return confirm('Êtes-vous sûr de vouloir annuler cette transaction ?')"
                class="px-3 py-1 text-xs font-medium text-red-600 bg-red-50 border border-red-200 rounded hover:bg-red-100 transition-colors">
            Annuler
        </button>
    </form>
<?php else: ?>
    <span class="text-xs text-gray-400">Non annulable</span>
<?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 border border-gray-300 rounded text-gray-500 hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">1</button>
                    <span class="px-2 text-gray-500">/</span>
                    <span class="px-2 text-gray-500">4</span>
                    <button class="px-3 py-1 border border-gray-300 rounded text-gray-500 hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-700">ligne par page</span>
                    <select class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>5</option>
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

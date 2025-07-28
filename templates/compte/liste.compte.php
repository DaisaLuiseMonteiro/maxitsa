   <?php if (isset($_SESSION['success'])): ?>
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>
    
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900">liste des Comptes</h1>
                <div class="flex gap-4">
                    <div class="relative">
                        <input type="text" placeholder="rechercher par date" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder="rechercher par numero" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Numero Compte
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span class="border-2 border-orange-500 px-2 py-1 rounded">type</span>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Solde
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date Creation
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
    <?php foreach ($comptes as $compte) : ?>
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4">
            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        </td>
        <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($compte['numerocompte']) ?></td>
        <td class="px-6 py-4">
            <span class="inline-block px-3 py-1 text-xs font-medium 
                <?= $compte['typecompte'] === 'Principal' ? 'text-green-600 bg-green-100 border-green-200' : 'text-orange-600 bg-orange-100 border-orange-200' ?> 
                rounded-full border">
                <?= htmlspecialchars($compte['typecompte']) ?>
            </span>
        </td>
        <td class="px-6 py-4 text-sm text-gray-900"><?= number_format($compte['solde'], 0, ',', ' ') ?> FCFA</td>
        <td class="px-6 py-4 text-sm text-gray-900"><?= date('d/m/Y', strtotime($compte['datecreation'])) ?></td>
      <td class="px-6 py-4">
    <?php if ($compte['typecompte'] === 'principal') : ?>
        <span class="text-sm text-gray-500 italic">Compte principal</span>
    <?php else : ?>
        <form method="POST" action="/changerTypeCompte" style="display: inline;">
            <input type="hidden" name="compte_id" value="<?= $compte['compte_id'] ?>">
            <button type="submit" 
                    class="inline-flex items-center px-3 py-2 border border-transparent text-xs leading-4 font-medium rounded-md text-orange-700 bg-orange-100 hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200"
                    onclick="return confirm('Êtes-vous sûr de vouloir changer ce compte en compte principal ?')">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Changer en principal
            </button>
        </form>
    <?php endif; ?>
</td>
    </tr>
    <?php endforeach; ?>
</tbody>

<!-- Plus besoin de modal ni de JavaScript -->
            </table>
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

    
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Maxit - Tableau de bord</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#1a1a1a] text-white min-h-screen flex">
  <!-- Sidebar -->
  <aside class="w-[250px] bg-[#2a2a2a] p-5 flex flex-col fixed h-full">
    <div class="bg-white rounded-xl p-2 mb-10 flex justify-center items-center">
      <div class="bg-orange-600 rounded-lg p-5 text-center w-full">
        <h1 class="text-2xl font-bold text-white mb-2">Max <span class="text-black">it</span></h1>
        <div class="text-black text-lg font-medium">SN</div>
      </div>
    </div>
    <ul class="flex-grow space-y-6">
      <li><a href="#" class="flex items-center text-orange-500 font-bold text-lg hover:text-orange-500"><span class="mr-4 text-white">🏠</span>Accueil</a></li>
      <li><a href="#" class="flex items-center text-gray-300 font-bold text-lg hover:text-orange-500"><span class="mr-4">💳</span>Payements</a></li>
      <li><a href="#" class="flex items-center text-gray-300 font-bold text-lg hover:text-orange-500"><span class="mr-4">🔄</span>Transactions</a></li>
      <li><a href="#" class="flex items-center text-gray-300 font-bold text-lg hover:text-orange-500"><span class="mr-4">👤</span>mes comptes</a></li>
    </ul>
    <button class="mt-auto text-white font-bold text-lg hover:text-orange-500 flex items-center gap-2">
      <span>🔓</span>Déconnexion
    </button>
  </aside>
        <?php echo $ContentForLayout;?>
  </body>
</html>
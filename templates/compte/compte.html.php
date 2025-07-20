
  <!-- Main Content -->
  <main class="ml-[250px] flex-grow p-5 bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
      <div class="flex-grow max-w-xl">
        <input type="text" placeholder="🔍 recherche" class="w-full p-3 border border-gray-300 rounded-full bg-gray-100 text-gray-700 text-base">
      </div>
      <div class="flex items-center gap-4">
        <div class="w-9 h-9 bg-gray-300 rounded-full flex items-center justify-center font-bold text-sm text-gray-700">DLM</div>
        <button class="bg-green-600 text-white px-4 py-2 rounded-full text-sm">connecté</button>
        <button class="text-black text-xl">🔔</button>
      </div>
    </div>

    <!-- Account Card -->
    <div class="bg-gradient-to-r from-orange-600 to-orange-400 text-white p-6 rounded-xl shadow-lg mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
      <div>
        <h2 class="text-2xl font-bold mb-1">Maxit</h2>
        <div class="opacity-90 text-base mb-1">Compte principal</div>
        <div class="font-semibold text-lg">77 703 27 62</div>
      </div>
      <div class="text-right">
        <div class="text-xl font-bold">Solde: 1.234.567</div>
      </div>
      <div class="w-28 h-28 bg-white rounded-lg flex items-center justify-center text-4xl">
        <div class="w-20 h-20 bg-[repeating-linear-gradient(45deg,#000,#000_2px,#fff_2px,#fff_4px)] rounded-md"></div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col md:flex-row gap-5 mb-8">
      <button class="flex-1 bg-white border-2 border-orange-500 text-orange-500 px-4 py-3 rounded-full text-sm font-medium hover:bg-orange-500 hover:text-white transition">📊 consulter mes transactions</button>
      <button class="flex-1 bg-white border-2 border-orange-500 text-orange-500 px-4 py-3 rounded-full text-sm font-medium hover:bg-orange-500 hover:text-white transition">➕ creer un compte secondaire</button>
      <button class="flex-1 bg-white border-2 border-orange-500 text-orange-500 px-4 py-3 rounded-full text-sm font-medium hover:bg-orange-500 hover:text-white transition">➕ creer un compte secondaire</button>
    </div>

    <!-- Transaction History -->
    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="text-xl font-semibold text-gray-800 mb-5">historiques</h3>
      <div class="bg-gray-100 rounded-lg p-5 space-y-5">
        <div class="flex items-center border-b border-gray-300 pb-4">
          <div class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center text-lg mr-4">✓</div>
          <div class="flex-grow">
            <div class="font-semibold text-gray-800">Payement</div>
            <div class="text-orange-500 text-sm">12 janvier 2025</div>
          </div>
          <div class="font-semibold text-gray-800 mr-4">-25000 fcfa</div>
          <div class="text-green-800 bg-green-100 px-2 py-1 rounded text-sm font-medium">reussi</div>
        </div>

        <div class="flex items-center border-b border-gray-300 pb-4">
          <div class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center text-lg mr-4">✓</div>
          <div class="flex-grow">
            <div class="font-semibold text-gray-800">Depot</div>
            <div class="text-orange-500 text-sm">23 juin 2025</div>
          </div>
          <div class="font-semibold text-gray-800 mr-4">245488 fcfa</div>
          <div class="text-green-800 bg-green-100 px-2 py-1 rounded text-sm font-medium">reussi</div>
        </div>

        <div class="flex items-center border-b border-gray-300 pb-4">
          <div class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center text-lg mr-4">✗</div>
          <div class="flex-grow">
            <div class="font-semibold text-gray-800">retrait</div>
            <div class="text-orange-500 text-sm">23 juillet 2025</div>
          </div>
          <div class="font-semibold text-gray-800 mr-4">245488 fcfa</div>
          <div class="text-red-800 bg-red-100 px-2 py-1 rounded text-sm font-medium">echec</div>
        </div>

        <div class="flex items-center border-b border-gray-300 pb-4">
          <div class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center text-lg mr-4">✓</div>
          <div class="flex-grow">
            <div class="font-semibold text-gray-800">Payement</div>
            <div class="text-orange-500 text-sm">15 janvier 2025</div>
          </div>
          <div class="font-semibold text-gray-800 mr-4">-12000 fcfa</div>
          <div class="text-green-800 bg-green-100 px-2 py-1 rounded text-sm font-medium">reussi</div>
        </div>
        <div class="flex items-center">
          <div class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center text-lg mr-4">✗</div>
          <div class="flex-grow">
            <div class="font-semibold text-gray-800">retrait</div>
            <div class="text-orange-500 text-sm">25 juillet 2025</div>
          </div>
          <div class="font-semibold text-gray-800 mr-4">75000 fcfa</div>
          <div class="text-red-800 bg-red-100 px-2 py-1 rounded text-sm font-medium">echec</div>
        </div>
      </div>
    </div>
  </main>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woyofal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-600 to-purple-700 flex items-center justify-center p-5">
    <div class="flex items-center justify-center w-full h-full">
        <div class="bg-white/95 backdrop-blur-lg rounded-3xl p-10 shadow-2xl w-full max-w-md border border-white/20">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-5 text-white text-4xl font-bold animate-pulse-custom">
                    W
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-3">Woyofal</h1>
                <p class="text-gray-600">Achat de crédit électrique</p>
            </div>

            <form id="simulatorForm" class="space-y-6">
                <div>
                    <label for="counterNumber" class="block mb-2 text-sm font-semibold text-gray-700">
                        Numéro de compteur 
                    </label>
                    <input 
                        type="text" 
                        id="counterNumber" 
                        name="counterNumber" 
                        placeholder="Ex: 12345678901234" 
                        required 
                        maxlength="14"
                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl text-lg focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-300 hover:-translate-y-1"
                    >
                    <div class="text-red-500 text-sm mt-1 hidden" id="counterError">
                        Veuillez saisir un numéro de compteur valide (10-14 chiffres)
                    </div>
                </div>

                <div>
                    <label for="amount" class="block mb-2 text-sm font-semibold text-gray-700">
                        Montant d'achat (FCFA) 
                    </label>
                    <input 
                        type="number" 
                        id="amount" 
                        name="amount" 
                        placeholder="Saisissez le montant" 
                        min="500" 
                        max="100000" 
                        required
                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl text-lg focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-300 hover:-translate-y-1"
                    >
                    <div class="text-red-500 text-sm mt-1 hidden" id="amountError">
                        Le montant doit être entre 500 et 100,000 FCFA
                    </div>
               

                <button 
                    type="submit" 
                    class="w-full py-5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white border-none rounded-xl text-lg font-bold cursor-pointer transition-all duration-300 mt-5 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-300/30 active:-translate-y-0"
                >
                     Valider l'achat
                </button>
            </form>

            <div class="mt-8 p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl border-l-4 border-green-500 hidden animate-slide-in" id="result">
                <h3 class="text-green-600 mb-4 text-xl font-semibold"> Résultat de la simulation</h3>
                
                <div class="flex justify-between mb-2 py-2 border-b border-gray-200">
                    <span class="text-gray-700">Numéro de compteur:</span>
                    <span id="resultCounter" class="font-medium"></span>
                </div>
                
                <div class="flex justify-between mb-2 py-2 border-b border-gray-200">
                    <span class="text-gray-700">Montant payé:</span>
                    <span id="resultAmount" class="font-medium"></span>
                </div>
                
                <div class="flex justify-between mb-2 py-2 border-b border-gray-200">
                    <span class="text-gray-700">Frais de transaction:</span>
                    <span id="resultFees" class="font-medium"></span>
                </div>
                
                <div class="flex justify-between mb-2 py-2 border-b border-gray-200">
                    <span class="text-gray-700">Crédit électrique reçu:</span>
                    <span id="resultCredit" class="font-medium"></span>
                </div>
                
                <div class="flex justify-between py-2 font-bold text-lg text-green-600">
                    <span>Code de rechargement:</span>
                    <span id="resultCode" class="font-mono"></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
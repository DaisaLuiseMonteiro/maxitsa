<div class="flex justify-between gap-6 mb-8">
    <div class="bg-[#F4F4F4] w-[50%] rounded-xl p-6 border-2 shadow-sm">
        <div class="flex items-center justify-between gap-5">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mr-4">
                    <img src="./assets/icons/solde.svg" alt="solde icon" class="h-15 w-15">
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-800"><?= $this->session->get('comptes', 'solde') ?> CFA</div>
                    <div class="text-gray-600 font-medium">Solde de mon Compte principal</div>
                </div>
            </div>
            <div class="w-32 h-32 bg-orange-maxit rounded-xl flex items-center justify-center border-2 border-orange-600">
                <img src="./assets/images/qrcode.png" alt="">
            </div>
        </div>
    </div>

<div class="self-center w-full"> 
    <a href="/woyofal">
        <button class="p-3 bg-orange-600 rounded-xl shadow-sm flex items-center justify-center gap-2 text-yellow w-full h-32">
            <h1 class="font-bold text-center text-4xl">WOYOFAL</h1>
        </button>
    </a>
</div>
    <div class="self-center w-full">
        <a href="/compteSecondaire">
            <button class="p-3 bg-[#F4F4F4] rounded-xl shadow-sm flex gap-2">
                <img src="./assets/icons/addacount.svg" alt="add icon" class="w-7 h-7">
                Creer un Compte secondaire
            </button>
        </a>
    </div>

    <div class="self-center w-full">
        <a href="/listComptes">
            <button class="p-3 bg-[#F4F4F4] flex gap-2 rounded-xl shadow-sm ">
                <img src="./assets/icons/changer.svg" alt="add icon" class="w-7 h-7">
                Changer de compte
            </button>
        </a>
    </div>
</div>

<div class="bg-white rounded-xl p-6 border border-orange-200 shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-800">10 dernières transactions</h2>
        <a href="/listTransactions">
            <button class="text-gray-600 hover:text-orange-maxit transition-colors">Voir plus</button>
        </a>
    </div>

    <div class="grid grid-cols-5 gap-4">
        <?php foreach($transactions as $transaction): ?>
        <div class="bg-gray-100 rounded-xl p-4 text-center">
            <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center mx-auto mb-3">
                <img src="./images/design/transfert.png" alt="arrow-up" class="w-8 h-8">
            </div>
            <div class="font-medium text-sm text-gray-800 mb-1"><?= $transaction['typetransaction'] ?></div>
            <div class="text-orange-maxit font-bold text-sm"><?= $transaction['montant'] ?> CFA</div>
            <div class="text-xs text-gray-500 mt-1"><?= $transaction['datetransaction'] ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

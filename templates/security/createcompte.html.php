<!-- Formulaire d'inscription -->
<div class="bg-gray-100 flex-1 p-10 flex flex-col justify-center overflow-y-auto">
  <h2 class="text-3xl font-semibold text-center mb-8">Inscription</h2>
  <form method="POST" action="/registe" enctype="multipart/form-data">
    <div class="flex flex-col md:flex-row gap-5">
      <div class="flex-1">
        <label for="nom" class="block mb-2 font-medium text-sm">Nom :</label>
        <input type="text" id="nom" name="nom" placeholder="Entrer votre nom" required class="w-full p-4 rounded-lg bg-gray-300 text-base outline-none focus:bg-gray-400 placeholder:text-gray-600">
      </div>
      <div class="flex-1">
        <label for="prenom" class="block mb-2 font-medium text-sm">Prénom :</label>
        <input type="text" id="prenom" name="prenom" placeholder="Entrer votre prénom" required class="w-full p-4 rounded-lg bg-gray-300 text-base outline-none focus:bg-gray-400 placeholder:text-gray-600">
      </div>
    </div>

    <!-- Téléphone -->
    <div>
      <label for="telephone" class="block mb-2 font-medium text-sm">Numéro de Téléphone</label>
      <div class="relative">
        <input type="tel" id="telephone" name="telephone" placeholder="Entrer votre numéro de téléphone" required class="w-full p-4 rounded-lg bg-gray-300 text-base outline-none focus:bg-gray-400 placeholder:text-gray-600">
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-xl">📞</div>
      </div>
    </div>

    <!-- Password -->
    <div>
      <label for="password" class="block mb-2 font-medium text-sm">Password</label>
      <input type="password" id="password" name="password" placeholder="Entrer votre password" required class="w-full p-4 rounded-lg bg-gray-300 text-base outline-none focus:bg-gray-400 placeholder:text-gray-600">
    </div>

    <!-- Adresse -->
    <div>
      <label for="adresse" class="block mb-2 font-medium text-sm">Adresse :</label>
      <input type="text" id="adresse" name="adresse" placeholder="Entrer votre adresse" required class="w-full p-4 rounded-lg bg-gray-300 text-base outline-none focus:bg-gray-400 placeholder:text-gray-600">
    </div>

    <!-- Numéro Carte d'identité -->
    <div>
      <label for="carte-identite" class="block mb-2 font-medium text-sm">Numéro Carte d'identité</label>
      <input type="text" id="carte-identite" name="carte_identite" placeholder="Entrer votre numéro de carte national d'identité" required class="w-full p-4 rounded-lg bg-gray-300 text-base outline-none focus:bg-gray-400 placeholder:text-gray-600">
    </div>

    <!-- Fichiers Carte d'identité -->
    <div class="flex flex-col md:flex-row gap-5">
      <div class="flex-1">
        <label for="carte-recto" class="block mb-2 font-medium text-sm">Carte d'identité Recto</label>
        <input type="file" id="carte-recto" name="carte_recto" accept="image/*" required class="w-full p-4 rounded-lg bg-gray-300 text-base">
      </div>
      <div class="flex-1">
        <label for="carte-verso" class="block mb-2 font-medium text-sm">Carte d'identité Verso</label>
        <input type="file" id="carte-verso" name="carte_verso" accept="image/*" required class="w-full p-4 rounded-lg bg-gray-300 text-base">
      </div>
    </div>

    <!-- Bouton d'Inscription -->
    <button type="submit" class="w-full p-4 bg-orange-500 text-white rounded-lg text-lg font-semibold hover:bg-orange-600 transition">Inscription</button>
    <div class="text-center mt-3 text-sm text-gray-600">
      Déjà un compte ? <a href="#" class="text-orange-500 hover:underline">Connexion</a>
    </div>
  </form>
</div>
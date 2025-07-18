<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Maxit - Inscription</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5eeee] text-gray-800 min-h-screen flex items-center justify-center">
  <div class="flex bg-gray-100 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.3)] overflow-hidden w-[95vw] h-[95vh] flex-col md:flex-row">
    <!-- Left Panel -->
    <div class="bg-black flex-1 flex items-center justify-center relative p-8">
      <div class="bg-orange-500 rounded-xl p-12 text-center shadow-[0_5px_15px_rgba(255,107,0,0.3)]">
        <h1 class="text-5xl font-bold text-white mb-2">Max <span class="text-black">it</span></h1>
        <div class="text-black text-2xl font-medium">SN</div>
      </div>
    </div>
        <?php echo $ContentForLayout;?>
     </div>
</body>
</html>
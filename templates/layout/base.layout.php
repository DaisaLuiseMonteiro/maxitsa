<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Max it - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'orange-maxit': '#FF7900',
                        'gray-light': '#F4F4F4',
                        'gray-medium': '#e5e5e5',
                        'text-gray': '#666666'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">
      <div class="flex h-screen bg-white">
         
    <?php require_once '../templates/layout/partial/leftbar.php'; ?>
        
        <div class="flex-1 flex flex-col">
    <?php require_once '../templates/layout/partial/header.html.php'; ?>
        <div class="grid grid-cols-5 gap-16 m-8">
                    <div class="bg-orange-maxit rounded-3xl h-28 shadow-sm"></div>
                    <div class="bg-orange-maxit rounded-3xl h-28 shadow-sm"></div>
                    <div class="bg-orange-maxit rounded-3xl h-28 shadow-sm"></div>
                    <div class="bg-orange-maxit rounded-3xl h-28 shadow-sm"></div>
                </div>
            
    <main class="flex-1 p-6 bg-gray-5">
    <?php echo $contentForLayout ?>
</body>
</html>
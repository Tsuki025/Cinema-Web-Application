<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt kina</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0d1542]">

    
<header class="py-6 px-6 text-center text-white">
        <div class="flex justify-center space-x-4">
            <a href="<?php echo e(route('kino')); ?>" class="bg-blue-500 text-black px-6 py-3 rounded text-lg">
                Strona główna
            </a>
            <a href="<?php echo e(route('repertuar.index')); ?>" class="bg-blue-500 text-black px-6 py-3 rounded text-lg">
                Repertuar
            </a>

            <a href="<?php echo e(route('kontakt')); ?>" class="bg-green-500 text-black px-6 py-3 rounded text-lg">
                Kontakt
            </a>
        </div>
        <br>
        <br>
        <h2 class="font-semibold text-3xl">
            <?php echo e(__('Kontakt Kina')); ?>

        </h2>
    </header>
   
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h1 class="text-4xl font-bold mb-6">Skontaktuj się z nami!</h1>
                    <p class="text-lg mb-8">Jesteśmy dostępni pod poniższymi danymi kontaktowymi:</p>

                    <div class="space-y-4 text-lg">
                        <p><strong>Adres:</strong> Ul. Filmowa 23, 12-345 Miasto</p>
                        <p><strong>Telefon:</strong> +48 123 456 789</p>
                        <p><strong>Email:</strong> kontakt@kino.pl</p>
                    </div>

                    <div class="flex justify-center space-x-4 mt-6">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/kontakt.blade.php ENDPATH**/ ?>
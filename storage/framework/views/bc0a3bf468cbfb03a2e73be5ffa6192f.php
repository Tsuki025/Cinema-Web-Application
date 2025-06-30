<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Witamy w naszym kinie!</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0d1542]">

    <header class="py-6 px-6 text-center text-white">
        
    </header>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h1 class="text-4xl font-bold mb-6">Witamy w naszym kinie!</h1>
                    <p class="text-lg mb-8">Sprawdź aktualny repertuar lub skontaktuj się z nami.</p>

                    <div class="flex justify-center space-x-4">
                        <a href="<?php echo e(route('repertuar.index')); ?>" class="bg-blue-500 text-black px-6 py-3 rounded text-lg">
                            🎬 Repertuar
                        </a>

                        <a href="<?php echo e(route('kontakt')); ?>" class="bg-green-500 text-black px-6 py-3 rounded text-lg">
                            📞 Kontakt
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/kino.blade.php ENDPATH**/ ?>
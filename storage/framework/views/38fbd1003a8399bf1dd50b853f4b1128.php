<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repertuar Kina</title>

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
            <?php echo e(__('Repertuar Kina')); ?>

        </h2>
    </header>


    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Wybierz dzień</h1>

                    <div class="mb-6">
                        <div class="flex space-x-2">
                            <?php $__currentLoopData = $dniTygodnia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dzien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $aktywny = $dzien['data'] === $wybranyDzien;
                            $klasa = $aktywny ? 'bg-blue-500 text-white' : 'bg-gray-300';
                            $klasa = !$dzien['dostepny'] ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : $klasa;
                            ?>
                            <?php if($dzien['dostepny']): ?>
                            <a href="<?php echo e(route('repertuar.index', ['data' => $dzien['data']])); ?>"
                                class="px-4 py-2 rounded <?php echo e($klasa); ?>">
                                <?php echo e($dzien['nazwa']); ?><br><?php echo e($dzien['formatted']); ?>

                            </a>
                            <?php else: ?>
                            <span class="px-4 py-2 rounded <?php echo e($klasa); ?>">
                                <?php echo e($dzien['nazwa']); ?><br><?php echo e($dzien['formatted']); ?>

                            </span>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold mt-6 mb-4">Seanse na dzień <?php echo e(\Carbon\Carbon::parse($wybranyDzien)->translatedFormat('l, d F Y')); ?></h2>

                    <?php $__empty_1 = true; $__currentLoopData = $seanse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filmID => $seansy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                    $film = $seansy->first()->film;
                    ?>
                    <div class="flex border-b pb-4 mb-4">
                        <div class="w-1/4">
                            <?php if($film->Plakat): ?>
                            <img src="<?php echo e(asset('storage/' . $film->Plakat)); ?>" alt="<?php echo e($film->Tytul); ?>" class="w-full rounded-lg">
                            <?php else: ?>
                            <p><?php echo e(__('Brak plakatu')); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="w-3/4 pl-4">
                            <h3 class="text-lg font-bold"><?php echo e($film->Tytul); ?></h3>
                            <div class="flex flex-wrap mt-2">
                                <?php $__currentLoopData = $seansy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gray-200 px-3 py-1 rounded mr-2 mb-2">
                                    <a href="<?php echo e(route('repertuar.show', ['film' => $film->FilmID, 'seans' => $seans->SeansID])); ?>">
                                        <span class="font-semibold"><?php echo e(\Carbon\Carbon::parse($seans->GodzinaRozpoczecia)->format('H:i')); ?></span>
                                        -
                                        <span><?php echo e($seans->Typ); ?></span>,
                                        <span><?php echo e($seans->Typ2); ?></span>
                                    </a>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="mt-4">
                                <h4 class="text-md font-semibold">Opis:</h4>
                                <p class="text-gray-700"><?php echo e($film->Opis); ?></p>
                            </div>

                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500">Brak seansów na ten dzień.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <style>
        img {
            width: 200px;
            height: 300px;
            object-fit: cover;
        }
    </style>

</body>

</html><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/repertuar/index.blade.php ENDPATH**/ ?>
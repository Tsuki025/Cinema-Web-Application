<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($film->Tytul); ?> - Repertuar</title>
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="film-details-container">
                        <?php if(session('success')): ?>
                        <div class="mt-6 p-4 bg-green-500 text-white rounded">
                            <?php echo e(session('success')); ?>

                        </div>
                        <?php endif; ?>

                        <div class="film-title text-center">
                            <h3 class="text-3xl font-bold"><?php echo e($film->Tytul); ?></h3>
                        </div>

                        <div class="film-trailer">
                            <?php if($film->ZwiastunURL): ?>
                            <?php
                            preg_match('/(?:youtu.be\/|youtube.com\/(?:[^\/\n\s]*\/\S*\/\S*\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=))([\w-]{10,12})/', $film->ZwiastunURL, $matches);
                            $videoId = $matches[1] ?? '';
                            ?>
                            <?php if($videoId): ?>
                            <iframe src="https://www.youtube.com/embed/<?php echo e($videoId); ?>" frameborder="0" allowfullscreen></iframe>
                            <?php else: ?>
                            <p>Brak poprawnego linku do zwiastuna</p>
                            <?php endif; ?>
                            <?php else: ?>
                            <p>Brak zwiastuna</p>
                            <?php endif; ?>
                        </div>

                        <div class="film-poster mt-6">
                            <?php if($film->Plakat): ?>
                            <img src="<?php echo e(asset('storage/' . $film->Plakat)); ?>" alt="<?php echo e($film->Tytul); ?>">
                            <?php else: ?>
                            <p>Brak plakatu</p>
                            <?php endif; ?>
                        </div>

                        <div class="film-description mt-6">
                            <h4 class="text-xl font-semibold">Opis:</h4>
                            <p class="text-lg"><?php echo e($film->Opis); ?></p>
                        </div>

                        <div class="film-info mt-6">
                            <h4 class="text-xl font-semibold">Informacje o seansie:</h4>
                            <p><strong>Godzina rozpoczęcia:</strong> <?php echo e(\Carbon\Carbon::parse($seans->GodzinaRozpoczecia)->format('H:i')); ?></p>
                            <p><strong>Godzina zakończenia:</strong> <?php echo e(\Carbon\Carbon::parse($seans->GodzinaZakonczenia)->format('H:i')); ?></p>
                            <p><strong>Sala:</strong> <?php echo e($seans->SalaID); ?></p>
                            <p><strong>Data seansu:</strong> <?php echo e(\Carbon\Carbon::parse($seans->DataSeansu)->format('d.m.Y')); ?></p>
                            <p><strong>Od ilu lat:</strong> <?php echo e($film->Wiek); ?></p>
                            <p><strong><?php echo e($seans->Typ); ?></strong> </p>
                            <p><strong><?php echo e($seans->Typ2); ?></strong></p>
                            <p><strong>Cena ulgowego biletu:</strong> <?php echo e($film->CenaUlgowa); ?> zł</p>
                            <p><strong>Cena normalnego biletu:</strong> <?php echo e($film->CenaNormalna); ?> zł</p>
                        </div>

                        <div class="mt-6">
                            <button onclick="openModal(<?php echo e($seans->SeansID); ?>)" class="rezerwuj">Rezerwuj Miejsce</button>
                        </div>

                        <div id="modal-<?php echo e($seans->SeansID); ?>" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
                        <div class="modal-content">

                                <h2 class="text-xl font-bold mb-0">Rezerwacja</h2>
                                <h4 class="text-lg font-semibold mt-0">Informacje o seansie:</h4>

                                <p><strong>Godziny oraz data:</strong> <?php echo e(\Carbon\Carbon::parse($seans->GodzinaRozpoczecia)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($seans->GodzinaZakonczenia)->format('H:i')); ?> <?php echo e(\Carbon\Carbon::parse($seans->DataSeansu)->format('d.m.Y')); ?></p>
                                <p><strong><?php echo e($seans->Typ); ?>/<?php echo e($seans->Typ2); ?></strong></p>
                                <p><strong>Ulgowy:</strong> <?php echo e($film->CenaUlgowa); ?> zł <strong>Normalny:</strong> <?php echo e($film->CenaNormalna); ?> zł</p>

                                <p><strong>Sala:</strong> <?php echo e($seans->SalaID); ?></p>
                                <p><strong>Od ilu lat:</strong> <?php echo e($film->Wiek); ?></p>

                                <div class="legend flex flex-col items-start my-4 absolute top-4 right-4 bg-white p-4 shadow-lg rounded">
                                    <div class="legend-item flex items-center">
                                        <span class="w-4 h-4 bg-green-500 inline-block mr-2"></span> Wolne miejsca
                                    </div>
                                    <div class="legend-item flex items-center">
                                        <span class="w-4 h-4 bg-blue-500 inline-block mr-2"></span> Wybrane miejsca
                                    </div>
                                    <div class="legend-item flex items-center">
                                        <span class="w-4 h-4 bg-purple-500 inline-block mr-2"></span> Zarezerwowane miejsca
                                    </div>
                                    <div class="legend-item flex items-center">
                                        <span class="w-4 h-4 bg-red-500 inline-block mr-2"></span> Zajęte miejsca
                                    </div>
                                </div>


                                <form action="<?php echo e(route('bilety.rezerwuj', ['seansId' => $seans->SeansID])); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <label for="nr_telefonu" class="block font-medium text-sm text-gray-700 mt-1">Numer telefonu:</label>
                                    <input type="text" id="nr_telefonu" name="nr_telefonu" maxlength="9" required class="border rounded p-2 w-full">

                                    <label for="kod_rezerwacji" class="block font-medium text-sm text-gray-700 mt-1">Kod rezerwacji:</label>
                                    <input type="text" id="kod_rezerwacji" name="kod_rezerwacji" maxlength="5" required class="border rounded p-2 w-full">

                                    <button type="button" onclick="wygenerujKod()" class="bg-gray-500 text-white px-4 py-2 rounded mt-1">Generuj kod</button>

                                    <h4 class="mt-4 text-xl font-semibold">Miejsca:</h4>

                                    <?php $poprzedniRzad = null; ?>
                                    <?php $__currentLoopData = $seans->sala->miejsca->sortBy(['Rzad', 'NumerMiejsca']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miejsce): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $czyZajete = in_array($miejsce->MiejsceID, explode(',', $seans->ZajeteMiejsca));
                                    $czyRezerwowane = in_array($miejsce->MiejsceID, \App\Models\Rezerwacja::where('SeansID', $seans->SeansID)
                                    ->pluck('ZarezerwowaneMiejsca')
                                    ->filter()
                                    ->flatMap(fn($miejsca) => explode(',', $miejsca))
                                    ->toArray());
                                    ?>

                                    <?php if($miejsce->Rzad != $poprzedniRzad): ?>
                                    <?php if($poprzedniRzad !== null): ?> <br> <?php endif; ?>
                                    <span class="font-bold">
                                        Rząd <?php echo e($miejsce->Rzad); ?>:
                                        <?php if($miejsce->Rzad < 10): ?>
                                            &nbsp;&nbsp;&nbsp;
                                            <?php else: ?>
                                            &nbsp;
                                            <?php endif; ?>
                                            </span>
                                            <?php endif; ?>

                                            <label class="inline-block text-center mx-2 my-1 border rounded seat-label 
                    <?php echo e($czyZajete ? 'bg-red-500 cursor-not-allowed' : ($czyRezerwowane ? 'bg-purple-500 cursor-not-allowed' : 'bg-green-500 cursor-pointer')); ?>">
                                                <input type="checkbox" name="miejsca[]" value="<?php echo e($miejsce->MiejsceID); ?>" class="hidden seat-checkbox "
                                                    <?php echo e($czyZajete ? 'disabled' : ''); ?> <?php echo e($czyRezerwowane ? 'disabled' : ''); ?>>

                                                <span class="text-white"><?php echo e($miejsce->NumerMiejsca); ?></span>
                                            </label>
                                            <?php $poprzedniRzad = $miejsce->Rzad; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <br>
                                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Zarezerwuj</button>
                                            <button type="button" onclick="closeModal(<?php echo e($seans->SeansID); ?>)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4">Anuluj</button>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .rzad-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .color-box {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }

        label {
            padding: 5px;
            border-radius: 4px;
            display: inline-block;
            margin: 10px;

        }

        .seat-label {
            width: 40px;
            text-align: center;
            display: inline-block;
        }

        .rezerwuj {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .bg-red-500 {
            background-color: red;
        }

        .bg-purple-500 {
            background-color: purple;
        }

        .bg-green-500 {
            background-color: green;
        }

        .bg-blue-500 {
            background-color: blue;
        }

        .film-details-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .film-title {
            margin-top: 0;
        }

        .film-trailer {
            margin-top: 0;
            text-align: center;
        }

        .film-poster {
            text-align: left;
        }

        .film-description,
        .film-info {
            text-align: left;
        }

        img {
            width: 150px;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
        }

        iframe {
            width: 100%;
            height: 450px;
            max-width: 800px;
            margin: 20px auto;
        }

        .anuluj {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .fixed {
            z-index: 50;
        }

        .modal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-y: auto;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 100%;
            max-height: 90%;
            overflow-y: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }


        @media (max-width: 640px) {
            .modal-content {
                max-width: 95%;
                max-height: 95%;
                padding: 15px;
            }
        }
    </style>
    <script>
        function openModal(seansId) {
            document.getElementById('modal-' + seansId).classList.remove('hidden');
        }

        function closeModal(seansId) {
            document.getElementById('modal-' + seansId).classList.add('hidden');
        }

        async function wygenerujKod() {
            let kod, isUnique = false;
            while (!isUnique) {
                kod = Math.floor(10000 + Math.random() * 90000);
                let response = await fetch(`/sprawdz-kod-rezerwacji/${kod}/<?php echo e($seans->SeansID); ?>`);
                let data = await response.json();
                isUnique = data.unikalny;
            }
            document.getElementById('kod_rezerwacji').value = kod;
        }
        document.querySelectorAll(".seat-checkbox").forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                let label = this.closest(".seat-label");
                if (this.checked) {
                    label.classList.remove("bg-green-500");
                    label.classList.add("bg-blue-500");
                } else {
                    label.classList.remove("bg-blue-500");
                    label.classList.add("bg-green-500");
                }
            });
        });
    </script>

</body>

</html><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/repertuar/show.blade.php ENDPATH**/ ?>
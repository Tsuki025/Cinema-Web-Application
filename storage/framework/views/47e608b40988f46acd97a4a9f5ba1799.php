<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Sprzedaż Biletów')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">
                        Seanse na dzień <?php echo e(\Carbon\Carbon::parse($wybranyDzien)->translatedFormat('l, d F Y')); ?>

                    </h1>

                   
                    <div class="mb-6">
                        <div class="flex space-x-2">
                            <?php $__currentLoopData = $dniTygodnia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dzien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $aktywny = $dzien['data'] === $wybranyDzien;
                            ?>
                            <a href="<?php echo e(route('bilety.index', ['data' => $dzien['data']])); ?>"
                                class="px-4 py-2 rounded <?php echo e($aktywny ? ' text-white bg-gray-500' : 'bg-gray-300'); ?>">
                                <?php echo e($dzien['nazwa']); ?><br><?php echo e($dzien['formatted']); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php if(session('success')): ?>
                        <div class="mt-6 p-4 bg-green-500 text-white rounded">
                            <?php echo e(session('success')); ?>

                        </div>
                        <?php endif; ?>
                    <?php if($daneSeansow->isEmpty()): ?>
                    <p class="text-red-500 font-bold">Nie zaplanowano jeszcze seansu na wybrany dzień.</p>
                    <?php else: ?>
                    <?php $__currentLoopData = $daneSeansow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nazwaSali => $seanse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <h2 class="text-xl font-bold mb-4"><?php echo e($nazwaSali); ?></h2>
                    <table class="table-auto w-full mb-8">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Tytuł Filmu</th>
                                <th class="px-4 py-2">Rodzaj Seansu</th>
                                <th class="px-4 py-2">Godzina Rozpoczęcia</th>
                                <th class="px-4 py-2">Od Ilu Lat</th>
                                <th class="px-4 py-2">Kupione Bilety</th>
                                <th class="px-4 py-2">Wolne Miejsca</th>
                                <th class="px-4 py-2">Opcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $seanse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dane): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="border px-4 py-2"><?php echo e($dane['seans']->film->Tytul); ?></td>
                                <td class="border px-4 py-2"><?php echo e($dane['seans']->Publicznosc); ?></td>
                                <td class="border px-4 py-2"><?php echo e($dane['seans']->GodzinaRozpoczecia); ?></td>
                                <td class="border px-4 py-2"><?php echo e($dane['film']->Wiek); ?></td>
                                <td class="border px-4 py-2"><?php echo e($dane['kupioneBilety']); ?></td>
                                <td class="border px-4 py-2"><?php echo e($dane['wolneMiejsca']); ?></td>

                                <td class="border px-4 py-2">

                                    <?php if($dane['seans']->isAnulowany()): ?>
                                    <span class="text-red-500 font-bold">Anulowany</span>
                                    <?php else: ?>
                                    <form method="POST" action="<?php echo e(route('bilety.anuluj', $dane['seans']->SeansID)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="anuluj">
                                            Anuluj seans
                                        </button>
                                    </form>
                                    <br>

                                    <button onclick="openModal(<?php echo e($dane['seans']->SeansID); ?>)"
                                        class="wyswietl">
                                        Wyświetl miejsca
                                    </button>
                                    <?php endif; ?>
                                </td>



                                <div id="modal-<?php echo e($dane['seans']->SeansID); ?>"
                                    class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
                                    <div class="bg-white p-6 h-[70vh] modal-content">
                                        <h2 class="text-xl font-bold mb-4">Wybierz miejsce</h2>

                                        <form method="POST" action="<?php echo e(route('bilety.kup', $dane['seans']->SeansID)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php
                                            $poprzedniRzad = null;
                                            ?>
                                            <?php $__currentLoopData = $dane['seans']->sala->miejsca->sortBy(['Rzad', 'NumerMiejsca']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miejsce): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $zajete = explode(',', $dane['seans']->ZajeteMiejsca);
                                            $czyZajete = in_array($miejsce->MiejsceID, $zajete);
                                            $rezerwowane = \App\Models\Rezerwacja::where('SeansID', $dane['seans']->SeansID)
                                            ->pluck('ZarezerwowaneMiejsca')
                                            ->filter()
                                            ->flatMap(fn($miejsca) => explode(',', $miejsca))
                                            ->toArray();
                                            $czyRezerwowane = in_array($miejsce->MiejsceID, $rezerwowane);
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
                                            <?php echo e($czyZajete ? 'bg-red-500 cursor-not-allowed' : ($czyRezerwowane ? 'bg-purple-500' : 'bg-green-500 cursor-pointer')); ?>">
                                                        <input type="checkbox" name="miejsca[]" value="<?php echo e($miejsce->MiejsceID); ?>" class="hidden seat-checkbox"
                                                            <?php echo e($czyZajete ? 'disabled' : ''); ?> <?php echo e($czyRezerwowane ? 'disabled' : ''); ?>>
                                                        <span class="text-white"><?php echo e($miejsce->NumerMiejsca); ?></span>
                                                    </label>

                                                    <?php $poprzedniRzad = $miejsce->Rzad; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <label for="typ_biletu" class="block font-medium text-sm text-gray-700 mt-4">Typ biletu:</label>
                                                    <select name="typ_biletu" id="typ_biletu" class="border rounded p-1 w-full">
                                                        <option value="Normalny">Normalny</option>
                                                        <option value="Ulgowy">Ulgowy</option>
                                                    </select>

                                                    <div class="flex justify-between mt-4">
                                                        <button type="submit" class="kup">
                                                            Kup Bilet
                                                        </button>
                                                        <button type="button" onclick="closeModal(<?php echo e($dane['seans']->SeansID); ?>)"
                                                            class="anuluj">
                                                            Anuluj
                                                        </button>
                                                    </div>
                                        </form>
                                    </div>

                                    <div class="w-1/3 pl-4 bg-white p-6  h-[70vh] ">
                                        <h2 class="text-lg font-bold mb-4">Rezerwacje</h2>
                                        <input type="text" id="search-<?php echo e($dane['seans']->SeansID); ?>" placeholder="Wyszukaj kod..." class="border rounded w-full p-2 mb-4">
                                        <div id="reservations-list-<?php echo e($dane['seans']->SeansID); ?>" class="overflow-y-auto h-[56vh]">
                                            <?php $__empty_1 = true; $__currentLoopData = $dane['rezerwacje']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rezerwacja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <div class="p-2 border-b ">
                                                <p><strong>Kod:</strong> <?php echo e($rezerwacja->Kod); ?></p>
                                                <p><strong>Telefon:</strong> <?php echo e($rezerwacja->NrTelefonu); ?></p>
                                                <p><strong>Miejsca:</strong></p>
                                                <?php
                                                $miejsca = [];
                                                foreach (explode(',', $rezerwacja->ZarezerwowaneMiejsca) as $miejsceID) {
                                                $miejsce = \App\Models\Miejsce::find($miejsceID);
                                                if ($miejsce) {
                                                $miejsca[$miejsce->Rzad][] = $miejsce->NumerMiejsca;
                                                }
                                                }
                                                ?>

                                                <?php $__currentLoopData = $miejsca; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rzad => $numeryMiejsc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <p>Rząd: <?php echo e($rzad); ?> Miejsca: <?php echo e(implode(',', $numeryMiejsc)); ?></p>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($rezerwacja ?? false): ?>
                                                <form method="POST" action="<?php echo e(route('bilety.zatwierdz', $rezerwacja->RezerwacjaID)); ?>" onsubmit="return validateForm(event, <?php echo e(count(explode(',', $rezerwacja->ZarezerwowaneMiejsca))); ?>, <?php echo e($rezerwacja->RezerwacjaID); ?>);">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="mb-4">
                                                        <label for="normal_bilety_<?php echo e($rezerwacja->RezerwacjaID); ?>" class="block">Liczba biletów normalnych:</label>
                                                        <input type="number" name="normal_bilety" id="normal_bilety_<?php echo e($rezerwacja->RezerwacjaID); ?>" class="border rounded w-full p-2" required min="0" value="0">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="ulgowe_bilety_<?php echo e($rezerwacja->RezerwacjaID); ?>" class="block">Liczba biletów ulgowych:</label>
                                                        <input type="number" name="ulgowe_bilety" id="ulgowe_bilety_<?php echo e($rezerwacja->RezerwacjaID); ?>" class="border rounded w-full p-2" required min="0" value="0">
                                                    </div>

                                                    <input type="hidden" name="zarezerwowane_miejsca" value="<?php echo e($rezerwacja->ZarezerwowaneMiejsca); ?>">

                                                    <div id="error-message-<?php echo e($rezerwacja->RezerwacjaID); ?>" class="text-red-500 hidden mt-2">

                                                        <p>Liczba biletów normalnych i ulgowych musi wynosić <?php echo e(count(explode(',', $rezerwacja->ZarezerwowaneMiejsca))); ?> (liczba zarezerwowanych miejsc).</p>
                                                    </div>

                                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-2 hover:bg-green-700">
                                                        Zatwierdź miejsca
                                                    </button>
                                                </form>
                                                <?php else: ?>

                                                <?php endif; ?>
                                                <form method="POST" action="<?php echo e(route('bilety.zwolnij', $rezerwacja->RezerwacjaID)); ?>" onsubmit="return confirm('Czy na pewno chcesz zwolnić tę rezerwację?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded mt-2 hover:bg-red-700">
                                                        Zwolnij rezerwację
                                                    </button>
                                                </form>
                                                

                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                                                

                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                                                
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <script>
        function openModal(seansID) {
            document.getElementById("modal-" + seansID).classList.remove("hidden");
        }

        function closeModal(seansID) {
            document.getElementById("modal-" + seansID).classList.add("hidden");
        }


        document.querySelectorAll('input[id^="search-"]').forEach(input => {
    input.addEventListener("input", function() {
        let searchValue = this.value.toLowerCase();
        let seansID = this.id.split('-')[1];
        let reservationList = document.getElementById("reservations-list-" + seansID);
        let reservations = reservationList.getElementsByTagName("div");

        for (let res of reservations) {
            let isError = res.id.startsWith("error-message-"); 
            
            if (!isError) { 
                let kodElement = res.querySelector("p:first-child");
                if (kodElement) {
                    let kod = kodElement.textContent.toLowerCase();
                    if (kod.includes(searchValue)) {
                        res.style.display = "";
                    } else {
                        res.style.display = "none";
                    }
                }
            }
        }

       
        let errorMessage = document.getElementById(`error-message-${seansID}`);
        if (errorMessage) {
            errorMessage.classList.remove("hidden");
            errorMessage.style.display = ""; 
        }
    });
});


        function validateForm(event, totalSeats, rezerwacjaID) {

            var normalTickets = document.getElementById('normal_bilety_' + rezerwacjaID);
            var ulgoweTickets = document.getElementById('ulgowe_bilety_' + rezerwacjaID);


            if (!normalTickets || !ulgoweTickets) return true;


            var normalTicketsValue = parseInt(normalTickets.value) || 0;
            var ulgoweTicketsValue = parseInt(ulgoweTickets.value) || 0;


            var errorMessage = document.getElementById('error-message-' + rezerwacjaID);


            if (normalTicketsValue + ulgoweTicketsValue !== totalSeats) {
                errorMessage.classList.remove('hidden');
                event.preventDefault();
                return false;
            }


            errorMessage.classList.add('hidden');
            return true;
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

    <style>
        .cursor-pointer {
            cursor: pointer;
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

        label {
            padding: 5px;
            border-radius: 4px;
            display: inline-block;
            margin: 5px;
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

        .wyswietl {

            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;

        }

        .kup {

            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;

        }

        .seat-label {
            width: 40px;


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
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/bilety/index.blade.php ENDPATH**/ ?>
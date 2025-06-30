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
            <?php echo e(__('Dodaj Sprzątanie')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="<?php echo e(route('harmonogram.storeSprzatanie')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="SalaID" class="block text-sm font-medium text-gray-700">Wybierz Salę</label>
                            <select id="SalaID" name="SalaID" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <?php $__currentLoopData = $sale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sala): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sala->SalaID); ?>"><?php echo e($sala->Nazwa); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="DataSprzatania" class="block text-sm font-medium text-gray-700">Data Sprzątania</label>
                            <input type="date" id="DataSprzatania" name="DataSprzatania" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="GodzinaRozpoczecia" class="block text-sm font-medium text-gray-700">Godzina Rozpoczęcia</label>
                            <input type="time" id="GodzinaRozpoczecia" name="GodzinaRozpoczecia" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="GodzinaZakonczenia" class="block text-sm font-medium text-gray-700">Godzina Zakończenia</label>
                            <input type="time" id="GodzinaZakonczenia" name="GodzinaZakonczenia" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="PracownikID" class="block text-sm font-medium text-gray-700">Wybierz Pracownika</label>
                            <select id="PracownikID" name="PracownikID" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Wybierz pracownika</option>

                            </select>
                        </div>


                        <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600">
                            Zapisz Sprzątanie
                        </button>
                    </form>

                    <?php if(session('error')): ?>
                    <div class="mt-4 text-red-500">
                        <?php echo e(session('error')); ?>

                    </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                    <div class="mt-4 text-green-500">
                        <?php echo e(session('success')); ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('DataSprzatania').addEventListener('change', fetchAvailableWorkers);
        document.getElementById('GodzinaRozpoczecia').addEventListener('change', fetchAvailableWorkers);
        document.getElementById('GodzinaZakonczenia').addEventListener('change', fetchAvailableWorkers);

        function fetchAvailableWorkers() {
            const data = document.getElementById('DataSprzatania').value;
            const godzinaRozpoczecia = document.getElementById('GodzinaRozpoczecia').value;
            const godzinaZakonczenia = document.getElementById('GodzinaZakonczenia').value;
            const pracownicySelect = document.getElementById('PracownikID');

            if (!data || !godzinaRozpoczecia || !godzinaZakonczenia) {
                pracownicySelect.innerHTML = '<option value="">Wybierz pracownika</option>';
                return;
            }


            fetch(`/grafik/sprzatanie?data=${data}&godzina_rozpoczecia=${godzinaRozpoczecia}&godzina_zakonczenia=${godzinaZakonczenia}`)
                .then(response => response.json())
                .then(pracownicy => {
                    pracownicySelect.innerHTML = '<option value="">Wybierz pracownika</option>';

                    pracownicy.forEach(pracownik => {
                        const option = document.createElement('option');
                        option.value = pracownik.PracownikID;
                        option.textContent = `${pracownik.Imie} ${pracownik.Nazwisko}`;
                        pracownicySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Błąd podczas ładowania pracowników:', error));
        }
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/harmonogram/createSprzatanie.blade.php ENDPATH**/ ?>
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
            <?php echo e(__('Edytuj Sprzątanie')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold"><?php echo e(__('Edytuj Sprzątanie: ')); ?> <?php echo e($sprzatanie->Sala->Nazwa); ?></h3>

                    <form method="POST" action="<?php echo e(route('harmonogram.updateSprzatanie', $sprzatanie->SprzatanieID)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div>
                            <label for="SalaID">Sala</label>
                            <select name="SalaID" id="SalaID" required>
                                <?php $__currentLoopData = $sale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sala): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sala->SalaID); ?>" <?php echo e($sala->SalaID == $sprzatanie->SalaID ? 'selected' : ''); ?>>
                                    <?php echo e($sala->Nazwa); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>



                        <div>
                            <label for="DataSprzatania">Data Sprzątania</label>
                            <input type="date" id="DataSprzatania" name="DataSprzatania" value="<?php echo e($sprzatanie->DataSprzatania); ?>" required>

                            <label for="GodzinaRozpoczecia">Godzina Rozpoczęcia</label>
                            <input type="time" id="GodzinaRozpoczecia" name="GodzinaRozpoczecia"  required>

                            <label for="GodzinaZakonczenia">Godzina Zakończenia</label>
                            <input type="time" id="GodzinaZakonczenia" name="GodzinaZakonczenia"  required>
                        </div>
                        <div class="mb-4">
                            <label for="PracownikID" class="block text-sm font-medium text-gray-700">Wybierz Pracownika</label>
                            <select id="PracownikID" name="PracownikID" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Wybierz pracownika</option>
                               
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 text-black py-2 px-4 rounded">Zapisz zmiany</button>
                    </form>
                    <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('harmonogram.index'),'class' => 'anuluj','active' => request()->routeIs('harmonogram.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('harmonogram.index')),'class' => 'anuluj','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('harmonogram.index'))]); ?>
                        <?php echo e(__('Anuluj')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>

                    <br>
                    <form action="<?php echo e(route('harmonogram.destroySprzatanie', $sprzatanie->SprzatanieID)); ?>" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć godziny sprzątania?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button type="submit" class="usun">
                            Usuń godziny sprzątania
                        </button>
                    </form>
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
    const edytowaneSprzatanieID = "<?php echo e($sprzatanie->SprzatanieID); ?>"; 

    if (!data || !godzinaRozpoczecia || !godzinaZakonczenia) {
        pracownicySelect.innerHTML = '<option value="">Wybierz pracownika</option>';
        return;
    }

    fetch(`/grafik/sprzatanieEdit?data=${data}&godzina_rozpoczecia=${godzinaRozpoczecia}&godzina_zakonczenia=${godzinaZakonczenia}&edytowane_sprzatanie_id=${edytowaneSprzatanieID}`)
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
    <style>
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

        .usun {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/harmonogram/editSprzatanie.blade.php ENDPATH**/ ?>
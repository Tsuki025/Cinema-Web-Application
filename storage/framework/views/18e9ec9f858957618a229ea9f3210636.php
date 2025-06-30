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
            <?php echo e(__('Dodaj Nowy Seans')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>

                    </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('harmonogram.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="FilmID" class="block text-sm font-medium text-gray-700">Film</label>
                            <select name="FilmID" id="FilmID" class="mt-1 block w-full" required>
                                <option value="">Wybierz film</option>
                                <?php $__currentLoopData = $filmy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $film): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($film->FilmID); ?>"><?php echo e($film->Tytul); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="SalaID" class="block text-sm font-medium text-gray-700">Sala</label>
                            <select name="SalaID" id="SalaID" class="mt-1 block w-full" required>
                                <option value="">Wybierz salę</option>
                                <?php $__currentLoopData = $sale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sala): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sala->SalaID); ?>"><?php echo e($sala->Nazwa); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="DataSeansu" class="block text-sm font-medium text-gray-700">Data Seansu</label>
                            <input type="date" name="DataSeansu" id="DataSeansu" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="GodzinaRozpoczecia" class="block text-sm font-medium text-gray-700">Godzina Rozpoczecia</label>
                            <input type="time" name="GodzinaRozpoczecia" id="GodzinaRozpoczecia" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="GodzinaZakonczenia" class="block text-sm font-medium text-gray-700">Godzina Zakończenia</label>
                            <input type="time" name="GodzinaZakonczenia" id="GodzinaZakonczenia" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="Typ" class="block text-sm font-medium text-gray-700">Typ</label>
                            <select name="Typ" id="Typ" class="mt-1 block w-full" required>
                                <option value="2D">2D</option>
                                <option value="3D">3D</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="Typ2" class="block text-sm font-medium text-gray-700">Typ Projekcji</label>
                            <select name="Typ2" id="Typ2" class="mt-1 block w-full" required>
                                <option value="Napisy">Napisy</option>
                                <option value="Dubbing">Dubbing</option>
                                <option value="Lektor">Lektor</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="Publicznosc" class="block text-sm font-medium text-gray-700">Rodzaj Seansu</label>
                            <select name="Publicznosc" id="Publicznosc" class="mt-1 block w-full" required>
                                <option value="Publiczny">Publiczny</option>
                                <option value="Prywatny">Prywatny</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="AutoSprzatanie" class="block text-sm font-medium text-gray-700">Czy chcesz automatyczne sprzątanie po seansie?</label>
                            <select name="AutoSprzatanie" id="AutoSprzatanie" class="mt-1 block w-full">
                                <option value="0">Nie</option>
                                <option value="1">Tak</option>
                            </select>
                        </div>

                        <div class="mb-4" id="sprzatanieSelect" style="display: none;">
                            <label for="PracownikSprzatanie" class="block text-sm font-medium text-gray-700">Wybierz pracownika do sprzątania</label>
                            <select name="PracownikSprzatanie" id="PracownikSprzatanie" class="mt-1 block w-full">

                            </select>
                        </div>

                        <button type="submit" class="przycisk">
                            Dodaj Seans
                        </button>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .przycisk {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
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
    </style>
    <script>
        document.getElementById('AutoSprzatanie').addEventListener('change', function() {
            const selectSprzatanie = document.getElementById('sprzatanieSelect');
            if (this.value == '1') {
                selectSprzatanie.style.display = 'block';
            } else {
                selectSprzatanie.style.display = 'none';
            }
        });

        
    document.getElementById('DataSeansu').addEventListener('change', fetchPracownicy);
    document.getElementById('GodzinaZakonczenia').addEventListener('change', fetchPracownicy);

    function fetchPracownicy() {
        const data = document.getElementById('DataSeansu').value;
        const godzinaZakonczenia = document.getElementById('GodzinaZakonczenia').value;
        const pracownicySelect = document.getElementById('PracownikSprzatanie');

        if (!data || !godzinaZakonczenia) {
            return; 
        }

        
        pracownicySelect.innerHTML = '<option value="">Wybierz pracownika</option>';

        
        fetch(`/grafik/pracownicy?data=${data}&godzina_zakonczenia=${godzinaZakonczenia}`)
            .then(response => response.json())
            .then(pracownicy => {
                if (pracownicy.error) {
                    console.error(pracownicy.error);
                    return;
                }

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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/harmonogram/create.blade.php ENDPATH**/ ?>
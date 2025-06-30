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
            <?php echo e(__('Statystyki Seansów')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <form method="GET" action="<?php echo e(route('statystyki.index')); ?>">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
            <label for="okres" class="block text-sm font-medium text-gray-700">Wybierz jakie filmy:</label>
            <select name="okres" id="okres" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="wszystkie" <?php echo e(request('okres') == 'wszystkie' ? 'selected' : ''); ?>>Wszystkie</option>
                <option value="aktualne" <?php echo e(request('okres') == 'aktualne' ? 'selected' : ''); ?>>Aktualne</option>
                <option value="ostatni_rok" <?php echo e(request('okres') == 'ostatni_rok' ? 'selected' : ''); ?>>Ostatni rok</option>
            </select>
            <div>
        <button type="submit" class="przycisk">
                Wybierz
            </button>
            </div>
        </div>
        
    </div>
    </form>      
    <br>
                    <form method="GET" action="<?php echo e(route('statystyki.index')); ?>">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            
                      

                            <div>
                                <label for="film_id" class="block text-sm font-medium text-gray-700">Wybierz Film:</label>
                                <select name="film_id" id="film_id" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="">Wybierz Film</option>
                                    <?php $__currentLoopData = $filmy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $film): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($film->FilmID); ?>" <?php echo e(request('film_id') == $film->FilmID ? 'selected' : ''); ?>>
                                            <?php echo e($film->Tytul); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                           
                            <div>
                                <label for="typ" class="block text-sm font-medium text-gray-700">2D/3D:</label>
                                <select name="typ" id="typ" class="mt-1 block w-full border-gray-300 rounded-md">
                                    <option value="">-- Wszystkie --</option>
                                    <option value="2D" <?php echo e(request('typ') == '2D' ? 'selected' : ''); ?>>2D</option>
                                    <option value="3D" <?php echo e(request('typ') == '3D' ? 'selected' : ''); ?>>3D</option>
                                </select>
                            </div>

                            
                            <div>
                                <label for="typ2" class="block text-sm font-medium text-gray-700">Napisy/Dubbing/Lektor:</label>
                                <select name="typ2" id="typ2" class="mt-1 block w-full border-gray-300 rounded-md">
                                    <option value="">-- Wszystkie --</option>
                                    <option value="Napisy" <?php echo e(request('typ2') == 'Napisy' ? 'selected' : ''); ?>>Napisy</option>
                                    <option value="Dubbing" <?php echo e(request('typ2') == 'Dubbing' ? 'selected' : ''); ?>>Dubbing</option>
                                    <option value="Lektor" <?php echo e(request('typ2') == 'Lektor' ? 'selected' : ''); ?>>Lektor</option>
                                </select>
                            </div>

                            
                            <div>
                                <label for="data_od" class="block text-sm font-medium text-gray-700">Data Od:</label>
                                <input type="date" name="data_od" id="data_od" class="mt-1 block w-full border-gray-300 rounded-md" value="<?php echo e(request('data_od')); ?>">
                            </div>

                            <div>
                                <label for="data_do" class="block text-sm font-medium text-gray-700">Data Do:</label>
                                <input type="date" name="data_do" id="data_do" class="mt-1 block w-full border-gray-300 rounded-md" value="<?php echo e(request('data_do')); ?>">
                            </div>

                           
                            <div>
                                <label for="pora_dnia" class="block text-sm font-medium text-gray-700">Pora dnia:</label>
                                <select name="pora_dnia" id="pora_dnia" class="mt-1 block w-full border-gray-300 rounded-md">
                                    <option value="">-- Wszystkie --</option>
                                    <option value="rano" <?php echo e(request('pora_dnia') == 'rano' ? 'selected' : ''); ?>>Rano</option>
                                    <option value="popoludnie" <?php echo e(request('pora_dnia') == 'popoludnie' ? 'selected' : ''); ?>>Popołudnie</option>
                                    <option value="wieczor" <?php echo e(request('pora_dnia') == 'wieczor' ? 'selected' : ''); ?>>Wieczór</option>
                                    <option value="noc" <?php echo e(request('pora_dnia') == 'noc' ? 'selected' : ''); ?>>Noc</option>
                                </select>
                            </div>

                            <div>
                                <button type="submit" class="przycisk">
                                    Filtruj
                                </button>
                            </div>

                        </div>
                    </form>
                    
                    <div class="mt-6 text-lg">
                        <p>🎬 Film: <strong><?php echo e($filmTytul); ?></strong></p>
                        <p>💰 Łączny przychód: <strong><?php echo e(number_format($przychod, 2)); ?> PLN</strong></p>
                        <p>🎟 Sprzedane bilety: <strong><?php echo e($sprzedaneBilety); ?> / <?php echo e($wszystkieMiejsca); ?></strong></p>
                        <p>📊 Procent zajętych miejsc: <strong><?php echo e($procentSprzedanych); ?>% / 100%</strong></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <style>
                .przycisk{
  background-color: blue; 
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
       document.addEventListener('DOMContentLoaded', function () {
    const filmSelect = document.getElementById('film_id');
    const dataOdInput = document.getElementById('data_od');
    const dataDoInput = document.getElementById('data_do');

   
    filmSelect.addEventListener('change', function () {
        const filmId = this.value;

        if (filmId) {
            fetch(`/statystyki/get-seans-dates/${filmId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.min_date && data.max_date) {
                        dataOdInput.value = data.min_date;
                        dataDoInput.value = data.max_date;
                    } else {
                        
                        dataOdInput.value = '';
                        dataDoInput.value = '';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
});

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
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/statystyki/index.blade.php ENDPATH**/ ?>
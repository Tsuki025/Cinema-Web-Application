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
            <?php echo e(__('Zarządzaj filmami')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4"><?php echo e(__('Lista filmów')); ?></h3>


                    <form method="GET" action="<?php echo e(route('filmy.index')); ?>" class="mb-4">
                        <input type="text" name="search" value="<?php echo e(old('search', $search)); ?>" class="" placeholder="Szukaj po tytule filmu" />
                        <button type="submit" class="szukaj">
                            <?php echo e(__('Szukaj')); ?>

                        </button>
                        <select name="okres" class="ml-4">
                            <option value="wszystkie" <?php echo e($selectedOkres == 'wszystkie' ? 'selected' : ''); ?>><?php echo e(__('Wszystkie')); ?></option>
                            <option value="aktualne" <?php echo e($selectedOkres == 'aktualne' ? 'selected' : ''); ?>><?php echo e(__('Aktualne')); ?></option>
                            <option value="ostatni_rok" <?php echo e($selectedOkres == 'ostatni_rok' ? 'selected' : ''); ?>><?php echo e(__('Sprzed roku')); ?></option>
                        </select>

                        <button type="submit" class="szukaj ml-4">
                            <?php echo e(__('Filtruj')); ?>

                        </button>
                        <br>
                        <label class="ml-4">
                            <input type="checkbox" id="togglePosters" class="cursor-pointer">
                            <?php echo e(__('Ukryj plakaty')); ?>

                        </label>

                    </form>

                    <a href="<?php echo e(route('filmy.create')); ?>" class="dodaj">
                        <?php echo e(__('Dodaj film')); ?>

                    </a>


                    <?php if(session('success')): ?>
                    <div class="alert alert-success" style="padding: 10px; background-color: green; color: white; margin-bottom: 20px;">
                        <?php echo e(session('success')); ?>

                    </div>
                    <?php endif; ?>
                    <br><br>
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2 text-left"><?php echo e(__('Tytuł')); ?></th>
                                <th class="border border-gray-300 px-4 py-2 text-left"><?php echo e(__('Dystrybucja')); ?></th>
                                <th class="border border-gray-300 px-4 py-2 text-left"><?php echo e(__('Cena Normalna')); ?></th>
                                <th class="border border-gray-300 px-4 py-2 text-left"><?php echo e(__('Cena Ulgowa')); ?></th>
                               
                                <th class="border border-gray-300 px-4 py-2 text-left poster-column"><?php echo e(__('Plakat')); ?></th>
                               
                                <th class="border border-gray-300 px-4 py-2 text-left"><?php echo e(__('Od ilu lat')); ?></th>
                                <th class="border border-gray-300 px-4 py-2 text-left"><?php echo e(__('Od kiedy ważny')); ?></th>
                                <th class="border border-gray-300 px-4 py-2 text-left"><?php echo e(__('Do kiedy ważny')); ?></th>
                                <th class="border border-gray-300 px-4 py-2 text-left"><?php echo e(__('Akcje')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $filmy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $film): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="<?php echo e($film->DoKiedy < now() ? 'bg-gray-300' : ''); ?>">
                                <td class="border border-gray-300 px-4 py-2"><?php echo e($film->Tytul); ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo e($film->Dystrybucja); ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo e(number_format($film->CenaNormalna, 2)); ?> zł</td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo e(number_format($film->CenaUlgowa, 2)); ?> zł</td>
                                <?php if(!request('hide_posters')): ?>
                                <td class="border border-gray-300 px-4 py-2 poster-column">
                                    <?php if($film->Plakat): ?>
                                    <img src="<?php echo e(asset('storage/' . $film->Plakat)); ?>" class="w-32">
                                    <?php else: ?>
                                    <?php echo e(__('Brak plakatu')); ?>

                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <td class="border border-gray-300 px-4 py-2"><?php echo e($film->Wiek); ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo e($film->OdKiedy); ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?php echo e($film->DoKiedy); ?></td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="<?php echo e(route('filmy.edit', $film->FilmID)); ?>" class="edytuj"><?php echo e(__('Edytuj')); ?></a>
                                    <?php if($film->seanse()->exists()): ?>

                                    <?php else: ?>
                                    <br><br>

                                    <form action="<?php echo e(route('filmy.destroy', $film->FilmID)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="usun" onclick="return confirm('Czy na pewno chcesz usunąć ten film?')">
                                            <?php echo e(__('Usuń')); ?>

                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">
                                    <?php echo e(__('Brak filmów do wyświetlenia.')); ?>

                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>
        img {
            width: 100px;
            height: 150px;
            object-fit: cover;
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

        .edytuj {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .szukaj {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .dodaj {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
    .bg-gray-300 {
        background-color: #e5e7eb; 
    }


    </style>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const togglePostersCheckbox = document.getElementById('togglePosters');
        const posterColumns = document.querySelectorAll('.poster-column');

        togglePostersCheckbox.addEventListener('change', () => {
            posterColumns.forEach(column => {
                if (togglePostersCheckbox.checked) {
                    column.style.display = 'none'; 
                } else {
                    column.style.display = ''; 
                }
            });
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/filmy/index.blade.php ENDPATH**/ ?>
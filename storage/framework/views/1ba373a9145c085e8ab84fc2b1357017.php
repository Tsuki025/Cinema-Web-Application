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
            <?php echo e(__('Grafik Pracowników')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Grafik pracowników</h1>

                    <form id="dateForm" method="GET" action="<?php echo e(route('grafik.index')); ?>" class="mb-6">
                        <label for="data" class="block font-medium text-sm text-gray-700">Wybierz dzień:</label>
                        <input type="date" id="data" name="data" value="<?php echo e($data); ?>" class="border rounded p-2">
                    </form>

                    <a href="<?php echo e(route('grafik.create', ['data' => $data])); ?>"
                        class="mb-4 inline-block bg-green-500 text-white px-4 py-2 rounded">
                        Dodaj do grafiku
                    </a>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Imię</th>
                                <th class="px-4 py-2">Nazwisko</th>
                                <th class="px-4 py-2">Rola</th>
                                <th class="px-4 py-2">Godzina Od</th>
                                <th class="px-4 py-2">Godzina Do</th>
                                <th class="px-4 py-2">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $grafik; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pozycja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="border px-4 py-2"><?php echo e($pozycja->pracownik->Imie); ?></td>
                                <td class="border px-4 py-2"><?php echo e($pozycja->pracownik->Nazwisko); ?></td>
                                <td class="border px-4 py-2"><?php echo e($pozycja->pracownik->Rola); ?></td>
                                <td class="border px-4 py-2"><?php echo e($pozycja->GodzinaOd); ?></td>
                                <td class="border px-4 py-2">
                                    <?php echo e($pozycja->GodzinaDo === '23:59:59' ? '00:00:00' : $pozycja->GodzinaDo); ?>

                                </td>

                                <td class="border px-4 py-2">
                                    <a href="<?php echo e(route('grafik.edit', $pozycja->GrafikID)); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded">Edytuj</a>
                                    <form action="<?php echo e(route('grafik.destroy', $pozycja->GrafikID)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded ml-2" onclick="return confirm('Czy na pewno chcesz usunąć ten wpis?')">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-4">Brak danych dla wybranego dnia</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('data').addEventListener('change', function () {
            document.getElementById('dateForm').submit();
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/grafik/index.blade.php ENDPATH**/ ?>
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
            <?php echo e(__('Edytuj Grafik Pracownika')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Edytuj wpis w grafiku</h1>
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger ">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="error-message"><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('grafik.update', $grafik->GrafikID)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <label for="data" class="block font-medium text-sm text-gray-700">Data:</label>
                        <input type="date" id="data" name="data" value="<?php echo e($grafik->data); ?>" class="border rounded p-2 w-full mb-4">

                        <label for="PracownikID" class="block font-medium text-sm text-gray-700">Wybierz pracownika:</label>
                        <select id="PracownikID" name="PracownikID" class="border rounded p-2 w-full mb-4">
                            <?php $__currentLoopData = $pracownicy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pracownik): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($pracownik->PracownikID); ?>" <?php if($grafik->PracownikID == $pracownik->PracownikID): ?> selected <?php endif; ?>>
                                <?php echo e($pracownik->Imie); ?> <?php echo e($pracownik->Nazwisko); ?> - <?php echo e($pracownik->Rola); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <label for="zmiana" class="block font-medium text-sm text-gray-700">Wybierz zmianę:</label>
                        <select id="zmiana" name="zmiana" class="border rounded p-2 w-full mb-4">
                            <option value="1" <?php if($grafik->GodzinaOd == '08:00'): ?> selected <?php endif; ?>>Zmiana 1 (08:00 - 16:00)</option>
                            <option value="2" <?php if($grafik->GodzinaOd == '16:00'): ?> selected <?php endif; ?>>Zmiana 2 (16:00 - 00:00)</option>
                        </select>

                        <div class="flex justify-between">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Zapisz zmiany</button>
                            <a href="<?php echo e(route('grafik.index', ['data' => $grafik->data])); ?>" class="bg-red-500 text-white px-4 py-2 rounded">Anuluj</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <style>
        .error-message {
            color: red;
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
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/grafik/edit.blade.php ENDPATH**/ ?>
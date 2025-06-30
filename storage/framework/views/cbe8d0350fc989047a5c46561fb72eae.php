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
            <?php echo e(__('Dashboard Właściciela')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php echo e(__("Witaj, właścicielu!")); ?>


                    <nav class="mt-4">
                        <ul class="space-y-2">
                            <li>
                                <a href="<?php echo e(route('filmy.index')); ?>" class="text-blue-500 hover:underline">
                                    <?php echo e(__('Zarządzaj filmami')); ?>

                                </a>
                                <br>
                                <a href="<?php echo e(route('harmonogram.index')); ?>" class="text-blue-500 hover:underline">
                                    <?php echo e(__('Harmonogram')); ?>

                                </a>
                                <br>
                                <a href="<?php echo e(route('grafik.index')); ?>" class="text-blue-500 hover:underline">
                                    <?php echo e(__('Grafik')); ?>

                                </a>
                                <br>
                                <a href="<?php echo e(route('pracownicy.index')); ?>" class="text-blue-500 hover:underline">
                                        <?php echo e(__('Zarządzaj pracownikami')); ?>

                                    </a>
                                <br>
                                <a href="<?php echo e(route('statystyki.index')); ?>" class="text-blue-500 hover:underline">
                                        <?php echo e(__('Statystyki seansów')); ?>

                                    </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/dashboard/wlasciciel.blade.php ENDPATH**/ ?>
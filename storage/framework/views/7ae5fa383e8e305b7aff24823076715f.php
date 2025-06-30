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
            <?php echo e(__('Dashboard Sprzątanie')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Twój grafik</h3>

                        
                        <form method="GET" action="<?php echo e(route('sprzatanie.index')); ?>" id="dataForm" class="mb-6">
                            <label for="data" class="block text-sm font-medium text-gray-700">Wybierz datę:</label>
                            <input 
                                type="date" 
                                id="data" 
                                name="data" 
                                value="<?php echo e(request('data', \Carbon\Carbon::now()->toDateString())); ?>"
                                class="mt-1 p-2 border rounded w-64"
                            >
                        </form>

                        
                        <div class="mb-6">
                            <h4 class="font-semibold">Godziny pracy:</h4>
                            <?php if($grafikPracy): ?>
                                <?php
                                $godzinaOd = \Carbon\Carbon::parse($grafikPracy->GodzinaOd)->format('H:i');
                                $godzinaDo = \Carbon\Carbon::parse($grafikPracy->GodzinaDo)->format('H:i');

                                if ($grafikPracy->GodzinaDo === '23:59:59') {
                                    $godzinaDo = '00:00';
                                }
                                ?>
                                <p><?php echo e($godzinaOd); ?> - <?php echo e($godzinaDo); ?></p>
                            <?php else: ?>
                                <p class="text-gray-600">Brak wpisów w grafiku pracy dla wybranej daty.</p>
                            <?php endif; ?>
                        </div>

                       
                        <h4 class="font-semibold">Godziny sprzątania:</h4>
                        <?php if($sprzatania->isEmpty()): ?>
                            <p class="text-gray-600">Brak zaplanowanego sprzątania dla wybranej daty.</p>
                        <?php else: ?>
                            <?php
                            $sprzataniaGrupowane = $sprzatania->groupBy('SalaID');
                            ?>
                            <?php $__currentLoopData = $sprzataniaGrupowane; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salaId => $sprzatanieList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-4">
                                    <p><strong>Sala:</strong> <?php echo e($sprzatanieList->first()->sala->Nazwa); ?></p>
                                    <?php $__currentLoopData = $sprzatanieList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprzatanie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p>
                                            <strong>Godziny:</strong> 
                                            <?php echo e(\Carbon\Carbon::parse($sprzatanie->GodzinaRozpoczecia)->format('H:i')); ?> -
                                            <?php echo e(\Carbon\Carbon::parse($sprzatanie->GodzinaZakonczenia)->format('H:i')); ?>

                                        </p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        document.getElementById('data').addEventListener('change', function () {
            document.getElementById('dataForm').submit(); 
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
<?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/sprzatanie/index.blade.php ENDPATH**/ ?>
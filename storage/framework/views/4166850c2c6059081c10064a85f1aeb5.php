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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Harmonogram Seansów i Sprzątania')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <?php if(session('success')): ?>
            <div class="alert alert-success" style="padding: 10px; background-color: green; color: white; margin-bottom: 20px;">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3><?php echo e(__('Harmonogram na dzień: ')); ?> <?php echo e($today->format('d-m-Y')); ?></h3>

                    <form action="<?php echo e(route('harmonogram.index')); ?>" method="GET" class="mb-4" id="dateForm">
                        <label for="date" class="mr-2">Wybierz dzień: </label>
                        <input type="date" id="date" name="date" value="<?php echo e(request('date', $today->toDateString())); ?>" class="py-2 px-4 border rounded">
                    </form>

                    <a href="<?php echo e(route('harmonogram.create')); ?>" class="przyciski">Dodaj Seans</a>
                    <a href="<?php echo e(route('harmonogram.createSprzatanie')); ?>" class="przyciski">Dodaj Sprzątanie</a>


                    <div class="legend">
                        <div class="legend-item">
                            <span class="color-box" style="background-color: green;"></span> Sprzątanie
                        </div>
                        <div class="legend-item">
                            <span class="color-box" style="background-color: #007BFF;"></span> Publiczny Seans
                        </div>
                        <div class="legend-item">
                            <span class="color-box" style="background-color:rgb(255, 166, 0);"></span> Prywatny Seans
                        </div>
                        <div class="legend-item">
                            <span class="color-box" style="background-color: red;"></span> Anulowany Seans
                        </div>
                    </div>

                    <?php $__currentLoopData = $sale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sala): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <h4 class="mt-6 text-xl font-semibold"><?php echo e($sala->Nazwa); ?></h4>

                    <div class="schedule-container">
                        <div class="schedule-grid">
                            <?php for($h = 8; $h <= 24; $h++): ?>
                                <div class="hour"><?php echo e($h == 24 ? '00:00' : sprintf('%02d:00', $h)); ?></div>
                        <?php endfor; ?>
                    </div>

                    <div class="schedule-rows">
                        <?php $__currentLoopData = $seanse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($seans->SalaID === $sala->SalaID): ?>
                        <?php
                        $start = (strtotime($seans->GodzinaRozpoczecia) - strtotime('08:00')) / 3600;
                        $end = (strtotime($seans->GodzinaZakonczenia) - strtotime('08:00')) / 3600;
                        $duration = $end - $start;
                        ?>

                        <div class="event seans
                                                <?php if($seans->Publicznosc == 'Prywatny'): ?> prywatny <?php endif; ?>
                                                <?php if($seans->anulowany == 1): ?> anulowany <?php endif; ?>"
                            style="left: calc(<?php echo e($start); ?> * 5.88%);
                                                width: calc(<?php echo e($duration); ?> * 5.88%);"
                            onclick="window.location='<?php echo e(route('harmonogram.editSeans', ['id' => $seans->SeansID])); ?>';"
                            title="Edytuj seans">
                            <?php echo e($seans->film->Tytul); ?> (<?php echo e($seans->Typ2); ?>)
                        </div>

                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = $sprzatanie; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprzatanie_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($sprzatanie_item->SalaID === $sala->SalaID): ?>
                        <?php
                        $start = (strtotime($sprzatanie_item->GodzinaRozpoczecia) - strtotime('08:00')) / 3600;
                        $end = (strtotime($sprzatanie_item->GodzinaZakonczenia) - strtotime('08:00')) / 3600;
                        $duration = $end - $start;
                        ?>

                        <div class="event sprzatanie"
                            style="left: calc(<?php echo e($start); ?> * 5.88%);
                                                    width: calc(<?php echo e($duration); ?> * 5.88%);"
                            onclick="window.location='<?php echo e(route('harmonogram.editSprzatanie', ['id' => $sprzatanie_item->SprzatanieID])); ?>';"
                            title="Edytuj sprzatanie">

                        </div>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    </div>

    <style>
        .schedule-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 10px;
            position: relative;
        }

        .schedule-grid {
            display: flex;
            border-bottom: 2px solid #ddd;
        }

        .hour {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            padding: 5px;
            border-right: 1px solid #ccc;
            width: 5.88%;
        }

        .schedule-rows {
            position: relative;
            height: 50px;
            display: flex;
            position: relative;
            width: 100%;
        }

        .event {
            position: absolute;
            padding: 5px;
            font-size: 12px;
            text-align: center;
            color: white;
            border-radius: 4px;
            height: 40px;
        }

        .seans {
            background-color: #007BFF;
        }

        .prywatny {
            background-color: rgb(255, 166, 0);
        }

        .anulowany {
            background-color: red;
        }

        .sprzatanie {
            background-color: green;
        }


        .legend {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 15px;
            font-size: 14px;
        }

        .color-box {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 8px;
        }

        .przyciski {
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
        document.getElementById('date').addEventListener('change', function() {
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/harmonogram/index.blade.php ENDPATH**/ ?>
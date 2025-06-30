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
            <?php echo e(__('Zarządzanie Pracownikami')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php echo e(__("Witaj w zarządzaniu pracownikami!")); ?>


                    

                    <form action="<?php echo e(route('pracownicy.index')); ?>" method="GET" class="mb-4">
                        <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Szukaj po imieniu lub nazwisku..." class="border p-2 rounded">
                        <button type="submit" class="przyciski">
                            <?php echo e(__('Szukaj')); ?>

                        </button>
                    </form>
                    <a href="<?php echo e(route('pracownicy.create')); ?>" class="przyciski">
                        <?php echo e(__('Dodaj Pracownika')); ?>

                    </a>
                    <?php if(session('success')): ?>
                        <div class="bg-green-100 text-green-800 p-4 mb-4 rounded">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <table class="min-w-full table-auto mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b"><?php echo e(__('Imię')); ?></th>
                                <th class="px-4 py-2 border-b"><?php echo e(__('Nazwisko')); ?></th>
                                <th class="px-4 py-2 border-b"><?php echo e(__('Email')); ?></th>
                                <th class="px-4 py-2 border-b"><?php echo e(__('Rola')); ?></th>
                                <th class="px-4 py-2 border-b"><?php echo e(__('Akcje')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pracownicy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pracownik): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-2 border-b"><?php echo e($pracownik->Imie); ?></td>
                                    <td class="px-4 py-2 border-b"><?php echo e($pracownik->Nazwisko); ?></td>
                                    <td class="px-4 py-2 border-b"><?php echo e($pracownik->Email); ?></td>
                                    <td class="px-4 py-2 border-b"><?php echo e($pracownik->Rola); ?></td>
                                    <td class="px-4 py-2 border-b">
                                    <form action="<?php echo e(route('pracownicy.destroy', $pracownik->PracownikID)); ?>" method="POST" style="display:inline;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>  
    <button type="submit" class="usun">
        <?php echo e(__('Usuń')); ?>

    </button>
</form>
    
                                   

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <?php if($pracownicy->isEmpty()): ?>
                        <p class="text-center mt-4"><?php echo e(__('Brak pracowników do wyświetlenia.')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <style>
          .usun{
  background-color: red; 
  color: white; 
  border: none;
  padding: 10px 18px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px; 
  transition: background 0.3s;
}
.przyciski{
    background-color: blue; 
  color: white; 
  border: none;
  padding: 10px 18px;
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
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/pracownicy/index.blade.php ENDPATH**/ ?>
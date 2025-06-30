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
     <?php $__env->endSlot(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja Profilu</title>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <?php echo e(__('Edycja Profilu')); ?>

                </h2>
            </div>
        </header>

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <?php if(session('success')): ?>
                                <div class="mb-4 text-green-600">
                                    <?php echo e(session('success')); ?>

                                </div>
                            <?php endif; ?>

                            <form method="POST" action="<?php echo e(route('profile.update')); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?> 

                                <div>
                                    <label for="Imie" class="block font-medium text-sm text-gray-700"><?php echo e(__('Imię')); ?></label>
                                    <input id="Imie" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="Imie" value="<?php echo e(old('Imie', $user->Imie)); ?>" required>
                                </div>

                                <div class="mt-4">
                                    <label for="Nazwisko" class="block font-medium text-sm text-gray-700"><?php echo e(__('Nazwisko')); ?></label>
                                    <input id="Nazwisko" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="Nazwisko" value="<?php echo e(old('Nazwisko', $user->Nazwisko)); ?>" required>
                                </div>

                                <div class="mt-4">
                                    <label for="Email" class="block font-medium text-sm text-gray-700"><?php echo e(__('Email')); ?></label>
                                    <input id="Email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="email" name="Email" value="<?php echo e(old('Email', $user->Email)); ?>" required>
                                </div>

                                <div class="mt-4">
                                    <label for="Haslo" class="block font-medium text-sm text-gray-700"><?php echo e(__('Nowe Hasło')); ?></label>
                                    <input id="Haslo" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="password" name="Haslo" autocomplete="new-password">
                                </div>

                                <div class="mt-4">
                                    <label for="Haslo_confirmation" class="block font-medium text-sm text-gray-700"><?php echo e(__('Potwierdź Hasło')); ?></label>
                                    <input id="Haslo_confirmation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="password" name="Haslo_confirmation" autocomplete="new-password">
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button type="submit" class="zapisz">
                                        <?php echo e(__('Zapisz zmiany')); ?>

                                    </button>
                                    <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('dashboard'),'class' => 'anuluj','active' => request()->routeIs('dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'class' => 'anuluj','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard'))]); ?>
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
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <style>
        .zapisz{
            background-color: blue; 
  color: white; 
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px; 
  transition: background 0.3s;
        }
          .anuluj{
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
</body>
</html>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/profil/edit.blade.php ENDPATH**/ ?>
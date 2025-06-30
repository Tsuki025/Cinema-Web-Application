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
            <?php echo e(__('Edytuj Seans')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold"><?php echo e(__('Edytuj Seans: ')); ?> <?php echo e($seans->film->Tytul); ?></h3>

                    <form method="POST" action="<?php echo e(route('harmonogram.updateSeans', $seans->SeansID)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        
                        <div>
                            <label for="FilmID">Film</label>
                            <select name="FilmID" id="FilmID">
    <?php $__currentLoopData = $filmy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $film): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($film->FilmID); ?>" <?php echo e($film->FilmID == $seans->FilmID ? 'selected' : ''); ?>>
            <?php echo e($film->Tytul); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

                        </div>

                        
                        <div>
                            <label for="SalaID">Sala</label>
                            <select name="SalaID" required>
                                <?php $__currentLoopData = $sale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sala): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sala->SalaID); ?>" <?php echo e($sala->SalaID == $seans->SalaID ? 'selected' : ''); ?>><?php echo e($sala->Nazwa); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                       
                        <div>
                            <label for="DataSeansu">Data Seansu</label>
                            <input type="date" name="DataSeansu" value="<?php echo e($seans->DataSeansu); ?>" required>

                            <label for="GodzinaRozpoczecia">Godzina Rozpoczęcia</label>
                            <input type="time" name="GodzinaRozpoczecia" value="<?php echo e($seans->GodzinaRozpoczecia->format('H:i')); ?>" required>

                            <label for="GodzinaZakonczenia">Godzina Zakończenia</label>
                            <input type="time" name="GodzinaZakonczenia" value="<?php echo e($seans->GodzinaZakonczenia->format('H:i')); ?>" required>
                        </div>

                        
                        <div>
                            <label for="Typ">Typ</label>
                            <select name="Typ" required>
                                <option value="2D" <?php echo e($seans->Typ == '2D' ? 'selected' : ''); ?>>2D</option>
                                <option value="3D" <?php echo e($seans->Typ == '3D' ? 'selected' : ''); ?>>3D</option>
                            </select>
                        </div>

                        
                        <div>
                            <label for="Typ2">Dubbing / Napisy</label>
                            <select name="Typ2" required>
                                <option value="Napisy" <?php echo e($seans->Typ2 == 'Napisy' ? 'selected' : ''); ?>>Napisy</option>
                                <option value="Dubbing" <?php echo e($seans->Typ2 == 'Dubbing' ? 'selected' : ''); ?>>Dubbing</option>
                                <option value="Lektor" <?php echo e($seans->Typ2 == 'Lektor' ? 'selected' : ''); ?>>Lektor</option>
                            </select>
                        </div>
                        <div>
                            <label for="Publicznosc">Publiczny/ Prywatny</label>
                            <select name="Publicznosc" required>
                                <option value="Publiczny" <?php echo e($seans->Publicznosc == 'Publiczny' ? 'selected' : ''); ?>>Publiczny</option>
                                <option value="Prywatny" <?php echo e($seans->Publicznosc == 'Prywatny' ? 'selected' : ''); ?>>Prywatny</option>
                                
                            </select>
                        </div>

                        <button type="submit" class="przycisk">Zapisz zmiany</button>
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
                    <br>
                    <form action="<?php echo e(route('harmonogram.destroySeans', $seans->SeansID)); ?>" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć ten seans?')">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    
    <button type="submit" class="usun">
        Usuń Seans
    </button>
</form>


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
.usun{
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
<?php /**PATH C:\xampp\htdocs\dashboard\kino\resources\views/harmonogram/editSeans.blade.php ENDPATH**/ ?>
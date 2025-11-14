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
     <?php $__env->slot('header', null, []); ?> <h2 class="font-semibold text-xl text-gray-800 leading-tight">入出庫登録</h2> <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <?php if($errors->any()): ?>
            <div class="mb-4 rounded bg-red-50 text-red-800 px-4 py-2 text-sm">
                <ul class="list-disc ms-5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($e); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('transactions.store')); ?>" class="bg-white p-6 shadow-sm ring-1 ring-gray-200 rounded space-y-4">
            <?php echo csrf_field(); ?>

            <div>
                <label class="block text-sm text-gray-700">商品</label>
                <select name="product_id" class="mt-1 w-full border-gray-300 rounded">
                    <option value="">選択してください</option>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php if(old('product_id', request('product_id'))==$p->id): echo 'selected'; endif; ?>>
                            <?php echo e($p->name); ?> (<?php echo e($p->product_code); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">区分</label>
                    <select name="type" class="mt-1 w-full border-gray-300 rounded">
                        <option value="IN"  <?php if(old('type')==='IN'): echo 'selected'; endif; ?>>IN（入庫）</option>
                        <option value="OUT" <?php if(old('type')==='OUT'): echo 'selected'; endif; ?>>OUT（出庫）</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">数量</label>
                    <input type="number" name="quantity" min="1" value="<?php echo e(old('quantity', 1)); ?>" class="mt-1 w-full border-gray-300 rounded">
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">日付</label>
                    <input type="date" name="transaction_date" value="<?php echo e(old('transaction_date', now()->toDateString())); ?>" class="mt-1 w-full border-gray-300 rounded">
                </div>
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">備考</label>
                    <input type="text" name="remarks" value="<?php echo e(old('remarks')); ?>" class="mt-1 w-full border-gray-300 rounded">
                </div>
            </div>

            <div class="pt-2 flex gap-3">
                <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>登録 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                <a href="<?php echo e(route('transactions.index')); ?>" class="text-gray-600 hover:underline">戻る</a>
            </div>
        </form>
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
<?php /**PATH C:\Users\shiny\OneDrive\デスクトップ\my-portfolio\works\inventory-forecast-app\resources\views/transactions/create.blade.php ENDPATH**/ ?>
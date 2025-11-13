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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">入出庫一覧</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <?php if(session('success')): ?>
        <div class="mb-4 rounded bg-green-50 text-green-800 px-4 py-2 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <a href="<?php echo e(route('transactions.create')); ?>" class="text-blue-600 hover:underline inline-block mb-3">＋新規登録</a>

    <div class="overflow-x-auto bg-white shadow-sm ring-1 ring-gray-200 rounded">
        <table class="min-w-full table-auto">
        <thead class="bg-gray-50 text-gray-600 text-sm">
        <tr>
            <th class="px-3 py-2 text-left">日付</th>
            <th class="px-3 py-2 text-left">商品名</th>
            <th class="px-3 py-2 text-left">商品管理番号</th>
            <th class="px-3 py-2 text-left">区分</th>
            <th class="px-3 py-2 text-right">数量</th>
            <th class="px-3 py-2 text-left">備考</th>
            <th class="px-3 py-2 text-left">操作</th>
        </tr>
        </thead>
        <tbody class="text-sm">
        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-t hover:bg-gray-50">
                <td class="px-3 py-2"><?php echo e($t->transaction_date->format('Y-m-d')); ?></td>
                <td class="px-3 py-2"><?php echo e($t->product->name); ?></td>
                <td class="px-3 py-2"><?php echo e($t->product->product_code); ?></td>
                <td class="px-3 py-2 text-center">
                    <?php if($t->type === 'IN'): ?>
                        <span class="text-green-600 font-semibold">IN（入庫）</span>
                    <?php else: ?>
                        <span class="text-red-600 font-semibold">OUT（出庫）</span>
                    <?php endif; ?>
                </td>
                <td class="px-3 py-2 text-right"><?php echo e(number_format($t->quantity)); ?></td>
                <td class="px-3 py-2"><?php echo e($t->remarks); ?></td>
                <td class="px-3 py-2 space-x-3">
                    <div class="flex justify-end gap-2">
                        <a href="<?php echo e(route('transactions.edit', $t)); ?>"
                        class="inline-flex items-center px-2 py-1 text-sm rounded border border-blue-500 text-blue-600 hover:bg-blue-50">
                            編集
                        </a>    
                        <form action="<?php echo e(route('transactions.destroy', $t)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    class="inline-flex items-center px-2 py-1 text-sm rounded border border-red-500 text-red-600 hover:bg-red-50"
                                    onclick="return confirm('削除しますか？')">
                                削除
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        </table>
    </div>

    <div class="mt-4"><?php echo e($transactions->links()); ?></div>
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
<?php /**PATH C:\Users\shiny\OneDrive\デスクトップ\my-portfolio\works\inventory-forecast-app\laravel\resources\views/transactions/index.blade.php ENDPATH**/ ?>
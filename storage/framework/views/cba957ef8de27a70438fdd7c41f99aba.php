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
        <div class="relative">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品一覧
            </h2>

            <div class="absolute inset-0 flex justify-center items-center">
                <span class="text-base text-blue-800 font-semibold">
                    今日は <?php echo e(now()->format('Y-m-d')); ?> です
                </span>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <?php if($errors->any()): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="m-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
    
        <?php if(session('success')): ?>
            <div class="mb-4 rounded bg-green-50 text-green-800 px-4 py-2 text-sm">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <a href="<?php echo e(route('products.create')); ?>" class="text-blue-600 hover:underline inline-block mb-3">＋新規登録</a>

        <div class="overflow-x-auto bg-white shadow-sm ring-1 ring-gray-200 rounded">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50 text-gray-600 text-sm">
                    <tr>
                        <th class="px-3 py-2 text-left">商品名</th>
                        <th class="px-3 py-2 text-left">商品管理番号</th>
                        <th class="px-3 py-2 text-right">価格（円）</th>
                        <th class="px-3 py-2 text-right">在庫</th>
                        <th class="px-3 py-2 text-right">発注推奨日</th>
                        <th class="px-3 py-2 text-right">安全在庫</th>
                        <th class="px-3 py-2 text-right">リードタイム(日)</th>
                        <th class="px-3 py-2 text-right">操作</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isLow = ($p->current_stock ?? 0) < ($p->safety_stock ?? 0);
                        ?>
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-3 py-2">
                                <a href="<?php echo e(route('products.edit', $p)); ?>" class="text-blue-700 hover:underline">
                                    <?php echo e($p->name); ?>

                                </a>
                            </td>
                            <td class="px-3 py-2"><?php echo e($p->product_code); ?></td>
                            <td class="px-3 py-2 text-right"><?php echo e(number_format($p->price)); ?></td>
                            <td class="px-3 py-2 text-right <?php echo e($isLow ? 'text-red-600 font-semibold' : ''); ?>">
                                <?php echo e(number_format($p->current_stock)); ?>

                            </td>
                            <td class="px-3 py-2 text-right"><?php echo e($p->reorder_date ?? '—'); ?></td>
                            <td class="px-3 py-2 text-right"><?php echo e(number_format($p->safety_stock)); ?></td>
                            <td class="px-3 py-2 text-right"><?php echo e(number_format($p->lead_time_days)); ?></td>
                            <td class="px-3 py-2">
                                <div class="flex justify-end gap-2">
                                    <a href="<?php echo e(route('products.edit', $p)); ?>"
                                    class="inline-flex items-center px-2 py-1 text-sm rounded border border-blue-500 text-blue-600 hover:bg-blue-50">
                                        編集
                                    </a>

                                    <a href="<?php echo e(route('products.forecast', $p)); ?>"
                                    class="inline-flex items-center px-2 py-1 text-sm rounded border border-emerald-500 text-emerald-600 hover:bg-emerald-50">
                                        予測
                                    </a>

                                    <form action="<?php echo e(route('products.destroy', $p)); ?>" method="POST" class="inline">
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

        <?php if(method_exists($products, 'links')): ?>
            <div class="mt-4"><?php echo e($products->links()); ?></div>
        <?php endif; ?>
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
<?php /**PATH C:\Users\shiny\OneDrive\デスクトップ\my-portfolio\works\inventory-forecast-app\resources\views/products/index.blade.php ENDPATH**/ ?>
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
            需要予測（SMA）：<?php echo e($product->name); ?>（<?php echo e($product->product_code); ?>）
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 shadow-sm ring-1 ring-gray-200 rounded">
            <h3 class="font-semibold mb-3">予測サマリー</h3>
            <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500">平均出庫/日（14日SMA）</dt>
                    <dd class="text-lg"><?php echo e(number_format($avgDaily, 2)); ?></dd>
                </div>
                <div>
                    <dt class="text-gray-500">発注推奨日</dt>
                    <dd class="text-lg"><?php echo e($reorder ?? '—'); ?></dd>
                </div>
                <div>
                    <dt class="text-gray-500">在庫切れ見込み日</dt>
                    <dd class="text-lg"><?php echo e($stockout ?? '—'); ?></dd>
                </div>
                <div>
                    <dt class="text-gray-500">枯渇までの日数</dt>
                    <dd class="text-lg"><?php echo e($daysLeft ?? '—'); ?></dd>
                </div>
            </dl>
            <p class="mt-3 text-xs text-gray-500">
                * 出庫(OUT)の直近14日合計 ÷ 14 による単純移動平均。安全在庫とリードタイムを考慮して発注推奨日を算出。
            </p>
        </div>

        <div>
            <a href="<?php echo e(route('products.index')); ?>" class="text-gray-600 hover:underline">← 商品一覧へ戻る</a>
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
<?php /**PATH C:\Users\shiny\OneDrive\デスクトップ\my-portfolio\works\inventory-forecast-app\laravel\resources\views/forecasts/show.blade.php ENDPATH**/ ?>
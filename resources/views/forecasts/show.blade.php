<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            需要予測（SMA）：{{ $product->name }}（{{ $product->product_code }}）
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 shadow-sm ring-1 ring-gray-200 rounded">
            <h3 class="font-semibold mb-3">予測サマリー</h3>
            <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500">平均出庫/日（14日SMA）</dt>
                    <dd class="text-lg">{{ number_format($avgDaily, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">発注推奨日</dt>
                    <dd class="text-lg">{{ $reorder ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">在庫切れ見込み日</dt>
                    <dd class="text-lg">{{ $stockout ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">枯渇までの日数</dt>
                    <dd class="text-lg">{{ $daysLeft ?? '—' }}</dd>
                </div>
            </dl>
            <p class="mt-3 text-xs text-gray-500">
                * 出庫(OUT)の直近14日合計 ÷ 14 による単純移動平均。安全在庫とリードタイムを考慮して発注推奨日を算出。
            </p>
        </div>

        <div>
            <a href="{{ route('products.index') }}" class="text-gray-600 hover:underline">← 商品一覧へ戻る</a>
        </div>
    </div>
</x-app-layout>

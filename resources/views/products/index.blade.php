<x-app-layout>
    <x-slot name="header">
        <div class="relative">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品一覧
            </h2>

            <div class="absolute inset-0 flex justify-center items-center">
                <span class="text-base text-blue-800 font-semibold">
                    今日は {{ now()->format('Y-m-d') }} です
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- バリデーションエラー -->
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif
        <!-- 商品削除のエラー用 -->
        @if (session('delete_error'))
            <div class="text-red-600 font-semibold mb-3">
                {{ session('delete_error') }}
            </div>
        @endif
        <!-- 成功 -->
        @if (session('success'))
            <div class="mb-4 rounded bg-green-50 text-green-800 px-4 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('products.create') }}" class="text-blue-600 hover:underline inline-block mb-3">＋新規登録</a>

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
                    @foreach ($products as $p)
                        @php
                            $isLow = ($p->current_stock ?? 0) < ($p->safety_stock ?? 0);
                        @endphp
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-3 py-2">
                                <a href="{{ route('products.edit', $p) }}" class="text-blue-700 hover:underline">
                                    {{ $p->name }}
                                </a>
                            </td>
                            <td class="px-3 py-2">{{ $p->product_code }}</td>
                            <td class="px-3 py-2 text-right">{{ number_format($p->price) }}</td>
                            <td class="px-3 py-2 text-right {{ $isLow ? 'text-red-600 font-semibold' : '' }}">
                                {{ number_format($p->current_stock) }}
                            </td>
                            <td class="px-3 py-2 text-right">{{ $p->reorder_date ?? '—' }}</td>
                            <td class="px-3 py-2 text-right">{{ number_format($p->safety_stock) }}</td>
                            <td class="px-3 py-2 text-right">{{ number_format($p->lead_time_days) }}</td>
                            <td class="px-3 py-2">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('products.edit', $p) }}"
                                    class="inline-flex items-center px-2 py-1 text-sm rounded border border-blue-500 text-blue-600 hover:bg-blue-50">
                                        編集
                                    </a>

                                    <a href="{{ route('products.forecast', $p) }}"
                                    class="inline-flex items-center px-2 py-1 text-sm rounded border border-emerald-500 text-emerald-600 hover:bg-emerald-50">
                                        予測
                                    </a>

                                    <form action="{{ route('products.destroy', $p) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-2 py-1 text-sm rounded border border-red-500 text-red-600 hover:bg-red-50"
                                                onclick="return confirm('削除しますか？')">
                                            削除
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (method_exists($products, 'links'))
            <div class="mt-4">{{ $products->links() }}</div>
        @endif
    </div>
</x-app-layout>

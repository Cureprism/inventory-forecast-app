<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品編集：{{ $product->name }}</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-4 rounded bg-red-50 text-red-800 px-4 py-2 text-sm">
                <ul class="list-disc ms-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product) }}" class="bg-white p-6 shadow-sm ring-1 ring-gray-200 rounded space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm text-gray-700">商品名</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="mt-1 w-full border-gray-300 rounded">
            </div>

            <div>
                <label class="block text-sm text-gray-700">商品管理番号</label>
                <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}" class="mt-1 w-full border-gray-300 rounded">
            </div>

            <div>
                <label class="block text-sm text-gray-700">価格（円）</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="mt-1 w-full border-gray-300 rounded">
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">安全在庫</label>
                    <input type="number" name="safety_stock" value="{{ old('safety_stock', $product->safety_stock) }}" class="mt-1 w-full border-gray-300 rounded">
                </div>
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">リードタイム(日)</label>
                    <input type="number" name="lead_time_days" value="{{ old('lead_time_days', $product->lead_time_days) }}" class="mt-1 w-full border-gray-300 rounded">
                </div>
            </div>

            <div class="pt-2 flex gap-3">
                <x-primary-button>更新</x-primary-button>
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:underline">一覧へ戻る</a>
            </div>
        </form>
    </div>
</x-app-layout>

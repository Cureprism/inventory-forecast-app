<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">入出庫編集</h2></x-slot>

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

        <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="bg-white p-6 shadow-sm ring-1 ring-gray-200 rounded space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm text-gray-700">商品</label>
                <select name="product_id" class="mt-1 w-full border-gray-300 rounded">
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}" @selected(old('product_id', $transaction->product_id)==$p->id)>
                            {{ $p->name }} ({{ $p->product_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">区分</label>
                    <select name="type" class="mt-1 w-full border-gray-300 rounded">
                        <option value="IN"  @selected(old('type', $transaction->type)==='IN')>IN（入庫）</option>
                        <option value="OUT" @selected(old('type', $transaction->type)==='OUT')>OUT（出庫）</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">数量</label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity', $transaction->quantity) }}" class="mt-1 w-full border-gray-300 rounded">
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">日付</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" class="mt-1 w-full border-gray-300 rounded">
                </div>
                <div class="flex-1">
                    <label class="block text-sm text-gray-700">備考</label>
                    <input type="text" name="remarks" value="{{ old('remarks', $transaction->remarks) }}" class="mt-1 w-full border-gray-300 rounded">
                </div>
            </div>

            <div class="pt-2 flex gap-3">
                <x-primary-button>更新</x-primary-button>
                <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:underline">戻る</a>
            </div>
        </form>
    </div>
</x-app-layout>

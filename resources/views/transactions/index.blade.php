<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">入出庫一覧</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    @if (session('success'))
        <div class="mb-4 rounded bg-green-50 text-green-800 px-4 py-2 text-sm">{{ session('success') }}</div>
    @endif

    <a href="{{ route('transactions.create') }}" class="text-blue-600 hover:underline inline-block mb-3">＋新規登録</a>

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
        @foreach ($transactions as $t)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-3 py-2">{{ $t->transaction_date->format('Y-m-d') }}</td>
                <td class="px-3 py-2">{{ $t->product->name }}</td>
                <td class="px-3 py-2">{{ $t->product->product_code }}</td>
                <td class="px-3 py-2 text-center">
                    @if ($t->type === 'IN')
                        <span class="text-green-600 font-semibold">IN（入庫）</span>
                    @else
                        <span class="text-red-600 font-semibold">OUT（出庫）</span>
                    @endif
                </td>
                <td class="px-3 py-2 text-right">{{ number_format($t->quantity) }}</td>
                <td class="px-3 py-2">{{ $t->remarks }}</td>
                <td class="px-3 py-2 space-x-3">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('transactions.edit', $t) }}"
                        class="inline-flex items-center px-2 py-1 text-sm rounded border border-blue-500 text-blue-600 hover:bg-blue-50">
                            編集
                        </a>    
                        <form action="{{ route('transactions.destroy', $t) }}" method="POST" class="inline">
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

    <div class="mt-4">{{ $transactions->links() }}</div>
    </div>
</x-app-layout>

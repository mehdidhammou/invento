<x-export-layout>
    <div class="w-full flex items-center gap-8 flex-col justify-start p-8">
        <div class="w-full flex items-center justify-between">
            <div>
                logo
            </div>
            <div>
                <h1 class="tex-4xl font-bold text-end"> SARL INVENTO.</h1>
                <div class="flex items-center justify-between">
                    <span>Order Number</span>
                    <span>
                        {{ $order->id }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Order Date</span>
                    <span>
                        {{ $order->date }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Supplier</span>
                    <span>
                        {{ $order->supplier->name }}
                    </span>
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Product name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Quantity
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderProducts()->with('product')->get() as $orderProduct)
                            <tr class="bg-white border-b ">
                                <td class="px-6 py-4">
                                    {{ $orderProduct->product->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $orderProduct->quantity }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-export-layout>

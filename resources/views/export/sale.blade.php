<x-export-layout>
    <div class="w-full flex items-center gap-8 flex-col justify-start">
        <div class="w-full p-4 border border-gray-200 rounded-md">
            <div class="w-full flex items-center justify-around">
                <h1 class="font-semibold">
                    Sale ID:
                </h1>
                <span>
                    {{ $sale->id }}
                </span>
                <h1 class="font-semibold">
                    Order Date:
                </h1>
                <span>
                    {{ $sale->date }}
                </span>

            </div>
        </div>
        <table class="w-full text-base font-semibold text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Product name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Quantity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->saleProducts as $saleProduct)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <td class="px-6 py-4">
                            {{ $saleProduct->product->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $saleProduct->quantity }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $saleProduct->unit_price }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="w-full flex items-center justify-between gap-4">
            <div class="w-1/2 border border-gray-200 rounded-md p-4">
                <h1 class="font-semibold uppercase">Client Info</h1>
                <hr class="w-full bg-gray-600 my-2">
                <div class="flex flex-col gap-2">
                    <div class="w-full flex justify-between">
                        <p>
                            Name:
                        </p>
                        <p class="font-semibold">
                            {{ $sale->client->name }}
                        </p>
                    </div>
                    <hr class="w-full bg-gray-600 my-2">
                    <div class="w-full flex justify-between">
                        <p>
                            Address:
                        </p>
                        <p class="font-semibold">
                            {{ $sale->client->email }}
                        </p>
                    </div>
                    <hr class="w-full bg-gray-600 my-2">
                    <div class="w-full flex justify-between">
                        <p>
                            Phone:
                        </p>
                        <p class="font-semibold">
                            {{ $sale->client->phone }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-1/2 border border-gray-200 rounded-md p-4">
                <h1 class="font-semibold uppercase">Summary</h1>
                <hr class="w-full bg-gray-600 my-2">
                <div class="flex flex-col gap-2">
                    <div class="w-full flex justify-between">
                        <p>
                            Total HT:
                        </p>
                        <p class="font-semibold">
                            {{ $sale->total_price }}
                        </p>
                    </div>
                    <hr class="w-full bg-gray-600 my-2">
                    <div class="w-full flex justify-between">
                        <p>
                            TVA:
                        </p>
                        <p class="font-semibold">
                            20%
                        </p>
                    </div>
                    <hr class="w-full bg-gray-600 my-2">
                    <div class="w-full flex justify-between">
                        <p>
                            Total TTC:
                        </p>
                        <p class="font-semibold">
                            {{ $sale->total_price * 1.2 }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
</x-export-layout>

<x-filament::page>
    <div class="filament-stats grid gap-4 lg:gap-8 md:grid-cols-3">
        <div
            class="filament-stats-card relative p-6 rounded-2xl bg-white shadow dark:bg-gray-800 filament-stats-overview-widget-card">
            <div class="space-y-2">
                <div
                    class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-200">

                    <span>Purchase Total</span>
                </div>

                <div class="text-3xl">
                    {{ $this->products->sum(fn ($product) => $product->latest_unit_price * $product->total_quantity)}}
                </div>

            </div>

        </div>
        <div
            class="filament-stats-card relative p-6 rounded-2xl bg-white shadow dark:bg-gray-800 filament-stats-overview-widget-card">
            <div class="space-y-2">
                <div
                    class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-200">

                    <span>Sale Total</span>
                </div>

                <div class="text-3xl">
                    {{ $this->products->sum(fn ($product) => $product->latest_sale_price * $product->total_quantity) }}
                </div>

            </div>

        </div>
        <div
            class="filament-stats-card relative p-6 rounded-2xl bg-white shadow dark:bg-gray-800 filament-stats-overview-widget-card">
            <div class="space-y-2">
                <div
                    class="flex items-center space-x-2 rtl:space-x-reverse text-sm font-medium text-gray-500 dark:text-gray-200">

                    <span>Profit</span>
                </div>

                <div class="text-3xl">
                    {{ $this->products->sum(fn ($product) => ($product->latest_sale_price - $product->latest_unit_price) * $product->total_quantity) }}
                </div>

            </div>

        </div>

    </div>
    <div>
        {{ $this->table }}
    </div>


</x-filament::page>

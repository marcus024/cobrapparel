@extends('admin.layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md flex lg:flex-col w-full">
    <h1 class="text-2xl font-bold mb-4">Summary</h1>
    {{-- Row 1 --}}
    <div class="flex flex-row">
    <div class="grid grid-cols-2 gap-4 mt-4 w-full">
        {{-- Products --}}
        <div class="bg-gray-200 text-white p-4 rounded-lg shadow-md lg:w-full">
            <h2 class="text-[#700101] text-lg font-bold">Live Products Today</h2>
            <div class="flex lg:flex-col w-auto mt-2 justify-between">
                @php
                    $shops = DB::table('shops')
                        ->select('shops.id', 'shops.name', 
                            DB::raw('(SELECT COUNT(*) FROM products 
                                    WHERE products.shop_id = shops.id 
                                    AND products.productEnd > CURDATE()) as active_products_count')
                        )
                        ->get();
                @endphp
                @foreach($shops as $shop)
                    <div class="flex lg:flex-row w-auto mt-2 justify-between">
                        <p class="text-black font-medium text-xm lg:mr-5">
                            {{ $shop->name }}
                        </p>
                        <p class="text-black font-bold text-xm">
                            {{ $shop->active_products_count }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
       {{-- Status --}}
       <div class="bg-gray-200 text-white p-4 rounded-lg shadow-md lg:w-full">
            <h2 class="text-[#700101] text-lg font-bold">Order Status Today</h2>
            <div class="flex lg:flex-col w-auto mt-2 justify-between">
                @php
                    $statusCounts = DB::table('orders')
                        ->select('status', DB::raw('COUNT(*) as count'))
                        ->whereIn('status', ['Paid', 'In Production', 'Completed'])
                        ->groupBy('status')
                        ->pluck('count', 'status');
                @endphp
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-xm lg:mr-5">
                        Paid
                    </p>
                    <p class="text-black font-bold text-xm">
                        {{ $statusCounts['Paid'] ?? 0 }}
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-xm lg:mr-5">
                        In Production
                    </p>
                    <p class="text-black font-bold text-xm">
                        {{ $statusCounts['In Production'] ?? 0 }}
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-xm lg:mr-5">
                        Completed
                    </p>
                    <p class="text-black font-bold text-xm">
                        {{ $statusCounts['Completed'] ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
    </div>
        {{-- Revenue --}}
        @php
            $startDate = request()->input('start_date', now()->subDays(7)->toDateString());
            $endDate = request()->input('end_date', now()->toDateString());

            $shopRevenues = DB::table('shops')
                ->join('order_items', 'shops.id', '=', 'order_items.shop_id')
                ->select(
                    'shops.id',
                    'shops.name',
                    DB::raw('SUM(order_items.price * order_items.quantity) as revenue')
                )
                ->whereDate('order_items.created_at', '>=', $startDate)
                ->whereDate('order_items.created_at', '<=', $endDate)
                ->groupBy('shops.id', 'shops.name')
                ->orderByDesc('revenue')
                ->get();

            $totalRevenue = $shopRevenues->sum('revenue');
        @endphp
        <div class="bg-gray-200 lg:w-full text-white px-0 pt-0 rounded-lg lg:ml-4 shadow-md">
            <div class="relative w-full h-10 bg-[#700101] flex lg:flex-row justify-between items-center p-3 rounded-t-lg">
                <h2 class="text-white text-xl font-bold">Club Revenue</h2>
                <form method="GET" action="" id="dateForm" class="flex lg:flex-row items-center gap-2">
                    <label class="text-white text-[8px]">From:</label>
                    <input 
                        type="date" 
                        name="start_date" 
                        value="{{ $startDate }}" 
                        class="bg-transparent text-white text-[12px] lg:h-6 lg:w-24 border border-white rounded px-1"
                    >
                    <label class="text-white text-[8px]">To:</label>
                    <input 
                        type="date" 
                        name="end_date" 
                        value="{{ $endDate }}" 
                        class="bg-transparent text-white text-[12px] lg:h-6 lg:w-24 border border-white rounded px-1"
                    >
                    <button type="submit" class="bg-transparent text-white text-[12px] border border-white rounded px-2 lg:h-6">
                        Filter
                    </button>
                </form>
            </div>
            <div class="flex lg:flex-col w-auto mt-1 justify-between py-1 px-6">
                @foreach($shopRevenues as $shop)
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-lg">
                        {{ $shop->name }}
                    </p>
                    <p class="text-black font-bold text-lg">
                        ${{ number_format($shop->revenue) }}
                    </p>
                </div>
                @endforeach
                <div class="flex lg:flex-row w-auto mt-4 justify-between">
                    <p class="text-black font-semibold text-xl">
                        Total
                    </p>
                    <p class="text-black font-bold text-lg">
                        ${{ number_format($totalRevenue) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Row 2 --}}
    <div class="grid grid-rows-2 gap-4 mt-4 lg:w-full">
    @php
        use Illuminate\Support\Facades\DB;
        use Illuminate\Support\Carbon;

        $startDate = request('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = request('end_date', Carbon::now()->endOfMonth()->toDateString());

        $orderItems = DB::table('order_items')
            ->join('shops', 'order_items.shop_id', '=', 'shops.id')
            ->select('order_items.shop_id', 'order_items.product_name', 'order_items.price', 'order_items.quantity', 'order_items.created_at', 'shops.name')
            ->whereBetween('order_items.created_at', [$startDate, $endDate])
            ->get()
            ->groupBy('shop_id');
    @endphp

    @foreach($orderItems as $shopId => $items)
        @php
            $shopName = $items->first()->name;
            $groupedItems = $items->groupBy('product_name')->map(function ($group) {
                return [
                    'quantity' => $group->sum('quantity'),
                    'price' => $group->first()->price,
                ];
            })->toArray(); // Convert to array for sorting
            
            ksort($groupedItems); // Sort by product name (A-Z)

            $totalRevenue = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $groupedItems));
        @endphp

        <div class="bg-gray-200 text-white rounded-lg shadow-md lg:w-full mb-5">
            <div class="relative w-full h-15 bg-gray-300 flex lg:flex-row justify-between items-center p-3 rounded-t-lg">
                <h2 class="text-black text-xm text-center font-bold">{{ $shopName }}</h2>
                <form method="GET" action="" id="shopDateForm" class="flex lg:flex-row items-center gap-2">
                    <label class="text-black text-[8px]">From:</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="bg-transparent text-black text-[12px] lg:h-6 lg:w-24 border border-black rounded px-1">
                    <label class="text-black text-[8px]">To:</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="bg-transparent text-black text-[12px] lg:h-6 lg:w-24 border border-black rounded px-1">
                    <button type="submit" class="bg-transparent text-black text-[12px] border border-black rounded px-2 lg:h-6">Filter</button>
                </form>
            </div>
            <div class="flex lg:flex-col w-auto mt-2 py-2 px-4 justify-between">
                <div class="lg:w-auto lg:h-auto pr-2">
                    @foreach($groupedItems as $productName => $item)
                        <div class="flex lg:flex-row w-auto mt-2 justify-between">
                            <p class="text-black font-semibold text-lg">{{ $item['quantity'] }} x</p>
                            <p class="text-black font-medium text-lg">{{ $productName }}</p>
                            <p class="text-black font-bold text-lg">${{ number_format($item['quantity'] * $item['price'], 2) }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="flex lg:flex-row w-auto mt-6 justify-between">
                    <p class="text-black font-semibold text-xl">Total</p>
                    <p class="text-black font-bold text-lg">${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    @endforeach

</div>
</div>
@endsection

@extends('admin.layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md flex lg:flex-col">
    <h1 class="text-2xl font-bold mb-4">Summary</h1>
    {{-- Row 1 --}}
    <div class="grid grid-cols-3 gap-4 mt-4">
        {{-- Products --}}
        <div class="bg-gray-200 text-white p-4 rounded-lg shadow-md">
            <h2 class="text-[#700101] text-xl font-bold">Live Products Today</h2>
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
                        <p class="text-black font-medium text-lg">
                            {{ $shop->name }}
                        </p>
                        <p class="text-black font-bold text-lg">
                            {{ $shop->active_products_count }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
       {{-- Status --}}
       <div class="bg-gray-200 text-white p-4 rounded-lg shadow-md">
            <h2 class="text-[#700101] text-xl font-bold">Order Status Today</h2>
            <div class="flex lg:flex-col w-auto mt-2 justify-between">
                @php
                    $statusCounts = DB::table('orders')
                        ->select('status', DB::raw('COUNT(*) as count'))
                        ->whereIn('status', ['Pending', 'In Production', 'Completed'])
                        ->groupBy('status')
                        ->pluck('count', 'status');
                @endphp
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-lg">
                        Pending
                    </p>
                    <p class="text-black font-bold text-lg">
                        {{ $statusCounts['Pending'] ?? 0 }}
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-lg">
                        In Production
                    </p>
                    <p class="text-black font-bold text-lg">
                        {{ $statusCounts['In Production'] ?? 0 }}
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-lg">
                        Completed
                    </p>
                    <p class="text-black font-bold text-lg">
                        {{ $statusCounts['Completed'] ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
        {{-- Revenue --}}
        <div class="bg-gray-200 text-white px-0 pt-0 rounded-lg shadow-md">
            <div class="relative w-full h-10 bg-[#700101] flex lg:flex-row justify-between items-center p-3 rounded-t-lg">
                <h2 class="text-white text-xl font-bold">Club Revenue</h2>
                <input type="date" class="bg-transparent text-white text-[12px] lg:h-6 lg:w-24">
            </div>
            <div class="flex lg:flex-col w-auto mt-2 justify-between py-2 px-6">
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-lg">
                        Barellan
                    </p>
                    <p class="text-black font-bold text-lg">
                        30,000
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-lg">
                        Hockey Ducks
                    </p>
                    <p class="text-black font-bold text-lg">
                        27,999
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-medium text-lg">
                        Humpty Dumpty
                    </p>
                    <p class="text-black font-bold text-lg">
                        20,100
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-6 justify-between">
                    <p class="text-black font-semibold text-xl">
                        Total
                    </p>
                    <p class="text-black font-bold text-lg">
                        20,100
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- Row 2 --}}
    <div class="grid grid-cols-3 gap-4 mt-4">
        {{-- Revenue --}}
        <div class="bg-gray-200 text-white  rounded-lg shadow-md">
            <div class="relative w-full h-10 bg-gray-300 flex lg:flex-row justify-between items-center p-3 rounded-t-lg">
                <h2 class="text-black text-xl font-bold">Barellan</h2>
                <input type="date" class="bg-transparent text-black text-[12px] lg:h-6 lg:w-24">
            </div>
            <div class="flex lg:flex-col w-auto mt-2 py-2 px-4 justify-between">
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-semibold text-lg">
                        30
                    </p>
                    <p class="text-black font-medium text-lg">
                        Singlet
                    </p>
                    <p class="text-black font-bold text-lg">
                        300
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-semibold text-lg">
                        27
                    </p>
                    <p class="text-black font-medium text-lg">
                        Cap
                    </p>
                    <p class="text-black font-bold text-lg">
                        270
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-semibold text-lg">
                        2
                    </p>
                    <p class="text-black font-medium text-lg">
                        Netball Dress
                    </p>
                    <p class="text-black font-bold text-lg">
                        200
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-6 justify-between">
                    <p class="text-black font-semibold text-xl">
                        Total
                    </p>
                    <p class="text-black font-bold text-lg">
                        20,100
                    </p>
                </div>
            </div>
        </div>
        {{-- Revenue --}}
        <div class="bg-gray-200 text-white  rounded-lg shadow-md">
            <div class="relative w-full h-10 bg-gray-300 flex lg:flex-row justify-between items-center p-3 rounded-t-lg">
                <h2 class="text-black text-xl font-bold">Barellan</h2>
                <input type="date" class="bg-transparent text-black text-[12px] lg:h-6 lg:w-24">
            </div>
            <div class="flex lg:flex-col w-auto mt-2 py-2 px-4 justify-between">
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-semibold text-lg">
                        30
                    </p>
                    <p class="text-black font-medium text-lg">
                        Singlet
                    </p>
                    <p class="text-black font-bold text-lg">
                        300
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-semibold text-lg">
                        27
                    </p>
                    <p class="text-black font-medium text-lg">
                        Cap
                    </p>
                    <p class="text-black font-bold text-lg">
                        270
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-2 justify-between">
                    <p class="text-black font-semibold text-lg">
                        2
                    </p>
                    <p class="text-black font-medium text-lg">
                        Netball Dress
                    </p>
                    <p class="text-black font-bold text-lg">
                        200
                    </p>
                </div>
                <div class="flex lg:flex-row w-auto mt-6 justify-between">
                    <p class="text-black font-semibold text-xl">
                        Total
                    </p>
                    <p class="text-black font-bold text-lg">
                        20,100
                    </p>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cobrapparel</title>
    <link rel="icon" href="cobra.png" type="image/x-icon">
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-white flex flex-col items-center min-h-screen">
    <!-- Top Widget -->
    <div class="relative w-full h-100 flex flex-col items-center justify-center text-white bg-black bg-opacity-80 animate-fadeInUp before:content-[''] before:absolute before:inset-0 before:bg-[url('/images/bgnavy.jpg')] before:bg-cover before:bg-center ">
        <div class="flex lg:flex-row flex-col  mb-2 px-5 items-center gap-4 relative z-10">
            <img src="/storage/{{ $shop->image }}" alt="{{ $shop->name }}" class="w-[100px] h-[100px] lg:h-[200px] lg:w-[200px] mt-5 object-cover  ">
            <h1 class="text-[30px] text-center lg:text-[90px] font-bold uppercase text-white">{{ $shop->name }}</h1>
        </div> 
        <div class="w-11/12 max-w-4xl   p-3 lg:p-6 z-10 rounded-lg  text-center ">
        <p class=" text-sm lg:text-lg font-semibold text-white">All items in this store are available for pre-order. Once your order is ready, your club contact will notify you with collection details.</p>
        <div class="mt-4">
            <p class="font-bold text-white">Contact</p>
            <p class="lg:text-sm text-white">
                {{ $shop->contact_name }} | {{ $shop->contact_number }} | 
                <a href="mailto:{{ $shop->emailAddress }}" class="text-white underline">
                    {{ $shop->emailAddress }}
                </a>
            </p>
        </div>
        <div class="mt-4">
            @php
                // Assuming 'duration' is stored as a string representing months
                $closingDate = \Carbon\Carbon::parse($shop->created_at)->addMonths((int) $shop->duration)->format('F d, Y');
            @endphp

            {{-- <p class="text-sm text-gray-600">
                🛑 Note: This shop will close on <strong>{{ $closingDate }}</strong>. 
                After this date, checkout will no longer be available.
            </p> --}}
        </div>
    </div>
    </div>
    <!-- Middle Widget -->
   
    <!-- Bottom Widget (Product Listing) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 px-10 gap-6 my-15 mx-5 lg:w-full animate-fadeInUp">
        @foreach($products as $product)
            @php
                $images = json_decode($product->images, true); // Decode images JSON
                $coverImage = $images[0] ?? 'default.jpg'; // Use first image or fallback
            @endphp
            <a href="{{ url('addtc', ['id' => $product->id]) }}" class="flex flex-col items-center text-center cursor-pointer">
                <img src="/{{ $coverImage }}" class="h-[150px] sm:h-[200px] md:h-[250px] lg:h-[300px] w-auto object-contain transition-transform transform hover:scale-110" alt="{{ $product->name }}">
                <p class="text-[14px] sm:text-[16px] md:text-[18px] lg:text-[20px] font-bold text-[#00308F] mt-2">{{ $product->name }}</p>
            </a>
        @endforeach
    </div>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.4s ease-out forwards;
        }
    </style>
</body>
</html>

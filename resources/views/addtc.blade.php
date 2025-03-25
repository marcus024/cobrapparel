<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cobrapparel</title>
    <link rel="icon" href="cobra.png" type="image/x-icon">
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
       @keyframes slide {
            0%, 25% { transform: translateX(0%); } /* Stay longer before moving */
            30%, 55% { transform: translateX(-100%); } /* Move to next slide and stay */
            60%, 85% { transform: translateX(-200%); } /* Move to next slide and stay */
            90%, 100% { transform: translateX(0%); } /* Loop back to first */
        }

        .animate-slide {
            display: flex;
            width: 300%; /* Adjust based on the number of images */
            animation: slide 20s infinite ease-in-out; /* Slow transition */
        }

    </style>
    <style>
        /* Keyframe for fade in/out effect */
        @keyframes fadeInOut {
            0% { opacity: 0; visibility: hidden; }
            10% { opacity: 1; visibility: visible; }
            90% { opacity: 1; visibility: visible; }
            100% { opacity: 0; visibility: hidden; }
        }

        /* Apply animation */
        .animate-notif {
            animation: fadeInOut 0.1s ease-in-out;
        }
    </style>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.1s ease-out forwards;
        }
    </style>
</head>
<body>
    <div class="flex flex-col lg:flex-row w-full h-auto">
        <div class="w-full flex justify-center items-center h-[60vh] lg:h-[100vh] overflow-hidden relative">
            <div class="flex w-full max-w-3xl h-full">
                <div class="relative w-full flex justify-center items-center">
                    <div class="relative w-full max-w-2xl overflow-hidden">
                        <div id="slider-{{ $product->id }}" class="flex w-full h-full transition-transform duration-5000 ease-in-out animate-slide">
                            @foreach(json_decode($product->images, true) ?? [] as $image)
                                <img src="{{ asset('/' . $image) }}" 
                                    class="w-full h-full object-cover">
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <button onclick="prevSlide('{{ $product->id }}')" 
                        class="absolute left-2 bg-gray-700 text-white px-3 py-1 rounded-full">
                        ❮
                    </button>
                    <button onclick="nextSlide('{{ $product->id }}')" 
                        class="absolute right-2 bg-gray-700 text-white px-3 py-1 rounded-full">
                        ❯
                    </button>
                </div>
            </div>
        </div>
        <div  class="lg:w-[50%] w-full lg:h-[100vh] h-[70vh]   bg-cover bg-center bg-no-repeat">
            <div class="flex my-4 justify-center items-center">
            <img   src="/storage/{{ $product->shop->image }}"
                class="h-[50px] lg:h-[100px] w-[50px] lg:w-[100px] rounded-full m-5" alt="Shop Logo">

            <p class="text-center justify-center items-center font-bold text-xl lg:text-4xl text-[#002D62]">
                {{ strtoupper($product->shop->name) }}
            </p>
            </div>
            <div class=" w-full h-8  justify-end flex">
                <div class="justify-end items-center m-5">
                    <a href="{{ route('cart') }}" class="block">
                        <img src="/images/cart.png"
                            class="w-5 h-5 transition-transform transform hover:scale-110 hover:rotate-12 hover:drop-shadow-lg"
                            alt="Cart">
                    </a>
                </div>
            </div>
            <div class="flex flex-col my-4 justify-start ">
                <p class="text-[#002D62] text-sm lg:text-xl font-medium ml-5">{{ strtoupper($product->name) }}</p>
                <p class="text-[#002D62] text-xs ml-5 lg:text-lg">*This is a pre-order</p>
                <p class="italic text-[#002D62] text-xs ml-5 lg:text-xm">
                    Available until: {{ $product->productEnd ?? 'N/A' }}
                </p>
            </div>
            <div class="flex flex-col my-2 justify-start">
                <p class="text-[#002D62] text-xs lg:text-lg font-bold ml-5">$ {{ number_format($product->price, 2) }} + GST</p>
            </div>
           @if (!empty($product->size_chart) && !in_array($product->size_chart, ['socks', 'men_short']))
                <button onclick="toggleSizeChart('{{ $product->size_chart }}')" 
                    class="ml-5 bg-btn align-self-start bg-[#002d62] text-white font-bold py-1 px-2 text-xs lg:text-lg w-25 lg:w-35">
                    SIZE CHART
                </button>

                <!-- Size Chart Modal -->
                <div id="sizeChartModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center hidden">
                    <div class="relative bg-white p-4 rounded-lg shadow-lg w-3/4 md:w-1/2 lg:w-1/3 max-h-[90vh] overflow-auto">
                        <button onclick="toggleSizeChart()" 
                                class="absolute top-2 right-2 text-gray-700 font-bold text-xl">
                            &times;
                        </button>
                        <h2 class="text-lg font-bold mb-2 text-black">Size Chart</h2>
                        <img id="sizeChartImage"  alt="Not Available" class="w-full max-h-full object-contain">
                    </div>
                </div>
            @endif
            {{-- Size Chart --}}
            <div class="flex flex-col  px-4 my-4">
                @if (!empty($product->size_chart))
                    <div class="mb-3">
                        <select id="size" name="size" class="mt-1 lg:w-35 p-2 w-26 lg:h-12 h-10 border border-[#002d62] border-2 text-[#002D62] uppercase">
                            @if ($product->size_chart === 'dipsas_hoodie')
                                <optgroup label="KIDS (HOODIE)" class="text-[#002D62]">
                                    <option value="KIDS 4">KIDS 4</option>
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                                <optgroup label="ADULTS (HOODIE)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'dipsas_netball_dress')
                                <optgroup label="ADULTS (NETBALL DRESS)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                                <optgroup label="KIDS (NETBALL DRESS)" class="text-[#002D62]">
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'dipsas_quarter_zip')
                                <optgroup label="KIDS (QUARTER ZIP)" class="text-[#002D62]">
                                    <option value="KIDS 4">KIDS 4</option>
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                                <optgroup label="ADULTS (QUARTER ZIP)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'dipsas_standard_polo')
                                <optgroup label="KIDS (STANDARD POLO)" class="text-[#002D62]">
                                    <option value="KIDS 4">KIDS 4</option>
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                                <optgroup label="ADULTS (STANDARD POLO)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'dipsas_trade_polo')
                                <optgroup label="ADULTS (TRADE POLO)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'beanies')
                                <optgroup label="BEANIES" class="text-[#002D62]">
                                    <option value="TODDLER">TODDLER (2-6)</option>
                                    <option value="YOUTH">YOUTH</option>
                                    <option value="ADULT">ADULT</option>
                                    <option value="XL">XL</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'truckers')
                                <optgroup label="TRUCKERS" class="text-[#002D62]">
                                    <option value="LARGE">LARGE</option>
                                    <option value="KIDS">KIDS</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'socks')
                                <optgroup label="SOCKS" class="text-[#002D62]">
                                    <option value="5-8">5-8</option>
                                    <option value="8-11">8-11</option>
                                </optgroup>
                             @elseif ($product->size_chart === 'dipsas_warmup_tee')
                                <optgroup label="KIDS (STANDARD LENGTH)" class="text-[#002D62]">
                                    <option value="KIDS 4">KIDS 4</option>
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                                <optgroup label="ADULTS (STANDARD LENGTH)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                             @elseif ($product->size_chart === 'transition_hoodie')
                                <optgroup label="TRANSITION HOODIE KIDS" class="text-[#002D62]">
                                    <option value="KIDS 4">KIDS 4</option>
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                                <optgroup label="TRANSITION HOODIE ADULTS" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                           @elseif ($product->size_chart === 'transition_netball_dress')
                                <optgroup label="TRANSITION NETBALL DRESS KIDS" class="text-[#002D62]">
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                                <optgroup label="TRANSITION NETBALL DRESS ADULTS" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'transition_singlet')
                                <optgroup label="TRANSITION SINGLET KIDS" class="text-[#002D62]">
                                    <option value="KIDS 4">KIDS 4</option>
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                                <optgroup label="TRANSITION SINGLET ADULTS" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'transition_standard_polo')
                                <optgroup label="TRANSITION HOODIE KIDS" class="text-[#002D62]">
                                    <option value="KIDS 4">KIDS 4</option>
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                                <optgroup label="TRANSITION HOODIE ADULTS" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                             @elseif ($product->size_chart === 'men_short')
                                <optgroup label="MEN SHORTS" class="text-[#002D62]">
                                    <option value="4">4</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    <option value="28-XS">(28)XS</option>
                                    <option value="30-S">(30)S</option>
                                    <option value="32-M">(32)M</option>
                                    <option value="34-L">(34)L</option>
                                    <option value="36-XL">(36)XL</option>
                                    <option value="38-2XL">(38)2XL</option>
                                    <option value="40-3XL">(40)3XL</option>
                                    <option value="42-4XL">(42)4XL</option>
                                    <option value="44-5XL">(44)5XL</option>
                                </optgroup>
                             @elseif ($product->size_chart === 'dipsas_women_short')
                                <optgroup label="WOMEN SHORTS" class="text-[#002D62]">
                                    <option value="4">4</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    <option value="28-XS">(28)XS</option>
                                    <option value="30-S">(30)S</option>
                                    <option value="32-M">(32)M</option>
                                    <option value="34-L">(34)L</option>
                                    <option value="36-XL">(36)XL</option>
                                    <option value="38-2XL">(38)2XL</option>
                                    <option value="40-3XL">(40)3XL</option>
                                    <option value="42-4XL">(42)4XL</option>
                                    <option value="44-5XL">(44)5XL</option>
                                </optgroup>
                            @elseif  ($product->size_chart === 'transition_trade_polo')
                                <optgroup label="ADULTS (TRADE POLO)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @elseif  ($product->size_chart === 'dipsas_spray_jacket')
                                <optgroup label="ADULTS (SPRAY JACKET)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @elseif  ($product->size_chart === 'dipsas_women_polo')
                                <optgroup label="ADULTS (WOMEN'S POLO)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @elseif ($product->size_chart === 'transition_warmup_tee')
                                <optgroup label="KIDS (STANDARD LENGTH)" class="text-[#002D62]">
                                    <option value="KIDS 4">KIDS 4</option>
                                    <option value="KIDS 6">KIDS 6</option>
                                    <option value="KIDS 8">KIDS 8</option>
                                    <option value="KIDS 10">KIDS 10</option>
                                    <option value="KIDS 12">KIDS 12</option>
                                    <option value="KIDS 14">KIDS 14</option>
                                    <option value="KIDS 16">KIDS 16</option>
                                </optgroup>
                                <optgroup label="ADULTS (STANDARD LENGTH)" class="text-[#002D62]">
                                    <option value="ADULTS XS">ADULTS XS</option>
                                    <option value="ADULTS S">ADULTS S</option>
                                    <option value="ADULTS M">ADULTS M</option>
                                    <option value="ADULTS L">ADULTS L</option>
                                    <option value="ADULTS XL">ADULTS XL</option>
                                    <option value="ADULTS 2XL">ADULTS 2XL</option>
                                    <option value="ADULTS 3XL">ADULTS 3XL</option>
                                    <option value="ADULTS 4XL">ADULTS 4XL</option>
                                    <option value="ADULTS 5XL">ADULTS 5XL</option>
                                    <option value="ADULTS 6XL">ADULTS 6XL</option>
                                    <option value="ADULTS 7XL">ADULTS 7XL</option>
                                </optgroup>
                            @endif
                        </select>
                    </div>
                @endif

                @if(!empty($product->custom_name))
                    <input type="text" placeholder="CUSTOM NAME" id="custom_name"
                        class="text-xs lg:text-xl text-[#002D62] my-1 w-50 lg:w-70 border border-2 border-[#002d62] 
                        h-8 lg:h-10 p-2 font-bold focus:border-[#002d62] outline-none"
                        >
                @endif

                @if(!empty($product->custom_number))
                    <input type="text" placeholder="CUSTOM NUMBER" id="custom_number"
                        class="text-xs lg:text-xl text-[#002D62] my-1 w-50 lg:w-70 border border-2 border-[#002d62] 
                        h-8 lg:h-10 p-2 font-bold focus:border-[#002d62] outline-none"
                     >
                @endif
                <!-- Order Count -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center w-20 lg:w-30 border border-[#002d62] bg-white border-2 ">
                        <button onclick="decreaseCount()" class="px-2  text-[#002D62] text-xs lg:text-lg">-</button>
                        <span id="orderCount" class="px-2 text-lg text-[#002D62] font-bold text-xs lg:text-lg">1</span>
                        <button onclick="increaseCount()" class="px-2  text-[#002D62] text-xs lg:text-lg ">+</button>
                    </div>
                </div>
            </div>
            <div class="relative">
                <!-- Notification Bar (Initially Hidden) -->
                {{-- <div id="notifBar"
                    class="fixed top-5 left-1/2 ml-3 transform -translate-x-1/2 bg-green-500 text-white text-xs lg:text-lg py-2 px-4 rounded-lg shadow-lg opacity-0 invisible transition-all duration-500">
                    ✅ Added to Cart Successfully!
                </div> --}}
                
                <div class="flex flex-col mt-1">
                    <button onclick="addToCart()"
                        class="ml-5 bg-btn align-self-start bg-[#002d62] text-white font-bold py-1 px-2 text-xs lg:text-lg w-50 lg:w-70">
                        ADD TO CART
                    </button>
                    <p id="productAlert" class="ml-5 text-red-600 text-xs lg:text-lg mt-2 hidden">
                        This product is no longer available.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="notifBar" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80 items-center flex justify-center lg:flex-col text-center">
            <!-- Spinning Check Mark -->
            <div id="loadingIcon" class="flex justify-center">
                <svg class="animate-spin h-12 w-12 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M10 14l2 2 4-4"></path>
                </svg>
            </div>

            <!-- Check Mark Icon (Initially Hidden) -->
            <div id="checkMarkIcon" class="hidden">
                <img src="/images/icons/online-shop.gif" alt="" class="w-12 h-12">
            </div>

            <!-- "Added to Cart" Text (Initially Hidden) -->
            <p id="addedText" class="text-lg font-semibold text-green-600 mt-4 hidden">Added to Cart</p>
        </div>
    </div>


    @php
        $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
        $imagePath = is_array($images) && !empty($images) ? $images[0] : $images;
    @endphp


<script>
    function showNotification() {
        const notifBar = document.getElementById("notifBar");
        const loadingIcon = document.getElementById("loadingIcon");
        const checkMarkIcon = document.getElementById("checkMarkIcon");
        const addedText = document.getElementById("addedText");

        // Show the notification bar
        notifBar.classList.remove("hidden");

        // After 2 seconds, hide the spinner & show check mark and text
        setTimeout(() => {
            loadingIcon.classList.add("hidden");
            checkMarkIcon.classList.remove("hidden");
            addedText.classList.remove("hidden");
        }, 2000);

        // Hide the notification after 3 more seconds
        setTimeout(() => {
            notifBar.classList.add("hidden");
            loadingIcon.classList.remove("hidden"); // Reset animation
            checkMarkIcon.classList.add("hidden"); // Hide check mark for next use
            addedText.classList.add("hidden");
        }, 5000);
    }

    // Example usage: Call `showNotification()` when needed
</script>

    <script>
        function showNotif() {
            let notif = document.getElementById("notifBar");
            notif.classList.add("animate-notif");
            
            // Remove animation after 4s to allow re-trigger
            setTimeout(() => {
                notif.classList.remove("animate-notif");
            }, 4000);
        }
    </script>
    <script>
    

    document.getElementById("cancelCheckout").addEventListener("click", function() {
        document.getElementById("checkoutPopup").classList.add("hidden");
    });

</script>
    <script>
        function addToCart() {
            let count = parseInt(document.getElementById("orderCount").innerText) || 1;
            let sizeSelect = document.getElementById("size");
            let productEnd = "{{ $product->productEnd }}"; 
            let currentDate = new Date().toISOString().split("T")[0];

            let alertMessage = document.getElementById("productAlert");

            if (productEnd === currentDate) {
                alertMessage.classList.remove("hidden"); 
                return; 
            } else {
                alertMessage.classList.add("hidden"); 
            }

            let product = {
                id: "{{ $product->id }}", 
                name: "{{ $product->name }}",
                price: "{{ $product->price }}",
                image: "{{ $imagePath }}",
                quantity: count,
                size: sizeSelect ? sizeSelect.value : null,
                color: null,
                custom_name: null,
                custom_number: null,
            };

            if (sizeSelect) {
                sizeSelect.addEventListener("change", function () {
                    product.size = this.value;
                    console.log("Selected Size:", product.size);
                });
            }

            // Check if product name contains "polo" and get the selected size
            if (product.name.toLowerCase().includes("polo")) {
                let sizeElement = document.getElementById("size");
                product.size = sizeElement ? sizeElement.value : null;
            }

            // Get custom name and number using their IDs
            let customNameInput = document.getElementById("custom_name");
            let customNumberInput = document.getElementById("custom_number");
            product.custom_name = customNameInput ? customNameInput.value.trim() : null;
            product.custom_number = customNumberInput ? customNumberInput.value.trim() : null;

            // Retrieve cart from localStorage
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            let existingProductIndex = cart.findIndex(
                item => item.id === product.id && 
                        item.size === product.size && 
                        item.color === product.color &&
                        item.customName === product.customName &&
                        item.customNumber === product.customNumber
            );

            if (existingProductIndex !== -1) {
                cart[existingProductIndex].quantity += product.quantity;
            } else {
                cart.push(product);
            }

            // Save updated cart to localStorage
            localStorage.setItem("cart", JSON.stringify(cart));

            console.log("Added to cart:", product);
            console.log("Updated cart:", cart);

            // Send data to the server
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(product)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => console.log('Server response:', data))
            .catch(error => console.error('Error:', error));


           showNotification();
          
        }

        // Quantity Management
        function decreaseCount() {
            let countElement = document.getElementById("orderCount");
            let count = parseInt(countElement.innerText);
            if (count > 1) {
                countElement.innerText = count - 1;
            }
        }

        function increaseCount() {
            let countElement = document.getElementById("orderCount");
            let count = parseInt(countElement.innerText);
            countElement.innerText = count + 1;
        }
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let sliders = document.querySelectorAll("[id^='slider-']");

        sliders.forEach(slider => {
            let productId = slider.id.replace('slider-', '');
            window["currentSlide_" + productId] = 0;
            let totalSlides = slider.children.length;

            // Auto-slide every 3 seconds
            setInterval(() => {
                nextSlide(productId);
            }, 3000);
        });
    });

    function nextSlide(productId) {
        let slider = document.getElementById("slider-" + productId);
        let slides = slider.children;
        let totalSlides = slides.length;

        window["currentSlide_" + productId] = (window["currentSlide_" + productId] + 1) % totalSlides;
        slider.style.transform = `translateX(-${window["currentSlide_" + productId] * 100}%)`;
    }

    function prevSlide(productId) {
        let slider = document.getElementById("slider-" + productId);
        let slides = slider.children;
        let totalSlides = slides.length;

        window["currentSlide_" + productId] = (window["currentSlide_" + productId] - 1 + totalSlides) % totalSlides;
        slider.style.transform = `translateX(-${window["currentSlide_" + productId] * 100}%)`;
    }
</script>
<script>
    function toggleSizeChart(sizeChart = null) {
        let modal = document.getElementById('sizeChartModal');
        let sizeChartImage = document.getElementById('sizeChartImage');

        if (sizeChart) {
            let sizeChartPath = `/images/size_charts/${sizeChart}.jpg`;
            sizeChartImage.src = sizeChartPath;
        }

        modal.classList.toggle('hidden');
    }
</script>
</body>
</html>
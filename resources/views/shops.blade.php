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
</head>
<body class="bg-white flex justify-center items-center flex-col min-h-screen">
    <a href="{{ route('login') }}" class="text-xl lg:text-4xl font-bold text-[#700101] mb-8 block text-center hover:underline">
        Cobrapparel Club Shops
    </a>
    <div class=" w-full h-16  justify-end flex">
        <div class="justify-end items-center m-5">
            <a href="{{ route('cart') }}" class="block">
                <img src="/images/cart.png"
                    class="w-5 h-5 transition-transform transform hover:scale-110 hover:rotate-12 hover:drop-shadow-lg"
                    alt="Cart">
            </a>
        </div>
    </div>
    <div class=" p-8 rounded-xl w-11/12 max-w-4xl text-center overflow-hidden">
        <div class="flex flex-row justify-center gap-8 opacity-0 translate-y-10 animate-fadeInUp">
            <div class="rounded-xl p-6 flex flex-col items-center gap-4 cursor-pointer transition-transform transform hover:-translate-y-2" 
                onclick="location.href='{{ url('product') }}'">
                <img src="/images/ducks.png" alt="The Hockey Ducks" class="w-20 lg:w-40 lg:h-40 h-20 rounded-lg object-cover">
                <span class="text-sm lg:text-xl font-bold text-[#700101]">The Hockey Ducks</span>
            </div>
        </div>
    </div>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
   <script>
   document.addEventListener("DOMContentLoaded", fetchShops);

function fetchShops() {
    fetch("/shops")
        .then(response => response.json())
        .then(shops => {
            let shopContainer = document.querySelector(".flex.flex-row.justify-center.gap-8");
            shopContainer.innerHTML = ""; // Clear existing shops

            shops.forEach(shop => {
                let shopDiv = document.createElement("div");
                shopDiv.className =
                    "rounded-xl p-6 flex flex-col items-center gap-4 cursor-pointer transition-transform transform hover:-translate-y-2";
                
                // Redirect to products page with shop ID
                shopDiv.onclick = () => (window.location.href = `/products/${shop.id}`);

                shopDiv.innerHTML = `
                    <img src="/storage/${shop.image}" alt="${shop.name}" class="w-20 lg:w-40 lg:h-40 h-20 rounded-lg object-cover">
                    <span class="text-sm lg:text-xl font-bold text-[#700101]">${shop.name}</span>
                `;

                shopContainer.appendChild(shopDiv);
            });
        })
        .catch(error => console.error("Error fetching shop data:", error));
}

</script>


</body>
</html>

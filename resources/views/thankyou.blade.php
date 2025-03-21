<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Cobrapparel</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col justify-center items-center h-screen space-y-4">
        <p class="text-lg font-bold">Thank you for your order! We will process it shortly.</p>
        
        <!-- Return to Shop Button -->
        <a href="{{ url('/') }}" class="bg-[#700101] text-white px-4 py-2 rounded-md hover:bg-red-700">
            Return to Shop
        </a>
    </div>
</body>
</html>

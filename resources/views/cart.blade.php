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
</head>
<body>
    <div class="flex lg:flex-col  flex-col w-full ">
        <div class="items-center h-[15vh] justify-center py-10 w-full">
            <p class=" font-extrabold text-center text-2xl main-color">CART</p>
        </div>
        <div class="items-center h-[85vh]   justify-center pt-3 w-full bg-[url('/images/bgblur.png')] bg-cover bg-center bg-no-repeat">
            <div class="flex flex-col mx-1 py-1 my-1 px-1">
                <div class="flex " id="title">
                    <p class="text-xs lg:text-xl main-color mr-[110px] lg:mr-[550px]  lg:pl-10">ITEM</p>
                    <p class="text-xs lg:text-xl main-color  mr-[30px] lg:mr-[300px]">QUANTITY</p>
                    <p class="text-xs lg:text-xl main-color">TOTAL</p>
                </div>
                <div class="flex flex-col my-3 h-[60vh] max-h-[80vh] lg:max-h-[50vh] overflow-y-scroll" id="content">
                    <!-- Cart items will be dynamically inserted here -->
                </div>
                <div class="h-[10vh] lg:h-[20vh] lg:pr-20 w-full flex flex-col justify-end items-end pr-5 ">
                    <div class="flex flex-col items-end">
                        <p id="totalPay" class="text-[12px] lg:text-[20px] font-bold main-color text-right">TOTAL <span>$ 40.00 + GST</span></p>
                        <p class="text-[10px] lg:text-[12px] main-color text-right">Taxes are calculated at checkout</p>
                    </div>
                    <div class="flex flex-col mt-5">
                        <a href="javascript:void(0);" onclick="saveCartItems()"
                        class="bg-btn text-white font-bold py-1 px-2 text-xs lg:text-lg w-40 lg:w-[200px] transition-transform transform hover:scale-105 text-center">
                        CHECKOUT
                        </a>
                    </div>
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
                <img id="imgScr" src="/images/icons/trash-bin.gif" alt="" class="w-12 h-12">
            </div>

            <!-- "Added to Cart" Text (Initially Hidden) -->
            <p id="addedText" class="text-lg font-semibold text-[#700101] mt-4 hidden">Removed from Cart</p>
        </div>
    </div>

   <script>
    function showNotification(text, color) {
        const notifBar = document.getElementById("notifBar");
        const loadingIcon = document.getElementById("loadingIcon");
        const checkMarkIcon = document.getElementById("checkMarkIcon");
        const notifText = document.getElementById("addedText");

        // Apply dynamic text and color
        notifText.textContent = text;
        notifText.classList.remove("text-green-600", "text-red-600"); // Reset colors
        checkMarkIcon.classList.remove("text-green-500", "text-red-500");

          if (color === "green") {
            notifText.classList.add("text-green-600");
            imgScr.src = "/images/icons/checkout.gif"; // Set to cart icon
        } else if (color === "red") {
            notifText.classList.add("text-red-600");
            imgScr.src = "/images/icons/trash-bin.gif"; // Set to delete icon
        }

        // Show notification
        notifBar.classList.remove("hidden");

        // Hide spinner & show check mark and message
        setTimeout(() => {
            loadingIcon.classList.add("hidden");
            checkMarkIcon.classList.remove("hidden");
            notifText.classList.remove("hidden");
        }, 2000);

        // Hide notification after 5 seconds
        setTimeout(() => {
            notifBar.classList.add("hidden");
            loadingIcon.classList.remove("hidden"); // Reset animation
            checkMarkIcon.classList.add("hidden");
            notifText.classList.add("hidden");
        }, 5000);
    }

    // Example usage:
    // showNotification("Saved to Cart", "green");
    // showNotification("Deleted from Cart", "red");
</script>

    <script>
         let count = 1;

    function increaseCount() {
        count++;
        document.getElementById('orderCount').innerText = count;
    }

    function decreaseCount() {
        if (count > 1) {
            count--;
            document.getElementById('orderCount').innerText = count;
        }
    }
    </script>

    <script>
 function loadCartItems() {
    fetch('/cart/items')
        .then(response => response.json())
        .then(cartItems => {
            let cartHTML = "";
            let totalPay = 0; // Initialize total amount

            cartItems.forEach(item => {
                let imagePath = "/default-image.jpg"; // Default fallback

try {
    if (item.image) {
        let imageData = item.image.replace(/&quot;/g, '"'); // Decode encoded quotes

        // Check if the image is stored as an array (JSON format)
        if (imageData.startsWith("[") && imageData.endsWith("]")) {
            let imageArray = JSON.parse(imageData);
            if (Array.isArray(imageArray) && imageArray.length > 0) {
                imagePath = `/${imageArray[0]}`; // Use the first image
            }
        } else {
            // If it's just a string, use it directly
            imagePath = `/${item.image}`;
        }
    }
} catch (error) {
    console.error("Error parsing image path:", error);
}

                let itemTotal = parseFloat(item.price) * item.quantity; // Calculate total price per item
                totalPay += itemTotal; // Add item price to total amount

                cartHTML += `
                    <div class="flex p-1" id="product-${item.id}">
                        <div id="item" class="flex w-[140px] lg:w-[600px]">
                            <div id="productImage" class="h-[30px] lg:w-[150px] lg:h-[150px] w-[30px] mr-2">
                                <img src="${item.image}" alt="Product Image" onerror="this.src='/default-image.jpg'">
                            </div>
                            <div class="flex flex-col lg:h-30 lg:pl-20 justify-center">
                                <p id="productName" class="text-[8px] lg:text-[20px] main-color">${item.name}</p>
                                <p id="productSize" class="text-[7px] lg:text-[15px] main-color">${item.size ?? "N/A"}</p>
                                <p id="productPrice" class="text-[8px] lg:text-[15px] font-bold main-color">$${parseFloat(item.price).toFixed(2)} + GST</p>
                            </div>
                        </div>
                        <div id="item" class="flex flex-col items-center justify-center mx-2 w-[70px] lg:h-30 lg:w-[150px]">
                            <div class="flex items-center justify-between w-12 h-6 lg:w-20 lg:h-10 px-1 border border-[#700101] lg:border-2 border-1">
                                <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="px-1 main-color text-xs lg:text-lg">-</button>
                                <span id="orderCount-${item.id}" class="px-1 text-sm main-color text-xs lg:text-[15px]">${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="px-1 main-color text-xs lg:text-[15px]">+</button>
                            </div>
                            <p onclick="removeFromCart(${item.id})" class="main-color cursor-pointer font-mono mt-1 underline text-[9px] lg:text-[15px]">Remove</p>
                        </div>
                        <div id="item" class="flex justify-center lg:items-center lg:h-30 w-[60px] lg:w-[450px] lg:pl-36">
                            <p id="price" class="main-color text-[8px] lg:text-[20px] font-bold">$${itemTotal.toFixed(2)} + GST</p>
                        </div>
                    </div>
                `;
            });

            // Update the total payment
            document.getElementById("content").innerHTML = cartHTML;
            document.getElementById("totalPay").innerHTML = `TOTAL <span>$${totalPay.toFixed(2)} + GST</span>`;
        })
        .catch(error => console.error('Error fetching cart items:', error));
}

// Function to remove an item from the cart
function removeFromCart(itemId) {
    fetch(`/cart/remove/${itemId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Add CSRF token
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);
        showNotification("Removed from cart","red");
        loadCartItems(); // Refresh the cart display
    })
    .catch(error => console.error('Error removing item:', error));
}

// Function to update item quantity in the cart
function updateQuantity(itemId, newQuantity) {
    if (newQuantity < 1) return; // Prevent zero or negative quantity

    fetch(`/cart/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Add CSRF token
        },
        body: JSON.stringify({ id: itemId, quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);
        
        loadCartItems(); // Refresh the cart display
    })
    .catch(error => console.error('Error updating quantity:', error));
}

// Load cart items when the page loads
document.addEventListener("DOMContentLoaded", loadCartItems);

</script>
<script>
function saveCartItems() {


    fetch('/cart/items')
        .then(response => response.json())
        .then(cartItems => {
            
            if (cartItems.length > 0) {
                localStorage.setItem('checkoutCart', JSON.stringify(cartItems)); // Store cart items
showNotification("Redirecting to checkout","green");
                // Redirect to checkout page
                window.location.href = "{{ route('checkout') }}";
            } else {
                alert('Your cart is empty. Please add items before proceeding to checkout.');
            }
        })
        .catch(error => {
            console.error('Error saving cart items:', error);
            alert('Failed to save cart items. Please try again.');
        });
}
</script>

</body>
</html>
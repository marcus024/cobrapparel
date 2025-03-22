<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Cobrapparel</title>
    <link rel="icon" href="cobra.png" type="image/x-icon">
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex lg:flex-col  flex-col w-full ">
        <div class="items-center h-[15vh] justify-center py-10 w-full">
            <p class=" font-extrabold text-center text-2xl main-color">CHECKOUT</p>
        </div>
        <div class="flex flex-col lg:flex-row w-full  bg-gray-100  ">
            
            <div class="bg-[#700101] p-5 w-full  lg:w-[60%] h-auto ">
                <div class="flex flex-col">
                    <p class="text-white font-bold text-sm py-2">Delivery Address</p>
                    <input type="text" id="address" placeholder="Address" 
                        class="w-full max-w-[350px] bg-white h-[25px] lg:h-[40px]  lg:max-w-full text-xs lg:text-lg p-2 main-color placeholder-[#700101] border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#700101]">
                    <div class="flex gap-1 mt-2">
                        <input type="text" id="city" placeholder="City" 
                            class="w-full max-w-[350px] bg-white h-[25px] lg:h-[40px] lg:text-lg  text-xs placeholder-[#700101]  p-2 main-color  border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#700101]">
                       <select id="state" class="w-full max-w-[350px] bg-white h-[25px] text-xs lg:mx-1  lg:h-[40px] lg:text-lg main-color border border-gray-300  focus:outline-none focus:ring-2 focus:ring-[#700101]">
                            <option value="" disabled selected>State</option>
                            <option value="ACT">Australian Capital Territory</option>
                            <option value="NSW">New South Wales</option>
                            <option value="NT">Northern Territory</option>
                            <option value="QLD">Queensland</option>
                            <option value="SA">South Australia</option>
                            <option value="TAS">Tasmania</option>
                            <option value="VIC">Victoria </option>
                            <option value="WA">Western Australia</option>
                        </select>
                        <input type="text" id="postcode" placeholder="Postcode" 
                            class="w-full max-w-[350px] bg-white h-[25px] text-xs lg:h-[40px] lg:text-lg  placeholder-[#700101] p-2 main-color  border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#700101]">
               
                    </div>
                    <div class="flex gap-1 mt-2">
                        <input type="text" id="firstname" placeholder="First Name" 
                            class="w-full max-w-[350px] lg:max-w-full lg:h-[40px] lg:mr-1 lg:text-lg bg-white h-[25px] text-xs placeholder-[#700101]  p-2 main-color  border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#700101]">
                        <input type="text" id="lastname" placeholder="Last Name" 
                            class="w-full max-w-[350px] lg:max-w-full lg:h-[40px] lg:text-lg  bg-white h-[25px] text-xs  placeholder-[#700101] p-2 main-color  border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#700101]">
                    </div>
                    <input type="text" id="phone_number" placeholder="Mobile Phone Number" 
                            class="w-full mt-2 max-w-[350px] lg:max-w-full lg:h-[40px] lg:mb-1 lg:text-lg  bg-white h-[25px] text-xs  placeholder-[#700101] p-2 main-color  border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#700101]">
                    <input type="text" id="email" placeholder="Email Address" 
                        class="w-full mt-1 max-w-[350px] lg:max-w-full lg:h-[40px] lg:text-lg bg-white h-[25px] text-xs  placeholder-[#700101] p-2 main-color  border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#700101]">
                </div>
                <div class="flex flex-col w-full h-auto text-white mt-2 text-[8px] lg:text-[12px]">
                    <p>*Once your order is ready, your club contact will notify you with collection details.</p>
                    <p class="justify-even mt-2 ">*Your information will be saved in our system. By continuing, you agree to our Shop's Terms of Service and acknowledge the Privacy Policy.</p>
                </div>
                <div class="flex flex-col mt-10">
                    <a href="" class="text-white underline text-[8px] lg:text-[12px]"> Refund Policy</a>
                    <a href="" class="text-white underline text-[8px] lg:text-[12px]"> Privacy Policy</a>
                    <a href="" class="text-white underline text-[8px] lg:text-[12px]"> Term of Service</a>
                </div>
            </div>
            <div class="flex flex-col h-auto w-full lg:h-screen lg:w-[40%] p-2 bg-[url('/images/bgblur.png')] bg-cover bg-center bg-no-repeat">
                <div class="flex lg:flex-col lg:h-[300px] w-full p-2 overflow-y-auto" id="checkoutContent"></div>

                <div class="flex flex-col items-end px-2 lg:py-16 py-4">
                    <p class="text-[12px] lg:text-[20px] font-bold main-color text-right" id="totalPay">TOTAL <span>$0.00 + GST</span></p>
                    <p hidden class="text-[10px] lg:text-[12px] main-color text-right">Including 10% GST and Shipping</p>
                </div>
                <div class="flex flex-col mt-5 justify-end ">
                    <a id="checkoutButton" 
                        class="bg-btn text-white cursor-pointer font-bold py-1 px-2 text-xs lg:text-lg w-40 lg:w-[200px] self-end transition-transform transform hover:scale-100 text-center">
                        CHECKOUT
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Confirmation Popup Modal -->
    <div id="checkoutPopup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-5 rounded-lg shadow-lg w-80 text-center">
            <p class="text-lg font-semibold">Confirm Checkout</p>
            <p class="text-sm mt-2">Are you sure you want to proceed to checkout?</p>
            <div class="flex justify-center mt-4 space-x-4">
                <button id="confirmCheckout" class="bg-[#700101] text-white px-4 py-2 rounded">Yes, Checkout</button>
                <button id="cancelCheckout" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
            </div>
        </div>
    </div>


    <script>
   document.addEventListener("DOMContentLoaded", function () {
    fetch('/cart/items')
        .then(response => response.json())
        .then(cartItems => {
            let checkoutHTML = "";
            let totalPay = 0;

            cartItems.forEach(item => {
                let imagePath = "/default-image.jpg"; // Default fallback

                try {
                    let imageArray = typeof item.image === "string" ? JSON.parse(item.image.replace(/&quot;/g, '"')) : item.image;
                    if (Array.isArray(imageArray) && imageArray.length > 0) {
                        imagePath = imageArray[0].startsWith("/") ? imageArray[0] : `/storage/${imageArray[0]}`;
                    }
                } catch (error) {
                    console.error("Error parsing image path:", error);
                }

                console.log("Final Image Path:", imagePath); // Debugging log

                let itemTotal = parseFloat(item.price) * item.quantity;
                totalPay += itemTotal;

                checkoutHTML += `
                    <div class="flex lg:flex-row p-1">
                        <div class="flex h-16 w-25 lg:w-50 lg:h-32">
                           <img src="${item.image}" alt="Product Image" onerror="this.src='/default-image.jpg'">
                            <div class="relative top-1 h-4 lg:h-6 w-4 lg:w-6 pl-1 lg:pl-2 lg:pt-1 justify-center items-center bg-btn rounded-full">
                                <p class="self-center ml-[1px] text-white text-[8px] lg:text-[10px] font-bold">${item.quantity}</p>
                            </div>
                        </div>
                        <div class="flex flex-col lg:h-30 lg:pl-20 justify-center">
                            <p class="text-[8px] lg:text-[20px] main-color">${item.name}</p>
                            <p class="text-[7px] lg:text-[15px] main-color">${item.size ?? "N/A"}</p>
                            <p class="text-[8px] lg:text-[15px] font-bold main-color">$${parseFloat(item.price).toFixed(2)} + GST</p>
                        </div>
                    </div>
                `;
            });

            document.getElementById("checkoutContent").innerHTML = checkoutHTML;
            document.getElementById("totalPay").innerHTML = `TOTAL <span>$${totalPay.toFixed(2)} + GST</span>`;
        })
        .catch(error => console.error("Error fetching cart items:", error));
});


</script>
<script>
document.getElementById("checkoutButton").addEventListener("click", function() {
    document.getElementById("checkoutPopup").classList.remove("hidden");
});

document.getElementById("cancelCheckout").addEventListener("click", function() {
    document.getElementById("checkoutPopup").classList.add("hidden");
});


</script>
<script>
   document.getElementById("confirmCheckout").addEventListener("click", function() {
    let cartItems = JSON.parse(localStorage.getItem('checkoutCart')) || [];
    let formData = {
        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        first_name: document.getElementById("firstname").value,
        last_name: document.getElementById("lastname").value,
        email: document.getElementById("email").value,
        phone: document.getElementById("phone_number").value,
        address: document.getElementById("address").value,
        city: document.getElementById("city").value,
        state: document.getElementById("state").value,
        postcode: document.getElementById("postcode").value,

        cart: cartItems
    };

    fetch("/testCheckout", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    body: JSON.stringify(formData)
})
.then(response => response.json())
.then(data => {
    console.log("API Response:", data); // Debugging

    if (data.checkout_url) {
        window.location.href = data.checkout_url; // Redirect to Stripe Checkout
    } else {
        alert("Error processing payment.");
    }
})
.catch(error => {
    console.error("Checkout failed:", error);
    alert("Please complete the form.");
});

});


</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\dashboard\cobrapparel\resources\views/checkout.blade.php ENDPATH**/ ?>
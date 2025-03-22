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
                    <p>Once your order is ready, your club contact will notify you with collection details.</p>
                    <p class="justify-even mt-2 ">By continuing, you agree to our Shop's Terms of Service and acknowledge the Privacy Policy.</p>
                </div>
                <div class="flex flex-col mt-10">
                    <!-- Refund Policy -->
                    <a href="javascript:void(0)" onclick="openModal('refundModal')" class="text-white underline text-[8px] lg:text-[12px]">Refund Policy</a>

                    <!-- Privacy Policy -->
                    <a href="javascript:void(0)" onclick="openModal('privacyModal')" class="text-white underline text-[8px] lg:text-[12px]">Privacy Policy</a>

                    <!-- Terms of Service -->
                    <a href="javascript:void(0)" onclick="openModal('termsModal')" class="text-white underline text-[8px] lg:text-[12px]">Terms of Service</a>
                </div>
            </div>
            <div class="flex flex-col h-auto w-full lg:h-screen lg:w-[40%] p-2 bg-[url('/images/bgblur.png')] bg-cover bg-center bg-no-repeat">
                <div class="flex lg:flex-col lg:h-[300px] w-full p-2 overflow-y-auto" id="checkoutContent"></div>

                <div class="flex flex-col items-end px-2 lg:py-16 py-4">
                    <p class="text-[12px] lg:text-[15px] font-bold main-color text-right" id="totalPay">Sub Total<span>$0.00 + GST</span></p>
                    <p class="text-[12px] lg:text-[15px] font-bold main-color text-right" id="gstSubtotal">$0.00  GST</p>
                    <p class="text-[12px] lg:text-[20px] font-bold main-color text-right" id="totalBuy">Total<span>$0.00 </span></p>
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
    <!-- Modal Template -->
    <div id="refundModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full max-h-[80vh] overflow-y-auto">
        <h2 class="text-2xl font-bold text-[#700101] mb-4">Returns & Refunds Policy</h2>
        
        <div class="space-y-4 text-sm text-gray-700">
            <p>At Cobrapparel, we take pride in the quality of our products. If you receive an item that is faulty or not as described, we will happily offer a replacement or refund in accordance with Australian Consumer Law.</p>

            <div>
                <h3 class="font-bold mt-4 mb-2">Eligibility for a Return</h3>
                <p>Returns are only accepted if the item:</p>
                <ul class="list-disc pl-6 mt-2 space-y-1">
                    <li>Has a manufacturing defect or fault</li>
                    <li>Is significantly different from what was advertised</li>
                    <li>Is damaged during transit</li>
                </ul>
                <p class="mt-2">To be eligible, the item must be unused, in its original condition, and returned within 30 days of delivery with its original packaging. Proof of purchase is required.</p>
                <p class="mt-2 font-semibold">We do not offer returns or refunds for:</p>
                <ul class="list-disc pl-6 mt-1 space-y-1">
                    <li>Change of mind</li>
                    <li>Incorrect size selection</li>
                    <li>Normal wear and tear or misuse of the product</li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold mt-4 mb-2">Refund Process</h3>
                <p>Once we receive and inspect your returned item, we will notify you of the approval or rejection of your refund. If approved, the refund will be processed to your original payment method within a certain number of days.</p>
                <p class="mt-2 text-gray-600">If your refund is delayed, please check with your bank or payment provider, as processing times may vary.</p>
            </div>

            <div>
                <h3 class="font-bold mt-4 mb-2">Exchanges</h3>
                <p>We can replace items only if they are faulty or damaged upon arrival. If you need an exchange, please email us at <span class="text-[#700101]">suppliers@cobrapparel.com</span> for further assistance.</p>
            </div>

            <div>
                <h3 class="font-bold mt-4 mb-2">Return Shipping</h3>
                <p>To initiate a return, contact us at <span class="text-[#700101]">suppliers@cobrapparel.com</span>, and we will provide details on where to send your item. Return shipping costs are the buyer’s responsibility and are non-refundable. If a refund is approved, the return shipping cost will be deducted from the refund amount.</p>
                <p class="mt-2 text-gray-600">For high-value returns, we recommend using a trackable shipping service, as we cannot guarantee receipt of returned items.</p>
            </div>

            <div class="mt-4">
                <p>For any questions regarding returns and refunds, feel free to reach out to us at <span class="text-[#700101]">suppliers@cobrapparel.com</span>.</p>
            </div>
        </div>

        <button onclick="closeModal('refundModal')" class="mt-6 w-full px-4 py-2 bg-[#700101] text-white rounded hover:bg-[#500000] transition-colors">
            Close
        </button>
    </div>
</div>

    <div id="privacyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full max-h-[80vh] overflow-y-auto">
        <h2 class="text-2xl font-bold text-[#700101] mb-4">Privacy Policy</h2>
        
        <div class="space-y-4 text-sm text-gray-700">
            <p>This Privacy Policy outlines how Cobrapparel collects, uses, and shares personal information when you visit or make a purchase from our Club Shop. All information collected is solely for processing orders and will be provided to the respective Club administrators for order fulfillment and club management.</p>

            <div>
                <h3 class="font-bold mt-4 mb-2">Personal Information We Collect</h3>
                <p>When you place an order through our Club Shop, we collect the following information:</p>
                <ul class="list-disc pl-6 mt-2 space-y-1">
                    <li>Name</li>
                    <li>Billing and shipping address</li>
                    <li>Email address</li>
                    <li>Phone number</li>
                    <li>Payment details (processed securely by third-party payment providers)</li>
                    <li>Order details (items purchased, sizes, and preferences)</li>
                </ul>
                <p class="mt-2">Additionally, we may collect information about how you interact with our website, including your IP address, browser type, and referral source, to improve our services.</p>
            </div>

            <div>
                <h3 class="font-bold mt-4 mb-2">How We Use Your Information</h3>
                <p>The information we collect is used exclusively to:</p>
                <ul class="list-disc pl-6 mt-2 space-y-1">
                    <li>Process and fulfill your order</li>
                    <li>Communicate with you regarding your purchase</li>
                    <li>Forward your details to the relevant Club administrators for order distribution</li>
                    <li>Improve our customer experience and website functionality</li>
                    <li>Comply with legal obligations and prevent fraudulent activities</li>
                </ul>
            </div>

            <div>
                <h3 class="font-bold mt-4 mb-2">Sharing Your Information</h3>
                <p>Cobrapparel does not sell or share your personal data with third parties for marketing purposes. However, your order details and contact information will be shared with the designated Club administrators responsible for processing and distributing your order.</p>
                <p class="mt-2 text-gray-600">Payment information is handled securely by third-party payment processors and is not stored by Cobrapparel.</p>
            </div>

            <div>
                <h3 class="font-bold mt-4 mb-2">Your Rights</h3>
                <p>If you wish to access, update, or request the deletion of your personal information, please contact us at <span class="text-[#700101]">suppliers@cobrapparel.com</span>. Please note that data required for order fulfillment and compliance cannot be deleted until after the completion of your purchase.</p>
            </div>

            <div>
                <h3 class="font-bold mt-4 mb-2">Changes to This Policy</h3>
                <p>We may update this Privacy Policy from time to time to reflect operational, legal, or regulatory changes. Any updates will be posted on our website.</p>
            </div>

            <div>
                <h3 class="font-bold mt-4 mb-2">Contact Us</h3>
                <p>If you have any questions about this Privacy Policy or how your information is handled, please contact us at <span class="text-[#700101]">suppliers@cobrapparel.com</span>.</p>
            </div>
        </div>

        <button onclick="closeModal('privacyModal')" class="mt-6 w-full px-4 py-2 bg-[#700101] text-white rounded hover:bg-[#500000] transition-colors">
            Close
        </button>
    </div>
</div>

<!-- Terms of Service Modal -->
<div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl w-full max-h-[80vh] overflow-y-auto">
        <h2 class="text-2xl font-bold text-[#700101] mb-4">Terms of Service</h2>

        <h3 class="mt-4 font-bold">OVERVIEW</h3>
        <p class="text-sm mt-2">
            This website is operated by Cobrapparel. Throughout the site, the terms “we”, “us” and “our” refer to Cobrapparel. Cobrapparel offers this website, including all information, tools, and services available from this site to you, the user, conditioned upon your acceptance of all terms, conditions, policies, and notices stated here.
        </p>
        <p class="text-sm mt-2 justify-center">
            By visiting our site and/or purchasing something from us, you engage in our “Service” and agree to be bound by the following terms and conditions (“Terms of Service”, “Terms”), including those additional terms and conditions and policies referenced herein and/or available by hyperlink. These Terms of Service apply to all users of the site, including without limitation users who are browsers, vendors, customers, merchants, and/or contributors of content.

Please read these Terms of Service carefully before accessing or using our website. By accessing or using any part of the site, you agree to be bound by these Terms of Service. If you do not agree to all the terms and conditions of this agreement, then you may not access the website or use any services. If these Terms of Service are considered an offer, acceptance is expressly limited to these Terms of Service.

Any new features or tools that are added to the current store shall also be subject to the Terms of Service. You can review the most current version of the Terms of Service at any time on this page. We reserve the right to update, change, or replace any part of these Terms of Service by posting updates and/or changes to our website. It is your responsibility to check this page periodically for changes. Your continued use of or access to the website following the posting of any changes constitutes acceptance of those changes.

Our store is hosted on an e-commerce platform that provides us with the online tools necessary to sell our products and services to you.
        </p>

        <h3 class="mt-4 font-bold">SECTION 1 - ONLINE STORE TERMS</h3>
        <p class="text-sm mt-2">
            By agreeing to these Terms of Service, you represent that you are at least the age of majority in your state or province of residence or that you are the age of majority in your state or province of residence and have given us your consent to allow any of your minor dependents to use this site.
        </p>

        <p class="text-sm mt-2">
            You may not use our products for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright laws).
        </p>

        <p class="text-sm mt-2">
                You must not transmit any worms, viruses, or any code of a destructive nature.
        </p>

        <p class="text-sm mt-2">
                A breach or violation of any of the Terms will result in an immediate termination of your Services.
        </p>


        <div class="max-w-3xl mx-auto ">
    <h3 class="mt-4 text-lg font-bold">SECTION 2 - GENERAL CONDITIONS</h3>
    <p class="text-sm mt-2">
        We reserve the right to refuse service to anyone for any reason at any time.
    </p>
    <p class="text-sm mt-2">
        You understand that your content (not including credit card information) may be transferred unencrypted and involve 
        (a) transmissions over various networks and (b) changes to conform and adapt to technical requirements of connecting networks or devices. 
        Credit card information is always encrypted during transfer over networks.
    </p>
    <p class="text-sm mt-2">
        You agree not to reproduce, duplicate, copy, sell, resell, or exploit any portion of the Service, use of the Service, or access to the Service 
        or any contact on the website through which the service is provided, without express written permission from us.
    </p>
    <p class="text-sm mt-2">
        The headings used in this agreement are included for convenience only and will not limit or otherwise affect these Terms.
    </p>
    
    <h3 class="mt-4 text-lg font-bold">SECTION 3 - ACCURACY, COMPLETENESS, AND TIMELINESS OF INFORMATION</h3>
    <p class="text-sm mt-2">
        We are not responsible if information made available on this site is not accurate, complete, or current.
        The material on this site is provided for general information only and should not be relied upon or used as the sole basis for making decisions 
        without consulting primary, more accurate, more complete, or more timely sources of information.
    </p>
    <p class="text-sm mt-2">
        This site may contain certain historical information. Historical information is not current and is provided for reference only. 
        We reserve the right to modify the contents of this site at any time, but we have no obligation to update any information.
    </p>
    
    <h3 class="mt-4 text-lg font-bold">SECTION 4 - MODIFICATIONS TO THE SERVICE AND PRICES</h3>
    <p class="text-sm mt-2">
        Prices for our products are subject to change without notice.
    </p>
    <p class="text-sm mt-2">
        We reserve the right at any time to modify or discontinue the Service (or any part or content thereof) without notice.
    </p>
    <p class="text-sm mt-2">
        We shall not be liable to you or any third party for any modification, price change, suspension, or discontinuance of the Service.
    </p>
    
     <h3 class="mt-4 font-bold text-lg">SECTION 5 - PRODUCTS OR SERVICES</h3>
    <p class="text-sm mt-2">Certain products or services may be available exclusively online through the website. These products or services may have limited quantities and are subject to return or exchange only according to our Return Policy.</p>
    <p class="text-sm mt-2">We have made every effort to display as accurately as possible the colors and images of our products that appear at the store. We cannot guarantee that your device’s display of any color will be accurate.</p>
    <p class="text-sm mt-2">We reserve the right to limit the sales of our products or services to any person, geographic region, or jurisdiction on a case-by-case basis. We reserve the right to limit quantities of any products or services that we offer. All descriptions of products or pricing are subject to change at any time without notice. We also reserve the right to discontinue any product at any time. Any offer for any product or service made on this site is void where prohibited.</p>

    <h3 class="mt-4 font-bold text-lg">SECTION 6 - ACCURACY OF BILLING AND ACCOUNT INFORMATION</h3>
    <p class="text-sm mt-2">We reserve the right to refuse any order you place with us. We may, in our sole discretion, limit or cancel quantities purchased per person, per household, or per order. These restrictions may include orders placed by or under the same customer account, the same credit card, and/or orders that use the same billing and/or shipping address. In the event that we make a change to or cancel an order, we may attempt to notify you by contacting the email and/or billing address/phone number provided at the time the order was made.</p>
    <p class="text-sm mt-2">You agree to provide current, complete, and accurate purchase and account information for all purchases made at our store.</p>
    <p class="text-sm mt-2">For more detail, please review our Returns Policy.</p>
    
    <h3 class="mt-4 text-lg font-bold">SECTION 7 - PERSONAL INFORMATION</h3>
    <p class="text-sm mt-2">
        Your submission of personal information through the store is governed by our Privacy Policy.
    </p>
    
    <h3 class="mt-4 text-lg font-bold">SECTION 8 - CONTACT INFORMATION</h3>
    <p class="text-sm mt-2">
        Questions about the Terms of Service should be sent to us at 
        <a href="mailto:suppliers@cobrapparel.com" class="text-blue-500 underline">suppliers@cobrapparel.com</a>.
    </p>
    
    <p class="text-xs text-gray-500 mt-4">Last updated on March 22, 2025.</p>
</div>


        <button onclick="closeModal('termsModal')" class="mt-6 w-full px-4 py-2 bg-[#700101] text-white rounded">Close</button>
    </div>
</div>


    <script>
    function openModal(id) {
            document.getElementById(id).classList.remove("hidden");
            }

            function closeModal(id) {
                document.getElementById(id).classList.add("hidden");
            }
        </script>


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

                let gst = totalPay * 0.10; // Compute 10% GST
                let totalWithGST = totalPay + gst;

                let gstElement = document.getElementById("gstSubtotal");
                if (gstElement) {
                    gstElement.innerHTML = `GST $${gst.toFixed(2)} `;
                } else {
                    console.error("Element #gstSubtotal not found!");
                }

                let totalElement = document.getElementById("totalBuy");
                if (totalElement) {
                  totalElement.innerHTML = `TOTAL <span>$${totalWithGST.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>`;
                } else {
                    console.error("Element #gstSubtotal not found!");
                }

                checkoutHTML += `
                    <div class="flex lg:flex-row p-1">
                        <div class="flex h-16 w-25 lg:w-50 lg:h-32">
                           <img src="${item.image}" alt="Product Image" onerror="this.src='/default-image.jpg'">
                            <div class="relative top-1 h-4 lg:h-6 w-4 lg:w-6 pl-1 lg:pl-2 lg:pt-1 justify-center items-center bg-btn rounded-full">
                                <p class="self-center ml-[1px] text-white text-[8px] lg:text-[10px] font-bold">${item.quantity}</p>
                            </div>
                        </div>
                        <div class="flex flex-col lg:h-30 lg:pl-20 justify-center">
                            <p class="text-[8px] lg:text-[15px] main-color">
                                 ${item.name}
                            </p>
                            <p class="text-[7px] lg:text-[12px] main-color">
                                <span class="font-bold">Size:</span> ${item.size ?? "N/A"}
                            </p>
                            <p class="text-[7px] lg:text-[12px] main-color">
                                <span class="font-bold">Custom Number:</span> ${item.custom_number ?? "N/A"}
                            </p>
                            <p class="text-[7px] lg:text-[12px] main-color">
                                <span class="font-bold">Custom Name:</span> ${item.custom_name ?? "N/A"}
                            </p>
                            <p class="text-[8px] lg:text-[12px] font-bold main-color">
                                <span class="font-bold">Price:</span> $${parseFloat(item.price).toFixed(2)} + GST
                            </p>
                        </div>
                    </div>
                `;
            });

            document.getElementById("checkoutContent").innerHTML = checkoutHTML;
            document.getElementById("totalPay").innerHTML = `SUBTOTAL <span>$${totalPay.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>`;
            

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
    let totalPay = 0;

    // Loop through cart items to calculate total price
    cartItems.forEach(item => {
        let itemTotal = parseFloat(item.price) * item.quantity;
        totalPay += itemTotal;
    });

    // Compute 10% GST
    let gst = totalPay * 0.10;

    // Compute total with GST
    let totalWithGST = totalPay + gst;

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
        total_with_gst: totalWithGST.toFixed(2),
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
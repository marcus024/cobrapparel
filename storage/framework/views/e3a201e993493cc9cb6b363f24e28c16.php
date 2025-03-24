

<?php $__env->startSection('content'); ?>
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Products</h1>
    <button class="bg-[#700101] text-white px-4 py-2 rounded" onclick="document.getElementById('addProductModal').classList.remove('hidden')">Add Product</button>

    <!-- Product List -->
    <div class="mt-4">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 p-2">Product Image</th>
                    <th class="border border-gray-300 p-2">Product Name</th>
                    <th class="border border-gray-300 p-2">Price</th>
                    <th class="border border-gray-300 p-2">Size Chart</th>
                    <th class="border border-gray-300 p-2">Shop</th>
                    <th class="border border-gray-300 p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                <!-- Dynamic rows will be added here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-5xl flex flex-col md:flex-row gap-5">
        
        <!-- Left Side: Form Inputs -->
        <div class="w-full md:w-1/2 flex flex-col">
            <h2 class="text-xl font-bold mb-3">Add Product</h2>

            <!-- Shop Selection -->
            <label class="block font-semibold">Shop Name</label>
            <select id="shopSelect" class="border p-2 w-full mb-3">
                <option value="" disabled selected>Select a Shop</option>
            </select>

            <!-- Product Name -->
            <label class="block font-semibold">Product Name</label>
            <input type="text" id="productName" class="border p-2 w-full mb-3" placeholder="Enter Product Name">

            <!-- Price & Stock -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold">Price ($)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-600 font-bold">$</span>
                        <input type="number" id="productPrice" class="border p-2 w-full pl-6" placeholder="0.00">
                    </div>
                </div>
                <div>
                    <label class="block font-semibold">Stock</label>
                    <input type="number" id="productStock" class="border p-2 w-full" placeholder="Stock Quantity">
                </div>
            </div>

            <!-- Size Chart Selection -->
            <div class="grid grid-cols-2 gap-3 mt-3">
                <div class="flex items-center">
                    <input type="checkbox" id="sizeChartToggle" class="mr-2" onchange="toggleSizeChart()">
                    <label class="font-semibold">Enable Size Chart</label>
                </div>
                <select id="sizeChartSelect" class="border p-2 w-full bg-gray-200 cursor-not-allowed" disabled>
                <option value="" disabled selected>Check the box to enable</option>
                <option value="transition_singlet">Transition Singlet</option>
                <option value="transition_standard_polo">Transition Standard Polo</option>
                <option value="transition_trade_polo">Transition Trade Polo</option>
                <option value="transition_warmup_tee">Transition Warm Up Tee</option>
                <option value="transition_hoodie">Transition Hoodie</option>
                <option value="transition_netball_dress">Transition Netball Dress</option>
                <option value="dipsas_singlet">Dipsas Singlet</option>
                <option value="dipsas_standard_polo">Dipsas Standard Polo</option>
                <option value="dipsas_trade_polo">Dipsas Trade Polo</option>
                <option value="dipsas_warmup_tee">Dipsas Warm Up Tee</option>
                <option value="dipsas_hoodie">Dipsas Hoodie</option>
                <option value="dipsas_netball_dress">Dipsas Netball Dress</option>
                <option value="dipsas_quarter_zip">Dipsas Quarter Zip</option>
                
                <option value="dipsas_women_short">Dipsas Women Short</option>
                <option value="dipsas_women_polo">Dipsas Women Polo</option>
                <option value="dipsas_women_singlet">Dipsas Women Singlet</option>
                <option value="dipsas_spray_jacket">Dipsas Spray Jacket</option>

                <option value="truckers">Truckers</option>
                <option value="beanies">Beanies</option>

                 <option value="socks">Socks</option>
                    <option value="men_short">Men Short</option>
            </select>
        </div>

        <!-- Custom Fields -->
        <div class="grid grid-cols-2 gap-3 mt-3">
            <div class="flex items-center">
                <input type="checkbox" id="customNumberToggle" class="mr-2" onchange="toggleCustomField('customNumber')">
                <label class="font-semibold">Custom Number</label>
            </div>
            <input type="text" id="customNumber" class="border p-2 w-full bg-gray-200 cursor-not-allowed" disabled>

            <div class="flex items-center">
                <input type="checkbox" id="customNameToggle" class="mr-2" onchange="toggleCustomField('customName')">
                <label class="font-semibold">Custom Name</label>
            </div>
            <input type="text" id="customName" class="border p-2 w-full bg-gray-200 cursor-not-allowed" disabled>
        </div>

        </div>

        <!-- Right Side: Image Upload & Preview -->
        <div class="w-full md:w-1/2 flex flex-col">

            <label class="block font-semibold mb-1">Product End Date</label>
            <input type="date" id="productEnd" class="border p-2 w-full mb-3">

            <!-- Image Upload Input -->
            <label class="block font-semibold mb-1">Upload Images</label>
            <input type="file" id="productImages" class="border p-2 w-full mb-3" accept="image/*" multiple onchange="previewImages()">

            <!-- Image Preview Container (Horizontal Layout) -->
            <div id="imagePreview" class="flex gap-2 overflow-x-auto p-2">
                <!-- Images will be added here dynamically -->
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-5">
                <button onclick="addProduct()" class="bg-[#700101] text-white px-4 py-2 rounded">Save</button>
                <button class="bg-gray-500 text-white px-4 py-2 rounded" onclick="document.getElementById('addProductModal').classList.add('hidden')">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg w-1/2">
        <h2 class="text-xl font-bold mb-4">Edit Product</h2>
        
        <form id="editProductForm" enctype="multipart/form-data">
            <input type="hidden" id="editProductId">
            
            <div class="flex lg:flex-row m-2">
                <div class="flex lg:flex-col m-2">
                    <label class="block text-sm font-semibold">Name</label>
                    <input type="text" id="editProductName" class="w-full border p-2 rounded mb-2">
                    
                    <label class="block text-sm font-semibold">Price</label>
                    <input type="number" id="editProductPrice" class="w-full border p-2 rounded mb-2">
                </div>   
                <div class="flex lg:flex-col m-2">
                    <label class="block text-sm font-semibold">Stock</label>
                    <input type="number" id="editProductStock" class="w-full border p-2 rounded mb-2">
                
                
                    <label class="block text-sm font-semibold">Product End Date</label>
                    <input type="text" id="editProductEndDate" class="w-full border p-2 rounded mb-2">
                </div>
                <div class="flex lg:flex-col m-2">
                    <label class="block text-sm font-semibold">Custom Name</label>
                    <input type="number" id="editProductCustomname" class="w-full border p-2 rounded mb-2">
                    
                    <label class="block text-sm font-semibold">Custom Number</label>
                    <input type="number" id="editProductCustomnumber" class="w-full border p-2 rounded mb-2">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 m-2">
                <select id="editProductSizechart" class="border p-2 w-full bg-gray-200 " >
                    <option value="" disabled selected>Check the box to enable</option>
                    <option value="transition_singlet">Transition Singlet</option>
                    <option value="transition_standard_polo">Transition Standard Polo</option>
                    <option value="transition_trade_polo">Transition Trade Polo</option>
                    <option value="transition_warmup_tee">Transition Warm Up Tee</option>
                    <option value="transition_hoodie">Transition Hoodie</option>
                    <option value="transition_netball_dress">Transition Netball Dress</option>
                    <option value="dipsas_singlet">Dipsas Singlet</option>
                    <option value="dipsas_standard_polo">Dipsas Standard Polo</option>
                    <option value="dipsas_trade_polo">Dipsas Trade Polo</option>
                    <option value="dipsas_warmup_tee">Dipsas Warm Up Tee</option>
                    <option value="dipsas_hoodie">Dipsas Hoodie</option>
                    <option value="dipsas_netball_dress">Dipsas Netball Dress</option>
                    <option value="dipsas_quarter_zip">Dipsas Quarter Zip</option>
                    
                    <option value="dipsas_women_short">Dipsas Women Short</option>
                    <option value="dipsas_women_polo">Dipsas Women Polo</option>
                    <option value="dipsas_women_singlet">Dipsas Women Singlet</option>
                    <option value="dipsas_spray_jacket">Dipsas Spray Jacket</option>

                    <option value="truckers">Truckers</option>
                    <option value="beanies">Beanies</option>

                    <option value="socks">Socks</option>
                    <option value="men_short">Men Short</option>
                </select>
            </div>
            
            <label class="block text-sm font-semibold">Current Images</label>
            <div id="editProductImages" class="flex flex-wrap gap-2 mb-2"></div>

            <label class="block text-sm font-semibold">Upload New Images</label>
            <input type="file" id="newProductImages" multiple class="w-full border p-2 rounded mb-2">

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-3 py-1 rounded">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Save Changes</button>
            </div>
        </form>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\cobrapparel\resources\views/admin/products.blade.php ENDPATH**/ ?>
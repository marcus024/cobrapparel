

<?php $__env->startSection('content'); ?>
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Shops</h1>
    <button class="bg-[#700101] text-white px-4 py-2 rounded" onclick="document.getElementById('addShopModal').classList.remove('hidden')">Add Shop</button>

    <div class="mt-4">
        <table class="w-full border-collapse border border-gray-300 shadow-lg rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-[#700101] text-white text-left">
                    <th class="border border-gray-300 p-3">Image</th>
                    <th class="border border-gray-300 p-3">Shop Name</th>
                    <th class="border border-gray-300 p-3">Owner</th>
                    <th class="border border-gray-300 p-3">Date Created</th>
                      <th class="border border-gray-300 p-3">Actions</th>
                </tr>
            </thead>
            <tbody id="shopTableBody">
                <!-- Shop rows will be inserted here dynamically -->
            </tbody>
        </table>
    </div>
</div>

<div id="addShopModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-5 rounded-lg shadow-lg w-[350px]">
        <h2 class="text-xl font-bold mb-4">Add Shop</h2>
        <input type="text" id="shopName" class="border p-2 w-full mb-3" placeholder="Shop Name">
        <input type="text" id="shopOwner" class="border p-2 w-full mb-3" placeholder="Owner">
        <input type="text" id="contactName" class="border p-2 w-full mb-3" placeholder="Contact Name">
        <input type="tel" id="contactNumber" class="border p-2 w-full mb-3" placeholder="Contact Number">
        <input type="email" id="emailAddress" class="border p-2 w-full mb-3" placeholder="Email Address">
        <label class="border p-2 w-full mb-3 flex justify-start items-center cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-md">
                Shop Duration
            </label>
        <input type="date" id="shopDuration" class="border p-2 w-full mb-3" placeholder="Duration (Months)">

        <div class="relative w-full">
            <input type="file" id="shopImage" class="hidden" accept="image/*" onchange="previewImage(event)">
            <label for="shopImage" class="border p-2 w-full mb-3 flex justify-center items-center cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-md">
                Add Shop Logo
            </label>
            <div id="previewContainer" class="mt-3 hidden">
                <img id="previewImage" src="" alt="Shop Logo" class="w-24 h-24 object-cover rounded-md border">
            </div>
        </div>

        <button class="bg-[#700101] mt-4 text-white px-4 py-2 rounded" onclick="addShop()">Save</button>
        <button class="bg-gray-500 text-white px-4 py-2 rounded ml-2" onclick="document.getElementById('addShopModal').classList.add('hidden')">Cancel</button>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\cobrapparel\resources\views/admin/shops.blade.php ENDPATH**/ ?>
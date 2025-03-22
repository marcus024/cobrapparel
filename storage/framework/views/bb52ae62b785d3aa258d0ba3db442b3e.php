

<?php $__env->startSection('content'); ?>
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-[#700101] text-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Total Products</h2>
            <p class="text-xl font-bold">120</p>
        </div>
        <div class="bg-[#700101] text-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Total Orders</h2>
            <p class="text-xl font-bold">80</p>
        </div>
        <div class="bg-[#700101] text-white p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Revenue</h2>
            <p class="text-xl font-bold">$5,000</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\cobrapparel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
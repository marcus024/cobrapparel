<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Cobrapparel Admin</title>
    <link rel="icon" href="cobra.png" type="image/x-icon">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js', 'resources/css/app.css']); ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#700101] text-white p-5 fixed h-screen">
        <h2 class="text-2xl font-bold mb-5">Cobrapparel</h2>
        <ul>
            <li class="mb-3"><a href="<?php echo e(route('admin.dashboard')); ?>" class="block p-2">Dashboard</a></li>
            <li class="mb-3"><a href="<?php echo e(route('admin.shops')); ?>" class="block p-2">Shops</a></li>
            <li class="mb-3"><a href="<?php echo e(route('admin.products')); ?>" class="block p-2">Products</a></li>
            <li class="mb-3"><a href="<?php echo e(route('admin.orders')); ?>" class="block p-2">Orders</a></li>
            <li class="mb-3"><a href="<?php echo e(route('admin.export')); ?>" class="block p-2">Export</a></li>
            <li>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="block p-2 bg-red-600 rounded text-white w-full text-left">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-5 ml-64 overflow-y-auto h-screen">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>

<script>
    function toggleSizeChart() {
        const sizeChartSelect = document.getElementById('sizeChartSelect');
        const isChecked = document.getElementById('sizeChartToggle').checked;
        sizeChartSelect.disabled = !isChecked;
        sizeChartSelect.classList.toggle('bg-gray-200', !isChecked);
        sizeChartSelect.classList.toggle('cursor-not-allowed', !isChecked);
        
        // Set default value when enabled
        if (isChecked) {
            sizeChartSelect.value = "transition"; 
        } else {
            sizeChartSelect.value = "";
        }
    }

    function toggleCustomField(fieldId) {
        const inputField = document.getElementById(fieldId);
        const isChecked = document.getElementById(fieldId + 'Toggle').checked;
        inputField.disabled = !isChecked;
        inputField.classList.toggle('bg-gray-200', !isChecked);
        inputField.classList.toggle('cursor-not-allowed', !isChecked);
        inputField.value = isChecked ? "Check the box to enable" : "";
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", fetchShops);

function fetchShops() {
    fetch("/shops")
        .then(response => response.json())
        .then(shops => {

            console.log("Fetched Shop Details:", shops); 

            let tableBody = document.getElementById("shopTableBody");
            tableBody.innerHTML = ""; // Clear existing content

            shops.forEach(shop => {
                let row = document.createElement("tr");
                row.classList.add("bg-white", "hover:bg-gray-100", "transition", "duration-200");

                row.innerHTML = `
                    <td class="border border-gray-300 p-3 text-center">
                        <img src="/storage/${shop.image}" alt="Shop Image" class="h-12 w-12 object-cover rounded-lg shadow-md">
                    </td>
                    <td class="border border-gray-300 p-3">${shop.name}</td>
                    <td class="border border-gray-300 p-3">${shop.owner}</td>
                    <td class="border border-gray-300 p-3">${new Date(shop.created_at).toLocaleDateString()}</td>
                    <td class="border border-gray-300 p-3 flex space-x-2">
                        <button onclick="editShop(
                            ${shop.id}, 
                            '${shop.name}', 
                            '${shop.owner}', 
                            '${shop.contact_name}', 
                            '${shop.contact_number}', 
                            '${shop.duration}', 
                            '${shop.emailAddress}', 
                            '/storage/${shop.image}'
                        )" class="bg-blue-500 text-white px-2 py-1 rounded flex items-center space-x-1">
                            <img src="/images/edit_shop.png" alt="Edit" class="h-5 w-5"> 
                            <span>Edit</span>
                        </button>
                        <button onclick="deleteShop(${shop.id})" 
                            class="bg-red-500 text-white px-2 py-1 rounded flex items-center space-x-1">
                            <img src="/images/delete_shop.png" alt="Delete" class="h-5 w-5"> 
                            <span>Delete</span>
                        </button>
                    </td>
                `;
                
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error fetching shops:", error));
}

function addShop() {
    let shopName = document.getElementById("shopName").value;
    let shopOwner = document.getElementById("shopOwner").value;
    let contactName = document.getElementById("contactName").value;
    let contactNumber = document.getElementById("contactNumber").value;
    let shopDuration = document.getElementById("shopDuration").value;
    let shopEmail = document.getElementById("emailAddress").value;
    let shopImage = document.getElementById("shopImage").files[0];

    if (!shopName || !shopOwner || !contactName || !contactNumber || !shopDuration || !shopEmail || !shopImage) {
        alert("Please fill in all fields.");
        return;
    }

    let formData = new FormData();
    formData.append("name", shopName);
    formData.append("owner", shopOwner);
    formData.append("contact_name", contactName);
    formData.append("contact_number", contactNumber);
    formData.append("email", shopEmail); // Correct field name
    formData.append("duration", shopDuration);
    formData.append("image", shopImage);

    fetch("/shops", {
        method: "POST",
        headers: {
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        fetchShops(); // Reload the shop list
        document.getElementById("addShopModal").classList.add("hidden"); // Close modal
    })
    .catch(error => {
        console.error("Error adding shop:", error);
        alert("An error occurred. Check the console for details.");
    });
}


// Preview Image Function
function previewImage(event) {
    let reader = new FileReader();
    reader.onload = function () {
        let previewContainer = document.getElementById("previewContainer");
        let previewImage = document.getElementById("previewImage");
        previewImage.src = reader.result;
        previewContainer.classList.remove("hidden");
    };
    reader.readAsDataURL(event.target.files[0]);
}

window.editShop = function (id, name, owner, contactName, contactNumber, duration, email, image) {
    console.log("Editing Shop:", {
        id,
        name,
        owner,
        contactName,
        contactNumber,
        duration,
        email,
        image
    });

    // Populate input fields with existing values
    document.getElementById('editShopName').value = name;
    document.getElementById('editShopOwner').value = owner;
    document.getElementById('editContactName').value = contactName;
    document.getElementById('editContactNumber').value = contactNumber;
    document.getElementById('editShopDuration').value = duration;
    document.getElementById('editEmailAddress').value = email;

    // Populate and show the existing image preview
    const previewContainer = document.getElementById('editPreviewContainer');
    const previewImage = document.getElementById('editPreviewImage');
    if (image) {
        previewImage.src = image;
        previewContainer.classList.remove('hidden');
    } else {
        previewContainer.classList.add('hidden');
    }

    // Show the modal
    document.getElementById('editShopModal').classList.remove('hidden');

    // Store the shop ID for updating
    document.getElementById('editShopModal').setAttribute("data-shop-id", id);
};


window.updateShop = function () {
    const shopId = document.getElementById('editShopModal').getAttribute("data-shop-id");

    const updatedShop = {
        id: shopId,
        name: document.getElementById('editShopName').value,
        owner: document.getElementById('editShopOwner').value,
        contact_name: document.getElementById('editContactName').value,
        contact_number: document.getElementById('editContactNumber').value,
        duration: document.getElementById('editShopDuration').value,
        emailAddress: document.getElementById('editEmailAddress').value,
        image: document.getElementById('editPreviewImage').src, // Keeping the same image for now
    };

    console.log("Updating Shop:", updatedShop);

    fetch(`/shops/${shopId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(updatedShop)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Shop updated successfully:", data);
        document.getElementById('editShopModal').classList.add('hidden');
        fetchShops(); // Refresh shop list
    })
    .catch(error => console.error("Error updating shop:", error));
};



function deleteShop(id) {
    if (!confirm("Are you sure you want to delete this shop?")) return;

    fetch(`/shops/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        fetchShops();
    })
    .catch(error => console.error("Error deleting shop:", error));
}

</script>



<script>
    document.addEventListener("DOMContentLoaded", fetchShopsForDropdown);

    function fetchShopsForDropdown() {
        fetch("/shops")
            .then(response => response.json())
            .then(shops => {
                let shopSelect = document.getElementById("shopSelect");
                shopSelect.innerHTML = '<option value="" disabled selected>Select a Shop</option>'; // Reset

                shops.forEach(shop => {
                    let option = document.createElement("option");
                    option.value = shop.id;
                    option.textContent = shop.name;
                    shopSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching shops:", error));
    }

</script>



<script>

 let selectedImages = []; // Store images persistently

function previewImages() {
    const files = document.getElementById('productImages').files;
    if (files.length === 0) return; // No files selected

    Array.from(files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            selectedImages.push({ file, url: e.target.result }); // Store both file & preview URL
            renderImages(); // Update the preview
        };
        reader.readAsDataURL(file);
    });
}

function renderImages() {
    const imagePreview = document.getElementById('imagePreview');
    imagePreview.innerHTML = ""; // Clear existing display

    selectedImages.forEach((imageObj, index) => {
        const imageContainer = document.createElement("div");
        imageContainer.classList.add("relative");

        const img = document.createElement("img");
        img.src = imageObj.url;
        img.classList.add("w-20", "h-20", "object-cover", "rounded-md", "border");

        // Remove Button
        const removeBtn = document.createElement("button");
        removeBtn.innerHTML = "&times;";
        removeBtn.classList.add("absolute", "top-0", "right-0", "bg-red-500", "text-white", "rounded-full", "w-5", "h-5", "flex", "items-center", "justify-center", "text-sm");
        removeBtn.onclick = function () {
            selectedImages.splice(index, 1); // Remove from array
            renderImages(); // Re-render images
        };

        imageContainer.appendChild(img);
        imageContainer.appendChild(removeBtn);
        imagePreview.appendChild(imageContainer);
    });
}

function addProduct() {
    let shopId = document.getElementById("shopSelect").value;
    let productName = document.getElementById("productName").value;
    let productPrice = document.getElementById("productPrice").value;
    let productStock = document.getElementById("productStock").value;
    let sizeChart = document.getElementById("sizeChartSelect").value; // Get size chart
    let customNumber = document.getElementById("customNumber").value; // Get custom number
    let customName = document.getElementById("customName").value; // Get custom name

    if (!shopId || !productName || !productPrice) {
        alert("Please fill in all required fields.");
        return;
    }

    let formData = new FormData();
    formData.append("shop_id", shopId);
    formData.append("name", productName);
    formData.append("price", productPrice);
    formData.append("stock", productStock);

    // Include optional fields
    if (sizeChart) {
        formData.append("size_chart", sizeChart);
    }
    if (customNumber) {
        formData.append("custom_number", customNumber);
    }
    if (customName) {
        formData.append("custom_name", customName);
    }

    // Append images properly
    selectedImages.forEach((imageObj) => {
        formData.append(`images[]`, imageObj.file);
    });

    // Debugging: Show all appended form data
    for (let pair of formData.entries()) {
        console.log(pair[0], pair[1]);
    }

   fetch('/products', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message); // Display success message from API response
        } else {
            alert("Product added successfully!"); // Fallback message
        }
        location.reload();
        console.log("Success:", data);
        document.getElementById('addProductModal').classList.add('hidden');
        selectedImages = []; // Clear selected images after submission
        renderImages(); // Clear image preview
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while adding the product."); // Show error alert
    });

}

</script>


<script>
   function fetchProducts() {
    fetch("/products")
        .then(response => response.json())
        .then(products => {
            let tableBody = document.getElementById("productTableBody");
            tableBody.innerHTML = ""; // Clear existing rows

            products.forEach(product => {
                let images = JSON.parse(product.images || "[]"); // Ensure images are parsed as an array
             let imageSrc = images.length > 0 ? `/${images[0]}` : "./images/no-image.png"; // Pick first image or default

             function formatSizeChart(value) {
                return value.replace(/_/g, ' ') // Replace underscores with spaces
                                    .replace(/\b\w/g, c => c.toUpperCase()); // Capitalize first letter of each word
                    }
                let row = `
                    <tr id="productRow-${product.id}">
                        <td class="border border-gray-300 p-2 text-center">
                            <img src="${imageSrc}" alt="Product Image" class="h-12 w-12 object-cover rounded">
                        </td>
                        <td class="border border-gray-300 p-2">${product.name}</td>
                        <td class="border border-gray-300 p-2">$${product.price}</td>
                        <td class="border border-gray-300 p-2">${formatSizeChart(product.size_chart)}</td>
                        <td class="border border-gray-300 p-2">${product.shop.name}</td>
                        <td class="border border-gray-300 p-3 flex space-x-2">
                            <button onclick="editProduct(${product.id}, '${product.name}', '${product.stock}', '${product.price}', '${product.shop.id}')" 
                                class="bg-blue-500 text-white px-2 py-1 rounded flex items-center space-x-1">
                                <img src="/images/edit_shop.png" alt="Edit" class="h-5 w-5"> 
                                <span>Edit</span>
                            </button>
                            <button onclick="deleteProduct(${product.id})" 
                                class="bg-red-500 text-white px-2 py-1 rounded flex items-center space-x-1">
                                <img src="/images/delete_shop.png" alt="Delete" class="h-5 w-5"> 
                                <span>Delete</span>
                            </button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error("Error fetching products:", error));
}

function deleteProduct(productId) {
    if (!confirm("Are you sure you want to delete this product?")) {
        return;
    }

    fetch(`/products/${productId}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            "Content-Type": "application/json",
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Failed to delete product");
        }
        return response.json();
    })
    .then(data => {
        alert(data.message);
        document.getElementById(`productRow-${productId}`).remove(); // Remove from table
    })
    .catch(error => console.error("Error deleting product:", error));
}


// Call fetchProducts when the page loads
document.addEventListener("DOMContentLoaded", fetchProducts);


</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\dashboard\cobrapparel\resources\views/admin/layouts/admin.blade.php ENDPATH**/ ?>
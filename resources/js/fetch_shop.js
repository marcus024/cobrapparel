document.addEventListener("DOMContentLoaded", fetchShops);

function fetchShops() {
    fetch("/shops")
        .then(response => response.json())
        .then(shops => {
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
                    <td class="border border-gray-300 p-3">
                        <button onclick="editShop(${shop.id}, '${shop.name}', '${shop.owner}', '/storage/${shop.image}')" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</button>
                        <button onclick="deleteShop(${shop.id})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
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
    let shopImage = document.getElementById("shopImage").files[0];

    if (!shopName || !shopOwner || !shopImage) {
        alert("Please fill in all fields.");
        return;
    }

    let formData = new FormData();
    formData.append("name", shopName);
    formData.append("owner", shopOwner);
    formData.append("image", shopImage);

    fetch("/shops", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        fetchShops(); // Reload the shops dynamically
        document.getElementById("addShopModal").classList.add("hidden"); // Close modal
    })
    .catch(error => console.error("Error adding shop:", error));
}

function editShop(id, name, owner, imageUrl) {
    document.getElementById("editShopId").value = id;
    document.getElementById("editShopName").value = name;
    document.getElementById("editShopOwner").value = owner;
    document.getElementById("editShopImagePreview").src = imageUrl;
    document.getElementById("editShopModal").classList.remove("hidden");
}

function updateShop() {
    let shopId = document.getElementById("editShopId").value;
    let shopName = document.getElementById("editShopName").value;
    let shopOwner = document.getElementById("editShopOwner").value;
    let shopImage = document.getElementById("editShopImage").files[0];

    let formData = new FormData();
    formData.append("name", shopName);
    formData.append("owner", shopOwner);
    if (shopImage) formData.append("image", shopImage);

    fetch(`/shops/${shopId}/update`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        fetchShops();
        document.getElementById("editShopModal").classList.add("hidden");
    })
    .catch(error => console.error("Error updating shop:", error));
}

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

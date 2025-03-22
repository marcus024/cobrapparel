@extends('admin.layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md ">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Orders</h1>
        <div class="flex space-x-2">
            <input type="text" id="searchInput" placeholder="Search orders..." 
                class="border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button onclick="exportTable()" 
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Export
            </button>
        </div>
    </div>
    <div class="overflow-x-auto m-3">

    @if ($orders->isEmpty())
        <p class="text-red-500">No orders found.</p>
    @else
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 p-2">Order ID</th>
                    <th class="border border-gray-300 p-2">Date</th>
                    <th class="border border-gray-300 p-2">Club Name</th>
                    <th class="border border-gray-300 p-2">Customer</th>
                    <th class="border border-gray-300 p-2">Email</th>
                    <th class="border border-gray-300 p-2">Phone</th>
                    <th class="border border-gray-300 p-2">Address</th>
                    <th class="border border-gray-300 p-2">City</th>
                    <th class="border border-gray-300 p-2">State</th>
                    <th class="border border-gray-300 p-2">Postcode</th>
                    <th class="border border-gray-300 p-2">Status</th>
                    <th class="border border-gray-300 p-2">Product Name</th>
                    <th class="border border-gray-300 p-2">Quantity</th>
                    <th class="border border-gray-300 p-2">Price</th>
                    <th class="border border-gray-300 p-2">Size</th>
                    <th class="border border-gray-300 p-2">Custom Name</th>
                    <th class="border border-gray-300 p-2">Custom Number</th>
                    <th class="border border-gray-300 p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    @php
                        $orderItems = \App\Models\OrderItem::where('order_unique', $order->order_id)->get();
                    @endphp

                    @foreach ($orderItems as $item)
                        @php
                            $product = \App\Models\Product::where('name', $item->product_name)->first();
                            $shopName = $product ? optional($product->shop)->name : 'N/A';
                        @endphp

                        <tr>
                            <td class="border border-gray-300 p-2">{{ $order->order_id }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="border border-gray-300 p-2">{{ $shopName }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->email }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->phone }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->address }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->city }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->state }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->postcode }}</td>
                            <td class="border border-gray-300 p-2">{{ $order->status }}</td>
                            
                             <!-- Shop Name Column -->
                            <td class="border border-gray-300 p-2">{{ $item->product_name }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->quantity }}</td>
                            <td class="border border-gray-300 p-2">${{ $item->price }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->size ?? 'N/A' }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->custom_name ?? 'N/A' }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->custom_number ?? 'N/A' }}</td>
                            <td class="border border-gray-300 p-2">
                                <button onclick="openModal('{{ $order->order_id }}')" class="bg-blue-500 text-white px-2 py-1 rounded">View</button>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif
    </div>
</div>

<!-- Order Details Modal -->
<div id="orderModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
        <h2 class="text-xl font-bold mb-4">Order Details</h2>
        <p><strong>Order ID:</strong> <span id="modalOrderId"></span></p>
        <p><strong>Customer:</strong> <span id="modalCustomer"></span></p>
        <p><strong>Status:</strong> 
            <select id="modalStatus" class="border border-gray-300 p-2 rounded">
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Shipped">Shipped</option>
                <option value="Delivered">Delivered</option>
                <option value="Canceled">Canceled</option>
            </select>
        </p>
        <p><strong>Order Date:</strong> <span id="modalDate"></span></p>
        <button onclick="updateStatus()" class="bg-green-500 text-white px-4 py-2 mt-4 rounded">Update Status</button>
        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 p-2">Product Name</th>
                    <th class="border border-gray-300 p-2">Quantity</th>
                    <th class="border border-gray-300 p-2">Price</th>
                    <th class="border border-gray-300 p-2">Size</th>
                </tr>
            </thead>
            <tbody id="orderDetailsBody">
                <!-- Product details will be inserted dynamically -->
            </tbody>
        </table>

        <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 mt-4 rounded">Close</button>
    </div>
</div>
<script>
    // Search Function
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // Export Table Data to CSV
    function exportTable() {
        let table = document.querySelector("table");
        let rows = Array.from(table.querySelectorAll("tr"));
        let csvContent = rows.map(row => 
            Array.from(row.cells).map(cell => `"${cell.innerText}"`).join(",")
        ).join("\n");

        let blob = new Blob([csvContent], { type: "text/csv" });
        let url = URL.createObjectURL(blob);
        let a = document.createElement("a");
        a.href = url;
        a.download = "orders.csv";
        a.click();
        URL.revokeObjectURL(url);
    }
</script>
<script>
function openModal(orderId) {
    fetch(`/admin/orders/${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            // Set order details in modal
            document.getElementById('modalOrderId').innerText = data.order_id;
            document.getElementById('modalCustomer').innerText = data.customer;
            document.getElementById('modalStatus').value = data.status;
            document.getElementById('modalDate').innerText = data.date;

            let tbody = document.getElementById('orderDetailsBody');
            tbody.innerHTML = '';

            // Populate items
            data.items.forEach(item => {
                let row = `<tr>
                    <td class="border border-gray-300 p-2">${item.product_name}</td>
                    <td class="border border-gray-300 p-2">${item.quantity}</td>
                    <td class="border border-gray-300 p-2">$${item.price}</td>
                    <td class="border border-gray-300 p-2">${item.size ?? 'N/A'}</td>
                </tr>`;
                tbody.innerHTML += row;
            });

            document.getElementById('orderModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching order details:', error);
            alert("Failed to fetch order details.");
        });
}

function updateStatus() {
    let orderId = document.getElementById('modalOrderId').textContent;
    let newStatus = document.getElementById('modalStatus').value;

    fetch(`/orders/${orderId}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            alert(data.message);
            closeModal();
            location.reload(); // Reload to reflect changes
        }
    })
    .catch(error => console.error('Error updating status:', error));
}


function closeModal() {
    document.getElementById('orderModal').classList.add('hidden');
}
</script>
@endsection

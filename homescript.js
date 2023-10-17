

// In javascript.js
function displayItemsFromInventory(items) {
    const itemsList = document.getElementById('items-list');
    itemsList.innerHTML = '';

    // Replace this with your logic to filter and display items based on the timestamp
    const presentTime = new Date();
    const filteredItems = items.filter(item => isItemRecent(item.timestamp, presentTime));

    // Display the filtered items in the items-list
    filteredItems.forEach(item => {
        const itemElement = document.createElement('div');
        itemElement.textContent = `Item: ${item.name} | Quantity: ${item.quantity}`;
        itemsList.appendChild(itemElement);
    });
}

// Helper function to check if an item's timestamp is recent
function isItemRecent(itemTimestamp, presentTime) {
    // Implement your logic here, e.g., compare timestamps within a certain time range
    return (presentTime - itemTimestamp) <= RECENT_TIME_RANGE;
}

// Call this function with the array of items from the Inventory Management page
displayItemsFromInventory(itemsFromInventory);

function displayInventoryInDashboard() {
    const dashboardItems = document.getElementById('dashboard-items');
    dashboardItems.innerHTML = '';

    inventory.forEach(item => {
        const itemRow = document.createElement('tr');
        itemRow.innerHTML = `
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${item.quantity}</td>
            <td>${item.price} THB</td>
            <td>${item.from}</td>
            <td>${item.date}</td>
            <td>${item.timestamp}</td>
            <td><button class="edit-btn" onclick="editItem(${item.id})">Edit</button></td>
            <td><button class="delete-btn" onclick="deleteItem(${item.id})">Delete</button></td>
        `;
        dashboardItems.appendChild(itemRow);
    });
}



document.addEventListener('DOMContentLoaded', function() {
    // ดึงข้อมูลจำนวนสินค้าที่ขายได้จากฐานข้อมูล
    fetch('get_sales_data.php') // เรียกไฟล์ PHP เพื่อดึงข้อมูลจากฐานข้อมูล
    .then(response => response.json())
    .then(data => {
        // ในกรณีนี้ data ควรจะเป็น JSON ที่มีข้อมูลขายสินค้า
        const labels = data.map(item => item.product_name);
        const sales = data.map(item => item.total_quantity);

        // สร้างกราฟ
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'จำนวนสินค้าที่ขายได้',
                    data: sales,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'จำนวนสินค้า'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'ชื่อสินค้า'
                        }
                    }
                }
            }
        });
    });
});


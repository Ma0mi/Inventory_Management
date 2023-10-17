
$(document).ready(function () {

  function updateDateTime() {
    const currentTimeElement = document.getElementById("current-time");
    const currentDateElement = document.getElementById("current-date");

    const now = new Date();

    const options = { hour: "numeric", minute: "numeric", second: "numeric", hour12: false };
    const timeString = now.toLocaleTimeString(undefined, options);

    const optionsDate = { year: "numeric", month: "long", day: "numeric" };
    const dateString = now.toLocaleDateString(undefined, optionsDate);

    currentTimeElement.textContent = timeString;
    currentDateElement.textContent = dateString;
  }

  updateDateTime(); // call the function initially
  setInterval(updateDateTime, 1000); // update every second

  //const itemForm = document.getElementById('item-form');
  const itemName = document.getElementById('item-name');
  const itemQuantity = document.getElementById('item-quantity');
  const itemPrice = document.getElementById('item-price');
  const itemFrom = document.getElementById('item-from');
  const itemDate = document.getElementById('item-date');
  const submitBtn = document.getElementById('submit-btn');
  const itemsContainer = document.getElementById('items-container');

  const itemForm = document.getElementById('item-form');
  // ... การประกาศตัวแปรอื่นๆ

  itemForm.addEventListener('submit', function (e) {
    e.preventDefault();

    if (submitBtn.textContent != 'Add Item') {
      return false
    }

    // ทำ FormData + ส่งข้อมูลไปยัง PHP
    const formData = new FormData();
    const id = new Date().getTime();

    formData.append('id', id);
    formData.append('name', itemName.value);
    formData.append('quantity', itemQuantity.value);
    formData.append('price', itemPrice.value);
    formData.append('from', itemFrom.value);
    formData.append('date', itemDate.value);

    const name = itemName.value;
    const quantity = parseInt(itemQuantity.value);
    const price = parseFloat(itemPrice.value);
    const from = itemFrom.value;
    const date = itemDate.value;
    const timestamp = new Date().toLocaleString();

    // ส่งคำขอ POST ไปยังสคริปต์ PHP

    $.ajax({
      type: "POST",
      url: "add_item.php",
      data: {
        item_id   : id,
        name      : itemName.value,
        quantity  : itemQuantity.value,
        price     : itemPrice.value,
        from      : itemFrom.value,
        date      :  itemDate.value,
      },
      dataType: "json",
      success: function (response) {
        console.log(response);
        inventory.push({ id, name, quantity, price, from, date, timestamp });

        displayInventory();
        itemForm.reset();
      }
    });

    // fetch('add_item.php', {
    //   method: 'POST',
    //   body: formData,
    // })

  });


  let inventory = [];

  itemForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const id = new Date().getTime();
    const name = itemName.value;
    const quantity = parseInt(itemQuantity.value);
    const price = parseFloat(itemPrice.value);
    const from = itemFrom.value;
    const date = itemDate.value;
    const timestamp = new Date().toLocaleString();

    if (submitBtn.textContent === 'Add Item') {
      // inventory.push({ id, name, quantity, price, from, date, timestamp });
    } else {
      const itemId = parseInt(document.getElementById('item-id').value);
      const itemIndex = inventory.findIndex(item => item.id === itemId);
      inventory[itemIndex] = { id: itemId, name, quantity, price, from, date, timestamp };
      submitBtn.textContent = 'Add Item';

      $.ajax({
        type: "POST",
        url: 'update_item.php',
        data: {
          item_id   : itemId,
          name      : itemName.value,
          quantity  : itemQuantity.value,
          price     : itemPrice.value,
          from      : itemFrom.value,
          date      :  itemDate.value,
        },
        dataType: "html",
        success: function (response) {
          console.log(response);
        }
      });

      // fetch('update_item.php', {
      //   method: 'POST',
      //   body: formData,
      // }).then(response => {
      //   console.log(response);
      // })
    }

    displayInventory();
    itemForm.reset();
  });

  function displayInventory() {

    itemsContainer.innerHTML = '';
    inventory.forEach(item => {
      const itemCard = document.createElement('div');
      itemCard.className = 'item-card';
    //   itemCard.innerHTML = `
    //     <p>ID: ${item.id}</p>
    //     <p>Name: ${item.name}</p>
    //     <p>Quantity: ${item.quantity}</p>
    //     <p>Price: ${item.price} THB</p>
    //     <p>From: ${item.from}</p>
    //     <p>Date: ${item.date}</p>
    //     <p>Timestamp: ${item.timestamp}</p>
    //     <button class="edit-btn" onclick="editItem(${item.id})">Edit</button>
    //     <button class="delete-btn" onclick="deleteItem(${item.id})">Delete</button>
    // `;
        itemCard.innerHTML = `
        <p>ID: ${item.id}</p>
        <p>Name: ${item.name}</p>
        <p>Quantity: ${item.quantity}</p>
        <p>Price: ${item.price} THB</p>
        <p>From: ${item.from}</p>
        <p>Date: ${item.date}</p>
        <p>Timestamp: ${item.timestamp}</p>
        <button class="edit-btn" data-id="${item.id}">Edit</button>
        <button class="delete-btn" data-id="${item.id}">Delete</button>
    `;
      itemsContainer.append(itemCard);
    });
  }
  $(document).on("click",".edit-btn",function(){
    let _id = $(this).data("id")
    editItem(_id)
  })
  $(document).on("click",".delete-btn",function(){
    let _id = $(this).data("id")
    deleteItem(_id)
  })


  function editItem(itemId) {
    const itemToEdit = inventory.find(item => item.id === itemId);
    itemName.value = itemToEdit.name;
    itemQuantity.value = itemToEdit.quantity;
    itemPrice.value = itemToEdit.price;
    itemFrom.value = itemToEdit.from;
    itemDate.value = itemToEdit.date;
    document.getElementById('item-id').value = itemToEdit.id;
    submitBtn.textContent = 'Update Item';
  }


  function deleteItem(itemId) {


    $.ajax({
      type: "POST",
      url: 'delete_item.php',
      data: {
        item_id   : itemId,
      },
      dataType: "json",
      success: function (response) {
        console.log(response);
        inventory = inventory.filter(item => item.id !== itemId);
        localStorage.setItem('inventory', JSON.stringify(inventory));
        displayInventory();
      }
    })
  }


  // Initial display
  displayInventory();

  // ... (existing code)

  // Load inventory data from local storage on page load
  document.addEventListener('DOMContentLoaded', function () {
    if (localStorage.getItem('inventory')) {
      inventory = JSON.parse(localStorage.getItem('inventory'));
      displayInventory();
    }
  });

  itemForm.addEventListener('submit', function (e) {
    e.preventDefault();

    // ... (existing code)

    localStorage.setItem('inventory', JSON.stringify(inventory));
    displayInventory();
    itemForm.reset();
  });


  // function deleteItem(itemId) {
  //   inventory = inventory.filter(item => item.id !== itemId);
  //   localStorage.setItem('inventory', JSON.stringify(inventory)); // Update local storage
  //   displayInventory();
  // }






  const modeToggle = document.getElementById('mode-toggle');
  const sunIcon = document.getElementById('sun-icon');
  const moonIcon = document.getElementById('moon-icon');

  modeToggle.addEventListener('change', function () {
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
      sunIcon.style.display = 'none';
      moonIcon.style.display = 'inline-block';
    } else {
      sunIcon.style.display = 'inline-block';
      moonIcon.style.display = 'none';
    }
  });

  // ... (rest of the script)


// Calculate and display the number of items in the table
function updateItemCount() {
  const table = document.querySelector('.menu-table');
  const itemCountElement = document.getElementById('item-count');

  if (table && itemCountElement) {
      const rowCount = table.tBodies[0].rows.length;
      itemCountElement.textContent = rowCount;
  }
}

// Call the function initially and after adding/deleting items
updateItemCount();

});

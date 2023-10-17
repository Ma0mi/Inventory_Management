const table = document.querySelector('table');
table.addEventListener('input', function(e) {
    if (e.target.nodeName === 'INPUT') {
        const input = e.target;
        const id = input.name.split('_')[2];
        const quantity = input.value;
        const price = parseFloat(input.parentElement.previousElementSibling.textContent);
        const subtotal = quantity * price;
        document.getElementById('subtotal_' + id).textContent = subtotal.toFixed(2);
        calculateTotal();
    }
});

function calculateTotal() {
    const subtotals = document.querySelectorAll('span[id^="subtotal_"]');
    let total = 0;
    subtotals.forEach(subtotal => {
        total += parseFloat(subtotal.textContent);
    });
    // แสดงราคารวมทั้งหมดไปยังอิลิเมนต์ที่คุณต้องการ
    // เช่น document.getElementById('total').textContent = total.toFixed(2);
}

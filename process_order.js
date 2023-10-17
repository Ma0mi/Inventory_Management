// redirect.js

// ตั้งเวลานับถอยหลังเริ่มต้น
var countDown = 5; // นับถอยหลังเป็น 5 วินาที
var countdownElement = document.getElementById('countdown');

function updateCountdown() {
    countdownElement.innerHTML = 'กำลังย้อนกลับไปหน้าทำรายการในอีก ' + countDown + ' วินาที';
}

function startCountdown() {
    updateCountdown();
    var countdownInterval = setInterval(function () {
        countDown--;
        updateCountdown();

        if (countDown <= 0) {
            clearInterval(countdownInterval);
            // เมื่อนับถอยหลังเสร็จสิ้น, รีไดเรกท์ไปยังหน้า order.php
            window.location.href = 'order.php';
        }
    }, 1000);
}

window.onload = startCountdown;

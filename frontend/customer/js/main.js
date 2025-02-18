// Hiển thị bản đồ với Leaflet.js
function initMap() {
    const map = L.map("map").setView([poolData.location.lat, poolData.location.lng], 15);

    // Thêm layer bản đồ
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors",
    }).addTo(map);

    // Thêm marker
    const marker = L.marker([poolData.location.lat, poolData.location.lng]).addTo(map);
    marker.bindPopup(`<b>${poolData.name}</b><br>Địa chỉ: ${poolData.address}`).openPopup();
}

// Xử lý gửi đánh giá
function handleFeedback() {
    const feedbackInput = document.getElementById("feedback");
    const feedbackText = feedbackInput.value.trim();

    if (feedbackText) {
        alert("Cảm ơn bạn đã gửi đánh giá!");
        feedbackInput.value = ""; // Xóa nội dung sau khi gửi
    } else {
        alert("Vui lòng nhập thông tin trước khi gửi.");
    }
}

// Gọi các hàm khi trang tải xong
document.addEventListener("DOMContentLoaded", () => {
    displayPoolInfo();
    initMap();

    // Thêm sự kiện cho nút gửi đánh giá
    const feedbackButton = document.querySelector("button");
    feedbackButton.addEventListener("click", handleFeedback);
});

// Xử lý khi form đăng ký sự kiện được gửi
document.getElementById("eventRegistrationForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Ngừng hành động mặc định của form (không reload trang)

    const name = document.getElementById("name").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const eventSelected = document.getElementById("event").value;

    // Kiểm tra nếu các trường được điền đúng
    if (name && phone && eventSelected) {
        alert("Cảm ơn bạn đã đăng ký tham gia sự kiện " + eventSelected + "!");
        // Làm sạch form sau khi gửi
        document.getElementById("eventRegistrationForm").reset();
    } else {
        alert("Vui lòng điền đầy đủ thông tin.");
    }
});
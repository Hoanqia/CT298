// Dữ liệu mẫu cho sự kiện
let events = [
  {
    name: "Hội thảo Công Nghệ 2025",
    poolName: "Hồ bơi Thành Phố",
    description: "Chia sẻ về công nghệ mới trong năm 2025.",
    poolType: "Hồ bơi ngoài trời",
    date: "2025-03-15",
    capacity: 100,
    fee: 500000,
  },
  {
    name: "Chạy marathon từ thiện",
    poolName: "Hồ bơi Quận 1",
    description: "Sự kiện thể thao từ thiện gây quỹ cho trẻ em nghèo.",
    poolType: "Hồ bơi công cộng",
    date: "2025-04-01",
    capacity: 500,
    fee: 200000,
  },
];

// Biến lưu trữ chỉ số sự kiện đang chỉnh sửa
let currentEditingIndex = -1;

// Hàm hiển thị danh sách sự kiện
function displayEvents() {
  const eventList = document.getElementById("eventList");
  eventList.innerHTML = "";

  events.forEach((event, index) => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${event.name}</td>
      <td>${event.poolName}</td>
      <td>${event.description}</td>
      <td>${event.poolType}</td>
      <td>${event.date}</td>
      <td>${event.capacity}</td>
      <td>${event.fee.toLocaleString()} VND</td>
      <td>
        <button class="btn btn-warning btn-sm" onclick="editEvent(${index})">Sửa</button>
        <button class="btn btn-danger btn-sm" onclick="deleteEvent(${index})">Xóa</button>
      </td>
    `;
    eventList.appendChild(row);
  });
}

// Mở modal để thêm sự kiện
const addEventBtn = document.getElementById("addEventBtn");
addEventBtn.addEventListener("click", function () {
  currentEditingIndex = -1; // Đặt về -1 để xác định thêm mới
  document.getElementById("addEventForm").reset();
  new bootstrap.Modal(document.getElementById("addEventModal")).show();
});

// Xử lý khi nhấn Lưu sự kiện
const addEventForm = document.getElementById("addEventForm");
addEventForm.addEventListener("submit", function (event) {
  event.preventDefault();

  // Lấy giá trị từ form
  const name = document.getElementById("eventName").value;
  const poolName = document.getElementById("poolName").value;
  const description = document.getElementById("eventDescription").value;
  const poolType = document.getElementById("poolType").value;
  const date = document.getElementById("eventDate").value;
  const capacity = document.getElementById("eventCapacity").value;
  const fee = document.getElementById("eventPrice").value;

  // Kiểm tra nếu là chỉnh sửa hay thêm mới
  if (currentEditingIndex === -1) {
    events.push({ name, poolName, description, poolType, date, capacity, fee: parseInt(fee) });
  } else {
    events[currentEditingIndex] = { name, poolName, description, poolType, date, capacity, fee: parseInt(fee) };
  }

  displayEvents();

  // Đóng modal sau khi lưu
  const modal = bootstrap.Modal.getInstance(document.getElementById("addEventModal"));
  modal.hide();

  // Reset form và chỉ số chỉnh sửa
  addEventForm.reset();
  currentEditingIndex = -1;
});

// Hàm chỉnh sửa sự kiện
function editEvent(index) {
  const event = events[index];
  currentEditingIndex = index;

  // Điền thông tin vào form
  document.getElementById("eventName").value = event.name;
  document.getElementById("poolName").value = event.poolName;
  document.getElementById("eventDescription").value = event.description;
  document.getElementById("poolType").value = event.poolType;
  document.getElementById("eventDate").value = event.date;
  document.getElementById("eventCapacity").value = event.capacity;
  document.getElementById("eventPrice").value = event.fee;

  // Mở modal sửa sự kiện
  new bootstrap.Modal(document.getElementById("addEventModal")).show();
}

// Hàm xóa sự kiện
function deleteEvent(index) {
  if (confirm("Bạn có chắc chắn muốn xóa sự kiện này?")) {
    events.splice(index, 1);
    displayEvents();
  }
}

// Tìm kiếm sự kiện theo tên
const searchEvent = document.getElementById("searchEvent");
searchEvent.addEventListener("input", function () {
  const searchTerm = this.value.toLowerCase();
  document.querySelectorAll("#eventList tr").forEach((row) => {
    row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? "" : "none";
  });
});

// Hiển thị danh sách sự kiện khi tải trang
displayEvents();

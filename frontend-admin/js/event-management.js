// Dữ liệu mẫu cho sự kiện
let events = [
  {
    name: "Hội thảo Công Nghệ 2025",
    description: "Chia sẻ về công nghệ mới trong năm 2025.",
    time: "2025-03-15T09:00",
    capacity: 100,
    fee: 500000,
  },
  {
    name: "Chạy marathon từ thiện",
    description: "Sự kiện thể thao từ thiện gây quỹ cho trẻ em nghèo.",
    time: "2025-04-01T06:30",
    capacity: 500,
    fee: 200000,
  },
  {
    name: "Lễ hội âm nhạc mùa hè",
    description: "Lễ hội âm nhạc lớn nhất năm với các ca sĩ nổi tiếng.",
    time: "2025-06-10T18:00",
    capacity: 2000,
    fee: 100000,
  },
];

// Biến lưu trữ chỉ số sự kiện đang chỉnh sửa
let currentEditingIndex = -1;

// Hàm để hiển thị danh sách sự kiện trong bảng
function displayEvents() {
  const eventList = document.getElementById('eventList');
  eventList.innerHTML = ''; // Xóa nội dung cũ trong bảng

  events.forEach((event, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${event.name}</td>
      <td>${event.description}</td>
      <td>${new Date(event.time).toLocaleString()}</td>
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

// Hàm để mở modal thêm sự kiện
document.getElementById('addEventBtn').addEventListener('click', function() {
  // Mở modal
  new bootstrap.Modal(document.getElementById('addEventModal')).show();
  // Đặt lại trạng thái để thêm sự kiện mới
  currentEditingIndex = -1;
  document.getElementById('addEventForm').reset();
});

// Hàm để thêm sự kiện mới hoặc sửa sự kiện
document.getElementById('addEventForm').addEventListener('submit', function(event) {
  event.preventDefault();

  const name = document.getElementById('eventName').value;
  const description = document.getElementById('eventDescription').value;
  const time = document.getElementById('eventTime').value;
  const capacity = document.getElementById('eventCapacity').value;
  const fee = document.getElementById('eventFee').value;

  // Kiểm tra nếu là sự kiện mới hay chỉnh sửa
  if (currentEditingIndex === -1) {
    // Thêm sự kiện mới
    events.push({
      name,
      description,
      time,
      capacity,
      fee: parseInt(fee),
    });
  } else {
    // Cập nhật sự kiện đã chọn
    events[currentEditingIndex] = {
      name,
      description,
      time,
      capacity,
      fee: parseInt(fee),
    };
  }

  // Hiển thị lại danh sách sự kiện
  displayEvents();

  // Đóng modal
  const modal = bootstrap.Modal.getInstance(document.getElementById('addEventModal'));
  modal.hide();

  // Reset form và chỉ số chỉnh sửa
  document.getElementById('addEventForm').reset();
  currentEditingIndex = -1; // Reset chỉ số chỉnh sửa
});

// Hàm để chỉnh sửa sự kiện
function editEvent(index) {
  const event = events[index];
  currentEditingIndex = index; // Lưu chỉ số của sự kiện đang chỉnh sửa

  // Điền dữ liệu vào các trường trong form sửa
  document.getElementById('eventName').value = event.name;
  document.getElementById('eventDescription').value = event.description;
  document.getElementById('eventTime').value = event.time;
  document.getElementById('eventCapacity').value = event.capacity;
  document.getElementById('eventFee').value = event.fee;

  // Mở modal
  const modal = new bootstrap.Modal(document.getElementById('addEventModal'));
  modal.show();
}

// Hàm để xóa sự kiện
function deleteEvent(index) {
  // Xác nhận xóa
  if (confirm('Bạn có chắc chắn muốn xóa sự kiện này?')) {
    // Xóa sự kiện khỏi mảng
    events.splice(index, 1);
    // Hiển thị lại danh sách sự kiện
    displayEvents();
  }
}

 // Tìm kiếm đánh giá
 document.getElementById("searchEvent").addEventListener("input", function () {
  const searchTerm = this.value.toLowerCase();
  document.querySelectorAll("#eventList tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? "" : "none";
  });
});

// Hiển thị danh sách sự kiện khi tải trang
displayEvents();

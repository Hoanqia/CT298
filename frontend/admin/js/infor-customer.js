// Dữ liệu mẫu cho khách hàng
let customers = [
  {
    name: "Nguyễn Văn A",
    phone: "0901234567",
    password: "password123",
  },
  {
    name: "Trần Thị B",
    phone: "0912345678",
    password: "password456",
  },
  {
    name: "Lê Minh C",
    phone: "0923456789",
    password: "password789",
  },
  {
    name: "Phan Hoàng D",
    phone: "0934567890",
    password: "password101",
  }
];

// Hàm để hiển thị danh sách khách hàng trong bảng
function displayCustomers() {
  const customerList = document.getElementById('customerList');
  customerList.innerHTML = ''; // Xóa nội dung cũ trong bảng

  customers.forEach((customer, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${customer.name}</td>
      <td>${customer.phone}</td>
      <td>${customer.password}</td>
\      <td>
        <button class="btn btn-warning btn-sm" onclick="editCustomer(${index})">Sửa</button>
        <button class="btn btn-danger btn-sm" onclick="deleteCustomer(${index})">Xóa</button>
      </td>
    `;
    customerList.appendChild(row);
  });
}

// Hàm để mở modal thêm khách hàng
document.getElementById('addCustomerBtn').addEventListener('click', function() {
  // Mở modal
  new bootstrap.Modal(document.getElementById('addCustomerModal')).show();
});

// Hàm để thêm khách hàng mới
document.getElementById('addCustomerForm').addEventListener('submit', function(event) {
  event.preventDefault();

  const name = document.getElementById('customerName').value;
  const phone = document.getElementById('customerPhone').value;
  const password = document.getElementById('customerPassword').value;

  // Thêm khách hàng vào mảng
  customers.push({
    name,
    phone,
    password,
    registrationDate
  });

  // Hiển thị lại danh sách khách hàng
  displayCustomers();

  // Đóng modal
  new bootstrap.Modal(document.getElementById('addCustomerModal')).hide();

  // Xóa dữ liệu trong form
  document.getElementById('addCustomerForm').reset();
});

// Hàm để chỉnh sửa khách hàng
function editCustomer(index) {
  const customer = customers[index];

  // Điền dữ liệu vào các trường trong form sửa
  document.getElementById('customerName').value = customer.name;
  document.getElementById('customerPhone').value = customer.phone;
  document.getElementById('customerPassword').value = customer.password;

  // Thay đổi hành động của form thành cập nhật
  const addCustomerForm = document.getElementById('addCustomerForm');
  addCustomerForm.onsubmit = function(event) {
    event.preventDefault();

    // Cập nhật thông tin khách hàng
    customer.name = document.getElementById('customerName').value;
    customer.phone = document.getElementById('customerPhone').value;
    customer.password = document.getElementById('customerPassword').value;

    // Hiển thị lại danh sách khách hàng
    displayCustomers();

    // Đóng modal
    new bootstrap.Modal(document.getElementById('addCustomerModal')).hide();

    // Xóa dữ liệu trong form
    addCustomerForm.reset();
  };

  // Mở modal
  new bootstrap.Modal(document.getElementById('addCustomerModal')).show();
}

// Hàm để xóa khách hàng
function deleteCustomer(index) {
  // Xác nhận xóa
  if (confirm('Bạn có chắc chắn muốn xóa khách hàng này?')) {
    // Xóa khách hàng khỏi mảng
    customers.splice(index, 1);
    // Hiển thị lại danh sách khách hàng
    displayCustomers();
  }
}

// Tìm kiếm đánh giá
document.getElementById("searchInfor").addEventListener("input", function () {
  const searchTerm = this.value.toLowerCase();
  document.querySelectorAll("#customerList tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? "" : "none";
  });
});

// Hiển thị danh sách khách hàng khi tải trang
displayCustomers();

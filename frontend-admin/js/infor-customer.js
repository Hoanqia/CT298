// Dữ liệu mẫu cho khách hàng
let customers = [
  {
    name: "Nguyễn Văn A",
    phone: "0901234567",
    password: "password123",
    registrationDate: "2025-02-17"
  },
  {
    name: "Trần Thị B",
    phone: "0912345678",
    password: "password456",
    registrationDate: "2025-01-25"
  },
  {
    name: "Lê Minh C",
    phone: "0923456789",
    password: "password789",
    registrationDate: "2024-12-15"
  },
  {
    name: "Phan Hoàng D",
    phone: "0934567890",
    password: "password101",
    registrationDate: "2024-11-30"
  }
];

// Hàm hiển thị danh sách khách hàng
function displayCustomers() {
  const customerList = document.getElementById('customerList');
  customerList.innerHTML = '';

  customers.forEach((customer, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${customer.name}</td>
      <td>${customer.phone}</td>
      <td>${customer.password}</td>
      <td>${customer.registrationDate}</td>
    `;
    customerList.appendChild(row);
  });
}

// Hàm tìm kiếm khách hàng theo tên hoặc số điện thoại
document.getElementById("searchInfor").addEventListener("input", function () {
  const searchTerm = this.value.toLowerCase();
  document.querySelectorAll("#customerList tr").forEach(row => {
    const name = row.cells[1].textContent.toLowerCase();
    const phone = row.cells[2].textContent.toLowerCase();
    row.style.display = (name.includes(searchTerm) || phone.includes(searchTerm)) ? "" : "none";
  });
});

// Hiển thị danh sách khách hàng khi tải trang
displayCustomers();

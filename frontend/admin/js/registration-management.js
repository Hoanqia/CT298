// Dữ liệu mẫu cho phiếu đăng ký
const registrations = [
    {
      userName: 'Nguyễn Văn A',
      eventName: 'Cuộc thi bơi 100m',
      registrationDate: '2025-02-15',
      status: 'Đã Xác Nhận',
    },
    {
      userName: 'Nguyễn Văn B',
      eventName: 'Cuộc thi bơi 120m',
      registrationDate: '2025-02-18',
      status: 'Đã Xác Nhận',
    },
  ];
  
  // Hiển thị danh sách phiếu đăng ký
  function renderRegistrationList() {
    const registrationListContainer = document.getElementById('registrationList');
    registrationListContainer.innerHTML = ''; // Xóa dữ liệu cũ
  
    registrations.forEach((registration, index) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${registration.userName}</td>
        <td>${registration.eventName}</td>
        <td>${registration.registrationDate}</td>
        <td>${registration.status}</td>
        <td>
          <button class="btn btn-warning btn-sm" onclick="editRegistration(${index})">Sửa</button>
          <button class="btn btn-danger btn-sm" onclick="deleteRegistration(${index})">Xóa</button>
        </td>
      `;
      registrationListContainer.appendChild(row);
    });
  }
  
  // Thêm phiếu đăng ký
  function addRegistration(registration) {
    registrations.push(registration);
    renderRegistrationList();
  }
  
  // Sửa phiếu đăng ký
  function editRegistration(index) {
    const registration = registrations[index];
    document.getElementById('userName').value = registration.userName;
    document.getElementById('eventName').value = registration.eventName;
    document.getElementById('registrationDate').value = registration.registrationDate;
    document.getElementById('status').value = registration.status;
  
    // Cập nhật phiếu đăng ký
    const form = document.getElementById('addRegistrationForm');
    form.onsubmit = function(eventSubmit) {
      eventSubmit.preventDefault();
      registrations[index] = {
        userName: document.getElementById('userName').value,
        eventName: document.getElementById('eventName').value,
        registrationDate: document.getElementById('registrationDate').value,
        status: document.getElementById('status').value,
      };
      renderRegistrationList();
      $('#addRegistrationModal').modal('hide');
    };
  
    $('#addRegistrationModal').modal('show');
  }
  
  // Xóa phiếu đăng ký
  function deleteRegistration(index) {
    registrations.splice(index, 1);
    renderRegistrationList();
  }
  
  // Thêm phiếu đăng ký mới
  document.getElementById('addRegistrationBtn').addEventListener('click', () => {
    const form = document.getElementById('addRegistrationForm');
    form.onsubmit = function(eventSubmit) {
      eventSubmit.preventDefault();
      const newRegistration = {
        userName: document.getElementById('userName').value,
        eventName: document.getElementById('eventName').value,
        registrationDate: document.getElementById('registrationDate').value,
        status: document.getElementById('status').value,
      };
      addRegistration(newRegistration);
      form.reset();
      $('#addRegistrationModal').modal('hide');
    };
    $('#addRegistrationModal').modal('show');
  });
    // Tìm kiếm phiếu đăng ký
  document.getElementById("searchRegistration").addEventListener("input", function () {
  const searchTerm = this.value.toLowerCase();
  document.querySelectorAll("#registrationList tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? "" : "none";
    });
  });
  
  // Render lần đầu
  renderRegistrationList();

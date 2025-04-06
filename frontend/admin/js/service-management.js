// Dữ liệu mẫu cho dịch vụ
const services = [
    {
      name: 'Cho thuê đồ bơi',
      price: 20000,
    },
    {
      name: 'Dịch vụ huấn luyện viên',
      price: 50000,
    },
  ];
  
  // Hiển thị danh sách dịch vụ
  function renderServiceList() {
    const serviceListContainer = document.getElementById('serviceList');
    serviceListContainer.innerHTML = ''; // Xóa dữ liệu cũ
  
    services.forEach((service, index) => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${service.name}</td>
        <td>${service.price} VND</td>
        <td>
          <button class="btn btn-warning btn-sm" onclick="editService(${index})">Sửa</button>
          <button class="btn btn-danger btn-sm" onclick="deleteService(${index})">Xóa</button>
        </td>
      `;
      serviceListContainer.appendChild(row);
    });
  }
  
  // Thêm dịch vụ
  function addService(service) {
    services.push(service);
    renderServiceList();
  }
  
  // Sửa dịch vụ
  function editService(index) {
    const service = services[index];
    document.getElementById('serviceName').value = service.name;
    document.getElementById('servicePrice').value = service.price;
  
    // Cập nhật dịch vụ
    const form = document.getElementById('addServiceForm');
    form.onsubmit = function(event) {
      event.preventDefault();
      services[index] = {
        name: document.getElementById('serviceName').value,
        price: document.getElementById('servicePrice').value,
      };
      renderServiceList();
      $('#addServiceModal').modal('hide');
    };
  
    $('#addServiceModal').modal('show');
  }
  
  // Xóa dịch vụ
  function deleteService(index) {
    services.splice(index, 1);
    renderServiceList();
  }
  
  // Thêm dịch vụ mới
  document.getElementById('addServiceBtn').addEventListener('click', () => {
    const form = document.getElementById('addServiceForm');
    form.onsubmit = function(event) {
      event.preventDefault();
      const newService = {
        name: document.getElementById('serviceName').value,
        price: document.getElementById('servicePrice').value,
      };
      addService(newService);
      form.reset();
      $('#addServiceModal').modal('hide');
    };
    $('#addServiceModal').modal('show');
  });

  // Tìm kiếm dịch vụ
  document.getElementById("searchService").addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll("#serviceList tr").forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? "" : "none";
    });
  });
  
  // Render lần đầu
  renderServiceList();
  
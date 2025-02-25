// Dữ liệu mẫu tiện ích
let facilities = [
    { poolName: "Hồ bơi Thành Phố", facilityName: "Ghế tắm nắng" },
    { poolName: "Hồ bơi Quận 1", facilityName: "Phòng thay đồ" },
  ];
  
  // Biến lưu trữ chỉ số tiện ích đang chỉnh sửa
  let currentEditingIndex = -1;
  
  // Hàm hiển thị danh sách tiện ích
  function displayFacilities() {
    const facilityList = document.getElementById("facilityList");
    facilityList.innerHTML = "";
  
    facilities.forEach((facility, index) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${facility.poolName}</td>
        <td>${facility.facilityName}</td>
        <td>
          <button class="btn btn-warning btn-sm" onclick="editFacility(${index})">Sửa</button>
          <button class="btn btn-danger btn-sm" onclick="deleteFacility(${index})">Xóa</button>
        </td>
      `;
      facilityList.appendChild(row);
    });
  }
  
  // Xử lý khi nhấn Thêm tiện ích
  document.getElementById("addFacilityBtn").addEventListener("click", function () {
    currentEditingIndex = -1; // Xác định thêm mới
    document.getElementById("addFacilityForm").reset();
    new bootstrap.Modal(document.getElementById("addFacilityModal")).show();
  });
  
  // Xử lý khi nhấn Lưu trong modal
  document.getElementById("addFacilityForm").addEventListener("submit", function (event) {
    event.preventDefault();
  
    // Lấy giá trị từ form
    const poolName = document.getElementById("poolName").value;
    const facilityName = document.getElementById("facilityName").value;
  
    // Kiểm tra nếu là chỉnh sửa hay thêm mới
    if (currentEditingIndex === -1) {
      facilities.push({ poolName, facilityName });
    } else {
      facilities[currentEditingIndex] = { poolName, facilityName };
    }
  
    displayFacilities();
  
    // Đóng modal sau khi lưu
    const modal = bootstrap.Modal.getInstance(document.getElementById("addFacilityModal"));
    modal.hide();
  
    // Reset form và chỉ số chỉnh sửa
    document.getElementById("addFacilityForm").reset();
    currentEditingIndex = -1;
  });
  
  // Hàm chỉnh sửa tiện ích
  function editFacility(index) {
    const facility = facilities[index];
    currentEditingIndex = index;
  
    // Điền thông tin vào form
    document.getElementById("poolName").value = facility.poolName;
    document.getElementById("facilityName").value = facility.facilityName;
  
    // Mở modal chỉnh sửa
    new bootstrap.Modal(document.getElementById("addFacilityModal")).show();
  }
  
  // Hàm xóa tiện ích
  function deleteFacility(index) {
    if (confirm("Bạn có chắc chắn muốn xóa tiện ích này?")) {
      facilities.splice(index, 1);
      displayFacilities();
    }
  }
  
  // Tìm kiếm tiện ích theo tên
  document.getElementById("searchFacility").addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll("#facilityList tr").forEach((row) => {
      row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? "" : "none";
    });
  });
  
  // Hiển thị danh sách tiện ích khi tải trang
  displayFacilities();
  

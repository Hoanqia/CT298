document.addEventListener("DOMContentLoaded", function () {
  let facilities = [
      { name: "Hồ bơi", status: "Hoạt động" },
      { name: "Phòng Gym", status: "Bảo trì" },
      { name: "Sân Tennis", status: "Hoạt động" }
  ];

  const facilityList = document.getElementById("facilityList");
  const addFacilityForm = document.getElementById("addFacilityForm");
  const searchFacility = document.getElementById("searchFacility");
  
  function renderFacilities() {
      facilityList.innerHTML = "";
      facilities.forEach((facility, index) => {
          facilityList.innerHTML += `
              <tr>
                  <td>${index + 1}</td>
                  <td>${facility.name}</td>
                  <td>${facility.status}</td>
                  <td>
                      <button class="btn btn-warning btn-sm" onclick="editFacility(${index})">Sửa</button>
                      <button class="btn btn-info btn-sm" onclick="changeStatus(${index})">Đổi Trạng Thái</button>
                      <button class="btn btn-danger btn-sm" onclick="deleteFacility(${index})">Xóa</button>
                  </td>
              </tr>
          `;
      });
  }
  
  window.editFacility = function (index) {
      const newName = prompt("Nhập tên mới:", facilities[index].name);
      if (newName) {
          facilities[index].name = newName;
          renderFacilities();
      }
  }
  
  window.changeStatus = function (index) {
      facilities[index].status = facilities[index].status === "Hoạt động" ? "Bảo trì" : "Hoạt động";
      renderFacilities();
  }
  
  window.deleteFacility = function (index) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
          facilities.splice(index, 1);
          renderFacilities();
      }
  }
  
  addFacilityForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const name = document.getElementById("facilityName").value;
      const status = document.getElementById("facilityStatus").value;
      facilities.push({ name, status });
      renderFacilities();
      addFacilityForm.reset();
      $("#addFacilityModal").modal("hide");
  });
  
  searchFacility.addEventListener("input", function () {
      const searchText = searchFacility.value.toLowerCase();
      facilityList.innerHTML = "";
      facilities.filter(facility => facility.name.toLowerCase().includes(searchText))
          .forEach((facility, index) => {
              facilityList.innerHTML += `
                  <tr>
                      <td>${facility.name}</td>
                      <td>${facility.status}</td>
                      <td>
                          <button class="btn btn-warning btn-sm" onclick="editFacility(${index})">Sửa</button>
                          <button class="btn btn-info btn-sm" onclick="changeStatus(${index})">Đổi Trạng Thái</button>
                          <button class="btn btn-danger btn-sm" onclick="deleteFacility(${index})">Xóa</button>
                      </td>
                  </tr>
              `;
          });
  });
  
  renderFacilities();
});

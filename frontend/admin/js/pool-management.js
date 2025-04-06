// Dữ liệu mẫu cho hồ bơi
const pools = [
  {
    name: 'Hồ Bơi A',
    address: 'Số 1 Đường ABC, Quận 1',
    length: 50, // Chiều dài hồ bơi
    width: 20, // Chiều rộng hồ bơi
    depth: 2, // Độ sâu hồ bơi
    openingTime: '06:00', // Giờ mở cửa
    closingTime: '18:00', // Giờ đóng cửa
    image: 'img/hoboi1.jpg', // Hình ảnh hồ bơi
    childFee: 20000, // Giá trẻ em
    adultFee: 50000, // Giá người lớn
  },
  {
    name: 'Hồ Bơi B',
    address: 'Số 2 Đường XYZ, Quận 2',
    length: 40,
    width: 18,
    depth: 1.5,
    openingTime: '07:00',
    closingTime: '19:00',
    image: 'img/hoboi2.jpg',
    childFee: 15000,
    adultFee: 40000,
  },
];

// Hiển thị danh sách hồ bơi
function renderPoolList() {
  const poolListContainer = document.getElementById('poolList');
  poolListContainer.innerHTML = ''; // Xóa dữ liệu cũ

  pools.forEach((pool, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${pool.name}</td>
      <td>${pool.address}</td>
      <td>${pool.length} m</td>
      <td>${pool.width} m</td>
      <td>${pool.depth} m</td>
      <td>${pool.openingTime}</td>
      <td>${pool.closingTime}</td>
      <td><img src="${pool.image}" alt="Pool Image" width="100"></td>
      <td>${pool.childFee} VND</td>
      <td>${pool.adultFee} VND</td>
      <td>
        <button class="btn btn-warning btn-sm" onclick="editPool(${index})">Sửa</button>
        <button class="btn btn-danger btn-sm" onclick="deletePool(${index})">Xóa</button>
      </td>
    `;
    poolListContainer.appendChild(row);
  });
}

// Thêm hồ bơi
function addPool(pool) {
  pools.push(pool);
  renderPoolList();
}

// Sửa hồ bơi
function editPool(index) {
  const pool = pools[index];
  document.getElementById('poolName').value = pool.name;
  document.getElementById('poolAddress').value = pool.address;
  document.getElementById('poolLength').value = pool.length;
  document.getElementById('poolWidth').value = pool.width;
  document.getElementById('poolDepth').value = pool.depth;
  document.getElementById('poolOpeningTime').value = pool.openingTime;
  document.getElementById('poolClosingTime').value = pool.closingTime;
  document.getElementById('poolChildFee').value = pool.childFee;
  document.getElementById('poolAdultFee').value = pool.adultFee;

  // Cập nhật hồ bơi
  const form = document.getElementById('addPoolForm');
  form.onsubmit = function(event) {
    event.preventDefault();
    pools[index] = {
      name: document.getElementById('poolName').value,
      address: document.getElementById('poolAddress').value,
      length: document.getElementById('poolLength').value,
      width: document.getElementById('poolWidth').value,
      depth: document.getElementById('poolDepth').value,
      openingTime: document.getElementById('poolOpeningTime').value,
      closingTime: document.getElementById('poolClosingTime').value,
      image: document.getElementById('poolImage').files[0] ? URL.createObjectURL(document.getElementById('poolImage').files[0]) : pool.image,
      childFee: document.getElementById('poolChildFee').value,
      adultFee: document.getElementById('poolAdultFee').value,
    };
    renderPoolList();
    $('#addPoolModal').modal('hide');
  };

  $('#addPoolModal').modal('show');
}

// Xóa hồ bơi
function deletePool(index) {
  pools.splice(index, 1);
  renderPoolList();
}

// Thêm hồ bơi mới
document.getElementById('addPoolBtn').addEventListener('click', () => {
  const form = document.getElementById('addPoolForm');
  form.onsubmit = function(event) {
    event.preventDefault();
    const newPool = {
      name: document.getElementById('poolName').value,
      address: document.getElementById('poolAddress').value,
      length: document.getElementById('poolLength').value,
      width: document.getElementById('poolWidth').value,
      depth: document.getElementById('poolDepth').value,
      openingTime: document.getElementById('poolOpeningTime').value,
      closingTime: document.getElementById('poolClosingTime').value,
      image: document.getElementById('poolImage').files[0] ? URL.createObjectURL(document.getElementById('poolImage').files[0]) : '',
      childFee: document.getElementById('poolChildFee').value,
      adultFee: document.getElementById('poolAdultFee').value,
    };
    addPool(newPool);
    form.reset();
    $('#addPoolModal').modal('hide');
  };
  $('#addPoolModal').modal('show');
});

// Tìm kiếm hồ bơi
document.getElementById("searchPool").addEventListener("input", function () {
  const searchTerm = this.value.toLowerCase();
  document.querySelectorAll("#poolList tr").forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? "" : "none";
  });
});

// Render lần đầu
renderPoolList();

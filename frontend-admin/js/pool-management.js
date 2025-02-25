// Dữ liệu mẫu cho hồ bơi
const pools = [
  {
    name: 'Hồ Bơi A',
    houseNumber: 'Số 1',
    address: 'Đường ABC, Quận 1',
    city: 'TP.HCM',
    latitude: 10.7769,
    longitude: 106.7009,
    length: 50,
    width: 20,
    depth: 2,
    type: 'Trong Nhà',
    openingTime: '06:00',
    closingTime: '18:00',
    image: 'img/hoboi1.jpg',
    childFee: 20000,
    studentFee: 35000,
    adultFee: 50000,
  },
  {
    name: 'Hồ Bơi B',
    houseNumber: 'Số 2',
    address: 'Đường XYZ, Quận 2',
    city: 'TP.HCM',
    latitude: 10.7800,
    longitude: 106.7050,
    length: 40,
    width: 18,
    depth: 1.5,
    type: 'Ngoài Trời',
    openingTime: '07:00',
    closingTime: '19:00',
    image: 'img/hoboi2.jpg',
    childFee: 15000,
    studentFee: 30000,
    adultFee: 40000,
  },
];

// Hiển thị danh sách hồ bơi
function renderPoolList() {
  const poolListContainer = document.getElementById('poolList');
  poolListContainer.innerHTML = '';

  pools.forEach((pool, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${pool.name}</td>
      <td>${pool.houseNumber}</td>
      <td>${pool.address}</td>
      <td>${pool.city}</td>
      <td>${pool.latitude}</td>
      <td>${pool.longitude}</td>
      <td>${pool.length} m</td>
      <td>${pool.width} m</td>
      <td>${pool.depth} m</td>
      <td>${pool.type}</td>
      <td>${pool.openingTime}</td>
      <td>${pool.closingTime}</td>
      <td><img src="${pool.image}" alt="Pool Image" width="100"></td>
      <td>${pool.childFee} VND</td>
      <td>${pool.studentFee} VND</td>
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
  document.getElementById('poolHouseNumber').value = pool.houseNumber;
  document.getElementById('poolAddress').value = pool.address;
  document.getElementById('poolCity').value = pool.city;
  document.getElementById('poolLatitude').value = pool.latitude;
  document.getElementById('poolLongitude').value = pool.longitude;
  document.getElementById('poolLength').value = pool.length;
  document.getElementById('poolWidth').value = pool.width;
  document.getElementById('poolDepth').value = pool.depth;
  document.getElementById('poolType').value = pool.type;
  document.getElementById('poolOpeningTime').value = pool.openingTime;
  document.getElementById('poolClosingTime').value = pool.closingTime;
  document.getElementById('poolChildFee').value = pool.childFee;
  document.getElementById('poolStudentFee').value = pool.studentFee;
  document.getElementById('poolAdultFee').value = pool.adultFee;

  const form = document.getElementById('addPoolForm');
  form.onsubmit = function(event) {
    event.preventDefault();
    pools[index] = {
      name: document.getElementById('poolName').value,
      houseNumber: document.getElementById('poolHouseNumber').value,
      address: document.getElementById('poolAddress').value,
      city: document.getElementById('poolCity').value,
      latitude: parseFloat(document.getElementById('poolLatitude').value),
      longitude: parseFloat(document.getElementById('poolLongitude').value),
      length: parseFloat(document.getElementById('poolLength').value),
      width: parseFloat(document.getElementById('poolWidth').value),
      depth: parseFloat(document.getElementById('poolDepth').value),
      type: document.getElementById('poolType').value,
      openingTime: document.getElementById('poolOpeningTime').value,
      closingTime: document.getElementById('poolClosingTime').value,
      image: document.getElementById('poolImage').files[0] ? URL.createObjectURL(document.getElementById('poolImage').files[0]) : pool.image,
      childFee: parseInt(document.getElementById('poolChildFee').value),
      studentFee: parseInt(document.getElementById('poolStudentFee').value),
      adultFee: parseInt(document.getElementById('poolAdultFee').value),
    };
    renderPoolList();
    $('#addPoolModal').modal('hide');
  };

  $('#addPoolModal').modal('show');
}

// Xóa hồ bơi
function deletePool(index) {
  if (confirm('Bạn có chắc muốn xóa hồ bơi này?')) {
    pools.splice(index, 1);
    renderPoolList();
  }
}

// Thêm hồ bơi mới
document.getElementById('addPoolBtn').addEventListener('click', () => {
  const form = document.getElementById('addPoolForm');
  form.onsubmit = function(event) {
    event.preventDefault();
    const newPool = {
      name: document.getElementById('poolName').value,
      houseNumber: document.getElementById('poolHouseNumber').value,
      address: document.getElementById('poolAddress').value,
      city: document.getElementById('poolCity').value,
      latitude: parseFloat(document.getElementById('poolLatitude').value),
      longitude: parseFloat(document.getElementById('poolLongitude').value),
      length: parseFloat(document.getElementById('poolLength').value),
      width: parseFloat(document.getElementById('poolWidth').value),
      depth: parseFloat(document.getElementById('poolDepth').value),
      type: document.getElementById('poolType').value,
      openingTime: document.getElementById('poolOpeningTime').value,
      closingTime: document.getElementById('poolClosingTime').value,
      image: document.getElementById('poolImage').files[0] ? URL.createObjectURL(document.getElementById('poolImage').files[0]) : '',
      childFee: parseInt(document.getElementById('poolChildFee').value),
      studentFee: parseInt(document.getElementById('poolStudentFee').value),
      adultFee: parseInt(document.getElementById('poolAdultFee').value),
    };
    addPool(newPool);
    form.reset();
    $('#addPoolModal').modal('hide');
  };

  $('#addPoolModal').modal('show');
});

// Render lần đầu
renderPoolList();

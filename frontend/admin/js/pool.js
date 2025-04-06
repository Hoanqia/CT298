document.addEventListener("DOMContentLoaded", function () {
    fetchPools();
});

function fetchPools() {
    fetch("http://127.0.0.1:8000/api/pools")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                renderPools(data.data);
            } else {
                console.error("Lỗi khi lấy danh sách hồ bơi:", data.message);
            }
        })
        .catch(error => console.error("Lỗi kết nối API:", error));
}
async function updatedPool(poolId,formData) {
    const token = localStorage.getItem('authToken');
    if(!token){
        alert('Bạn cần đăng nhập trước!');
        return;
    }
    try {
        const response = await fetch('http://localhost:8000/api/pools/${poolId}',{
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'},
            body: formData
        });
        const result = await response.json();
        if(response.ok){
            alert('✅ Sửa thông tin hồ bơi thành công');
            console.log(result.data);
            document.getElementById('editPoolForm').reset();
            const modalElement = document.getElementById('editPoolModal');  // Đảm bảo modal có id là 'addPoolModal'
            const modal = new bootstrap.Modal(modalElement);
            modal.hide();  // Đóng modal
        } else {
              // Nếu có lỗi từ server, hiển thị thông điệp lỗi
              alert('❌ Lỗi: ' + (result.message || 'Đã xảy ra lỗi từ server'));
              console.error(result);
        }
    }catch(error){
        alert('❌ Có lỗi xảy ra khi kết nối tới server');
        console.error(error);
    }
}

document.getElementById('editPoolForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    updatePool(formData);
});

// Hàm gửi dữ liệu hồ bơi lên server
async function createPool(formData) {
    const token = localStorage.getItem('authToken');

    if (!token) {
        alert('Bạn cần đăng nhập trước!');
        return;
    }

    try {
        const response = await fetch('http://localhost:8000/api/pools/create', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json' },
            body: formData
        });

        const result = await response.json();
        if (response.ok) {
            alert('✅ Thêm hồ bơi thành công');
            console.log(result.data);  // Hiển thị thông tin hồ bơi được tạo
            // Optional: reset form
            document.getElementById('addPoolForm').reset();
            const modalElement = document.getElementById('addPoolModal');  // Đảm bảo modal có id là 'addPoolModal'
            const modal = new bootstrap.Modal(modalElement);
            modal.hide();  // Đóng modal
        } else {
            // Nếu có lỗi từ server, hiển thị thông điệp lỗi
            alert('❌ Lỗi: ' + (result.message || 'Đã xảy ra lỗi từ server'));
            console.error(result);
        }
    } catch (error) {
        alert('❌ Có lỗi xảy ra khi kết nối tới server');
        console.error(error);
    }
}

// Bắt sự kiện submit form
document.getElementById('addPoolForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    createPool(formData);
});

async function deletePool(poolId) {
    const token = localStorage.getItem('authToken');

    if (!token) {
        alert('Bạn cần đăng nhập trước!');
        return;
    }

    if (!poolId) {
        alert('ID hồ bơi không hợp lệ!');
        return;
    }

    try {
        const response = await fetch(`http://localhost:8000/api/pools/${poolId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();
        if (response.ok) {
            alert('✅ Xóa hồ bơi thành công');
            console.log(result);  
            fetchPools();
            // Hiển thị thông tin kết quả xóa hồ bơi
            // Optional: Cập nhật giao diện nếu cần (ví dụ: xóa hồ bơi khỏi danh sách)
            // Có thể gọi lại hàm để cập nhật danh sách hồ bơi
        } else {
            // Nếu có lỗi từ server, hiển thị thông điệp lỗi
            alert('❌ Lỗi: ' + (result.message || 'Đã xảy ra lỗi từ server'));
            console.error(result);
        }
    } catch (error) {
        alert('❌ Có lỗi xảy ra khi kết nối tới server');
        console.error(error);
    }
}



 // --- Hàm lấy dữ liệu từ API rồi gọi modal ---
 function fetchAndOpenEditModal(poolId) {
    const apiUrl = `http://127.0.0.1:8000/api/pools/${poolId}`;

    fetch(apiUrl)
        .then(res => res.json())
        .then(result => {
            const pool = result.data;
            openEditModal(pool);
        })
        .catch(err => {
            console.error("❌ Không lấy được dữ liệu:", err);
        });
}

function openEditModal(pool) {
    const editPoolModalEl = document.getElementById('editPoolModal');
    if (!editPoolModalEl) {
        console.error("❌ Không tìm thấy modal!");
        return;
    }

    const editModal = new bootstrap.Modal(editPoolModalEl);

    // Kiểm tra dữ liệu pool có hợp lệ không
    if (!pool) {
        console.error("❌ Dữ liệu pool không hợp lệ");
        return;
    }

    // Kiểm tra và gán giá trị vào các input
    console.log("name:", pool.name);
    console.log("house_number:", pool.house_number);
    console.log("id_street:", pool.id_street);

    // Mảng các input IDs cần gán giá trị
    const inputIds = ['idPool','Poolname', 'houseNumber', 'idStreet', 'Lat', 'Lng', 'Length', 'Width', 'Depth', 'Type', 'Opening_hours', 'Close_hours', 'Children_price', 'Adult_price', 'Student_price'];

    inputIds.forEach(id => {
        const inputElement = document.getElementById(id);

        if (inputElement) {
            // Kiểm tra xem pool có thuộc tính tương ứng không
            switch (id) {
                case 'idPool':
                    inputElement.value = pool.id_pool || '';
                    break;
                case 'Poolname':
                    inputElement.value = pool.name || ''; // Gán tên hồ bơi
                    break;
                case 'houseNumber':
                    inputElement.value = pool.house_number || ''; // Gán số nhà
                    break;
                case 'idStreet':
                    inputElement.value = pool.id_street || ''; // Gán id street
                    break;
                case 'Lat':
                    inputElement.value = pool.lat || ''; // Gán vĩ độ
                    break;
                case 'Lng':
                    inputElement.value = pool.lng || ''; // Gán kinh độ
                    break;
                case 'Length':
                    inputElement.value = pool.length || ''; // Gán chiều dài
                    break;
                case 'Width':
                    inputElement.value = pool.width || ''; // Gán chiều rộng
                    break;
                case 'Depth':
                    inputElement.value = pool.depth || ''; // Gán chiều sâu
                    break;
                case 'Type':
                    inputElement.value = pool.type || ''; // Gán loại hồ bơi
                    break;
                case 'Opening_hours':
                    inputElement.value = pool.opening_hours || ''; // Gán giờ mở cửa
                    break;
                case 'Close_hours':
                    inputElement.value = pool.close_hours || ''; // Gán giờ đóng cửa
                    break;
                case 'Children_price':
                    inputElement.value = pool.children_price || ''; // Gán giá vé trẻ em
                    break;
                case 'Adult_price':
                    inputElement.value = pool.adult_price || ''; // Gán giá vé người lớn
                    break;
                case 'Student_price':
                    inputElement.value = pool.student_price || ''; // Gán giá vé học sinh
                    break;
                default:
                    inputElement.value = ''; // Nếu không tìm thấy thuộc tính trong pool
            }

            console.log(`✅ Gán giá trị cho ${id}: ${inputElement.value}`);
        } else {
            console.warn(`❌ Không tìm thấy phần tử input với id: ${id}`);
        }
    });

    // Gán giá trị cho ảnh nếu phần tử imgPreview tồn tại
    const imgPreview = document.getElementById('imgPreview');
    if (imgPreview) {
        if (pool.img) {
            imgPreview.src = pool.img; // Gán ảnh nếu có
            imgPreview.alt = pool.name || 'Ảnh hồ bơi';
            console.log(`✅ Gán ảnh: ${imgPreview.src}`);
        } else {
            imgPreview.src = ''; // Nếu không có ảnh, để trống
            imgPreview.alt = 'Ảnh hồ bơi';
            console.warn("❌ Không có ảnh để gán");
        }
    } else {
        console.warn("❌ Không tìm thấy imgPreview");
    }

    // Mở modal ngay sau khi gán giá trị
    try {
        editModal.show();
    } catch (error) {
        console.error("❌ Lỗi khi mở modal:", error);
    }
}

// Thêm sự kiện submit form
const form = document.getElementById('editPoolForm');
form.addEventListener('submit', function(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của form

    // Lấy các giá trị từ form và xử lý (ví dụ, gửi lên server hoặc làm gì đó)
    const formData = new FormData(form);
    // Giả sử bạn muốn hiển thị các dữ liệu form đã nhập
    for (let entry of formData.entries()) {
        console.log(`${entry[0]}: ${entry[1]}`);
    }

    // Đóng modal sau khi lưu thay đổi (nếu cần)
    const modal = bootstrap.Modal.getInstance(document.getElementById('editPoolModal'));
    modal.hide();
});


async function updatePool(formData) {
    const token = localStorage.getItem('authToken');

    // Tạo đối tượng pool để lưu trữ dữ liệu từ form
    const updatedPool = {};

    // Thu thập dữ liệu từ formData và gán vào đối tượng updatedPool
    formData.forEach((value, key) => {
        if (typeof value === 'string') {
            updatedPool[key] = value.trim(); // Lấy giá trị và loại bỏ khoảng trắng thừa
        } else if (['houseNumber','Lat', 'Lng', 'Length', 'Width', 'Depth', 'Children_price', 'Adult_price', 'Student_price'].includes(key)) {
            updatedPool[key] = parseFloat(value); // Chuyển thành số nếu cần
        } else {
            updatedPool[key] = value; // Nếu không phải chuỗi hoặc số, giữ nguyên giá trị
        }
    });

    // Gửi yêu cầu PUT lên server để cập nhật thông tin hồ bơi
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/pools/${updatedPool.idPool}`, {
            method: 'PATCH',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedPool) // Chuyển đối tượng updatedPool thành chuỗi JSON
        });

        const data = await response.json();

        if (data.success) {
            console.log("✅ Cập nhật hồ bơi thành công!");
            // Đóng modal sau khi cập nhật thành công
            const modal = bootstrap.Modal.getInstance(document.getElementById('editPoolModal'));
            modal.hide();
        } else {
            console.error("❌ Cập nhật hồ bơi thất bại:", data.message);
        }
    } catch (error) {
        console.error("❌ Lỗi khi gửi yêu cầu cập nhật:", error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('editPoolForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);  // Thu thập dữ liệu từ form
        console.log('Dữ liệu gửi đi', formData);  // Log formData để kiểm tra

        // Gọi hàm updatePool với formData
        updatePool(formData);
    });
});


function renderPools(pools) {
    const tbody = document.querySelector("#dataTable tbody");
    tbody.innerHTML = ""; // Xóa dữ liệu cũ trước khi render mới

    pools.forEach(pool => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${pool.id_pool}</td>
            <td>${pool.name}</td>
            <td>${pool.house_number}, ${pool.street.name}, ${pool.street.ward.name}, ${pool.street.ward.district.name}</td>
            <td>${pool.lat}, ${pool.lng}</td>
            <td>${pool.length}m x ${pool.width}m x ${pool.depth}m</td>
            <td>${pool.type}</td>
            <td>${pool.opening_hours} - ${pool.close_hours}</td>
            <td>
                <img src="${pool.img}" alt="Hồ bơi" width="100" height="60">
            </td>
            <td>Trẻ em: ${pool.children_price} VND<br>Người lớn: ${pool.adult_price} VND<br>Học sinh: ${pool.student_price} VND</td>
            <td>${pool.average_rating} ★ (${pool.total_reviews} đánh giá)</td>
            <td>
  <button class="btn btn-warning btn-sm" onclick="fetchAndOpenEditModal(${pool.id_pool})">
                    <i class="fas fa-edit"></i> Sửa
                </button>
                <button class="btn btn-danger btn-sm" onclick="deletePool(${pool.id_pool})"><i class="fas fa-trash"></i> Xóa</button>
            </td>
        `;
        tbody.appendChild(row);
    });
    
}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết hồ bơi</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index-guest.html">Quản lý hồ bơi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index-guest.html">Trang chủ</a></li>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="btn btn-light text-primary" href="login.html"><i
                                        class="fa-solid fa-user text-blue" style="font-size: 1rem;"></i> Đăng nhập</a>
                            </li>
                        </ul>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Ảnh đại diện -->
    <div class="text-center mb-3">
        <img id="poolImage" src="" alt="Hồ bơi" class="img-fluid rounded">
    </div>

    <!-- Main Content -->
    <div class="container mt-3">
        <!-- Thông tin hồ bơi -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Thông tin hồ bơi</div>
            <div class="card-body">
                <h2 id="poolName"></h2>
                <p><strong>Địa chỉ:</strong> <span id="poolAddress"></span></p>
                <p><strong>Loại hình:</strong> <span id="poolType"></span></p>
                <p><strong>Giờ mở cửa:</strong> <span id="poolHours"></span></p>

                <!-- Thêm thông tin tọa độ -->
                <p><strong>Tọa độ GPS:</strong>
                    <span id="poolLatitude"></span>,
                    <span id="poolLongitude"></span>
                </p>
                <p><strong>Kích thước hồ bơi</strong></p>
                <ul>
                    <li><strong>Chiều dài:</strong> <span id="poolLength"></span></li>
                    <li><strong>Chiều rộng:</strong> <span id="poolWidth"></span></li>
                    <li><strong>Độ sâu tối đa:</strong> <span id="poolDepth"></span></li>
                </ul>

                <br>
                <form id="feeForm">
                    <div class="mb-3">
                        <label for="doiTuong" class="form-label"><strong>Chọn đối tượng:</strong></label>
                        <select id="doiTuong" class="form-select">
                            <option value="nguoiLon">Người lớn</option>
                            <option value="treEm">Trẻ em</option>
                            <option value="hocSinhSinhVien">Học sinh/ Sinh viên</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="poolFee" class="form-label"><strong>Phí vào cổng:</strong></label>
                        <input type="text" class="form-control" id="poolFee" readonly>
                    </div>
                </form>

            </div>
        </div>

        <!-- Tiện ích -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Tiện ích</div>
            <div class="card-body">
                <form id="utilitiesForm">
                    <div class="mb-3">
                        <label for="utilitiesDropdown" class="form-label">Chọn tiện ích:</label>
                        <select id="utilitiesDropdown" class="form-select">
                            <option value="">Đang tải...</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Dịch vụ -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Dịch vụ</div>
            <div class="card-body">
                <form id="servicesForm">
                    <div class="mb-3">
                        <label for="servicesDropdown" class="form-label">Chọn dịch vụ:</label>
                        <select id="servicesDropdown" class="form-select">
                            <option value="">Đang tải...</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceModalLabel">Chi tiết dịch vụ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="serviceInfo">Thông tin dịch vụ sẽ hiển thị ở đây.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Các sự kiện tại hồ bơi -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Sự kiện</div>
            <div class="card-body">
                <div class="row">
                    <!-- Cột trái: Form lọc sự kiện -->
                    <div class="col-md-4">
                        <form id="eventFilterForm">
                            <div class="mb-3">
                                <label for="filterDate" class="form-label">Chọn thời gian:</label>
                                <input type="date" id="eventDate" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="filterType" class="form-label">Chọn loại sự kiện:</label>
                                <select id="eventType" class="form-select">
                                    <option value="all">Tất cả</option>
                                    <option value="sport">Thể thao</option>
                                    <option value="education">Giáo dục</option>
                                    <option value="party">Party</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary" id="searchButton">Tìm Kiếm</button>
                        </form>
                    </div>

                    <!-- Cột phải: Danh sách sự kiện -->
                    <div class="col-md-8">
                        <div class="event-header">
                            <span>Tên sự kiện</span>
                            <span>Thể loại</span>
                            <span>Thời gian</span>
                            <span>Tiền</span>
                            <span>Số lượng</span>
                            <span>Hành động</span>
                        </div>
                        <ul class="list-group event-list" id="eventList">
                            <!-- Dữ liệu sẽ được thêm từ API -->
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal xem mô tả sự kiện -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Header Modal -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="eventModalLabel">Mô tả sự kiện</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Nội dung Modal -->
                    <div class="modal-body" id="modalDescription">
                        <!-- Mô tả sự kiện sẽ được chèn vào đây -->
                    </div>
                    <!-- Footer Modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vị trí trên bản đồ -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Vị trí trên bản đồ</div>
            <div class="card-body">
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>

        <!-- Đánh giá và phản hồi -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Đánh giá và phản hồi</div>
            <div class="card-body">
                <!-- Hiển thị đánh giá trung bình -->
                <div class="mb-3">
                    <h5>Đánh giá trung bình: <span id="averageRating"></span> / 5</h5>
                    <p><span id="totalReviews"></span> người đã đánh giá</p>
                </div>

                <!-- Form đánh giá -->
                <div class="mb-3">
                    <label class="form-label">Đánh giá của bạn</label>
                    <div class="star-rating">
                        <i class="fas fa-star star" data-value="1"></i>
                        <i class="fas fa-star star" data-value="2"></i>
                        <i class="fas fa-star star" data-value="3"></i>
                        <i class="fas fa-star star" data-value="4"></i>
                        <i class="fas fa-star star" data-value="5"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="feedback" class="form-label">Phản hồi của bạn</label>
                    <textarea class="form-control" id="feedback" rows="3"
                        placeholder="Nhập đánh giá của bạn..."></textarea>
                </div>

                <button onclick="redirectToLogin()" class="btn btn-primary">Gửi</button>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3 mt-3">
        <p>&copy; 2025 Quản lý hồ bơi. Tất cả các quyền được bảo lưu.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Custom JS -->
    <script src="js/main.js"></script>

    <!-- Custom JS -->
    <script>
        // Rating
        const stars = document.querySelectorAll(".star-rating .star");
        let selectedRating = 0;

        stars.forEach(star => {
            star.addEventListener("mouseover", function () {
                resetStars();
                highlightStars(this.getAttribute("data-value"));
            });

            star.addEventListener("click", function () {
                selectedRating = this.getAttribute("data-value");
                persistSelection();
                console.log("Đánh giá: " + selectedRating);
            });

            star.addEventListener("mouseleave", function () {
                resetStars();
                if (selectedRating > 0) {
                    highlightStars(selectedRating);
                }
            });
        });

        function highlightStars(rating) {
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add("hover");
            }
        }

        function resetStars() {
            stars.forEach(star => {
                star.classList.remove("hover");
            });
        }

        function persistSelection() {
            stars.forEach(star => {
                star.classList.remove("selected");
            });
            for (let i = 0; i < selectedRating; i++) {
                stars[i].classList.add("selected");
            }
        }

        function redirectToLogin() {
            alert("Vui lòng đăng nhập để xem thông tin chi tiết.");
            window.location.href = "login.html";
        }

        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const poolId = urlParams.get("poolId");

            const apiUrl = `http://127.0.0.1:8000/api/pools/${poolId}`;

            // 🗺️ Khởi tạo bản đồ (biến map toàn cục)
            var map = L.map("map").setView([10.762622, 106.660172], 13);
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Lỗi API: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Dữ liệu hồ bơi:", data);

                    // 🎯 Hiển thị thông tin hồ bơi
                    document.getElementById("poolImage").src = data.data.img;
                    document.getElementById("poolName").textContent = data.data.name || "Không có tên";
                    document.getElementById("poolAddress").textContent =
                        `${data.data.house_number || "N/A"}, ${data.data.street?.name || "N/A"}, 
                         ${data.data.street?.ward?.name || "N/A"}, ${data.data.street?.ward?.district?.name || "N/A"}`;
                    document.getElementById("poolType").textContent = data.data.type || "Không xác định";
                    document.getElementById("poolHours").textContent = `${data.data.opening_hours || "N/A"}, ${data.data.close_hours || "N/A"}`;
                    document.getElementById("poolLatitude").textContent = `${data.data.lat}` || "Không có tọa độ";
                    document.getElementById("poolLongitude").textContent = `${data.data.lng}` || "Không có tọa độ";
                    document.getElementById("poolLength").textContent = `${data.data.length}m` || "Không có thông tin";
                    document.getElementById("poolWidth").textContent = `${data.data.width}m` || "Không có thông tin";
                    document.getElementById("poolDepth").textContent = `${data.data.depth}m` || "Không có thông tin";
                    document.getElementById("averageRating").textContent = `${data.data.average_rating}` || "Không có thông tin";
                    document.getElementById("totalReviews").textContent = `${data.data.total_reviews}` || "Không có thông tin";

                    // 💰 Cập nhật giá vé
                    const doiTuong = document.getElementById("doiTuong");
                    const poolFee = document.getElementById("poolFee");

                    doiTuong.addEventListener("change", function () {
                        const selectedValue = doiTuong.value;
                        let fee = "Không có giá";

                        if (selectedValue === "nguoiLon") fee = `${data.data.adult_price} VND` || fee;
                        else if (selectedValue === "treEm") fee = `${data.data.children_price} VND` || fee;
                        else if (selectedValue === "hocSinhSinhVien") fee = `${data.data.student_price} VND` || fee;

                        poolFee.value = fee;
                    });

                    // 📍 Thêm marker vào bản đồ
                    addMarkerToMap(data.data.lat, data.data.lng, data.data.name, data.data.house_number + ", " + data.data.street?.name + ", " + data.data.street?.ward?.name + ", " + data.data.street?.ward?.district?.name);
                })
                .catch(error => {
                    console.error("Lỗi khi lấy dữ liệu:", error);
                    alert("Không thể tải dữ liệu hồ bơi. Vui lòng thử lại!");
                });

            function addMarkerToMap(lat, lng, name, houseNumber) {
                if (!lat || !lng) {
                    console.error("Không có tọa độ hợp lệ!");
                    return;
                }

                const poolLocation = [lat, lng];

                try {
                    // 🏷️ Tạo marker
                    var marker = L.marker(poolLocation).addTo(map);
                    marker.bindPopup(`<b>${name}</b><br>Địa chỉ: ${houseNumber}`).openPopup();
                } catch (error) {
                    console.error("Lỗi khi thêm marker vào bản đồ:", error);
                }
            }
        });

        document.addEventListener("DOMContentLoaded", async function () {
            const servicesDropdown = document.getElementById("servicesDropdown");

            // Lấy poolId từ URL (nếu có)
            const urlParams = new URLSearchParams(window.location.search);
            const poolId = urlParams.get("poolId");

            // Kiểm tra nếu poolId không có
            if (!poolId) {
                console.error("Không tìm thấy poolId trong URL!");
                servicesDropdown.innerHTML = "<option value=''>Lỗi: Thiếu poolId</option>";
                return;
            }

            try {
                // Gọi API để lấy danh sách dịch vụ
                const response = await fetch(`http://127.0.0.1:8000/api/pools/${poolId}/services`);
                const data = await response.json();

                // Kiểm tra dữ liệu trả về
                if (data.status === "success" && Array.isArray(data.data)) {
                    eventList.innerHTML = ""; // Xóa danh sách cũ trước khi thêm mới

                    // Lặp qua từng sự kiện
                    data.data.forEach(eventItem => {
                        const li = document.createElement("li");
                        li.className = "list-group-item";

                        // Lấy thông tin sự kiện từ eventItem
                        li.innerHTML = `
                            <a>${eventItem.name}</a>
                            <span>${eventItem.type}</span>
                            <span>${eventItem.organization_date || "Chưa cập nhật"}</span>
                            <span>${eventItem.price ? eventItem.price + " VNĐ" : "Miễn phí"}</span>
                            <span>${eventItem.max_participants || 0}</span>
                            <button class="btn btn-primary" onclick="redirectToLogin()">Đăng ký</button>
                        `;

                        // Thêm sự kiện vào danh sách
                        eventList.appendChild(li);
                    });
                } else {
                    // Xử lý trường hợp không có sự kiện hoặc dữ liệu không hợp lệ
                    eventList.innerHTML = "<li class='list-group-item text-danger'>Không thể tải dữ liệu sự kiện</li>";
                }


            } catch (error) {
                console.error("Lỗi khi tải danh sách dịch vụ:", error);
                servicesDropdown.innerHTML = "<option value=''>Lỗi tải dữ liệu</option>";
            }
        });

        // Tiện ích và dịch vụ
        document.addEventListener("DOMContentLoaded", async function () {
            const utilitiesDropdown = document.getElementById("utilitiesDropdown");
            const servicesDropdown = document.getElementById("servicesDropdown");
            const serviceInfo = document.getElementById("serviceInfo");
            const serviceModal = new bootstrap.Modal(document.getElementById("serviceModal"));

            const urlParams = new URLSearchParams(window.location.search);
            const poolId = urlParams.get("poolId");

            if (!poolId) {
                console.error("Không tìm thấy poolId trong URL!");
                utilitiesDropdown.innerHTML = "<option value=''>Lỗi: Thiếu poolId</option>";
                servicesDropdown.innerHTML = "<option value=''>Lỗi: Thiếu poolId</option>";
                return;
            }

            try {
                // Gọi cả hai API đồng thời
                const [servicesResponse, utilitiesResponse] = await Promise.all([
                    fetch(`http://127.0.0.1:8000/api/pools/${poolId}/services`),
                    fetch(`http://127.0.0.1:8000/api/pools/${poolId}/utilities`)
                ]);

                const [servicesData, utilitiesData] = await Promise.all([
                    servicesResponse.json(),
                    utilitiesResponse.json()
                ]);

                // Xử lý danh sách Dịch vụ
                servicesDropdown.innerHTML = ""; // Xóa option cũ
                if (servicesData.status === "success" && Array.isArray(servicesData.data) && servicesData.data.length > 0) {
                    servicesData.data.forEach(serviceItem => {
                        const option = document.createElement("option");
                        option.value = serviceItem.service.id_service;
                        option.textContent = serviceItem.service.name;
                        option.dataset.price = serviceItem.price; // Gán giá tiền
                        option.dataset.time = serviceItem.applied_at; // Gán thời gian áp dụng
                        servicesDropdown.appendChild(option);
                    });
                } else {
                    servicesDropdown.innerHTML = "<option value=''>Không có dịch vụ</option>";
                }

                // Xử lý danh sách Tiện ích (Không hiển thị modal)
                utilitiesDropdown.innerHTML = ""; // Xóa option cũ
                if (utilitiesData.status === "success" && Array.isArray(utilitiesData.data) && utilitiesData.data.length > 0) {
                    utilitiesData.data.forEach(utilityItem => {
                        const option = document.createElement("option");
                        option.value = utilityItem.utility.id_utility;
                        option.textContent = utilityItem.utility.name;
                        utilitiesDropdown.appendChild(option);
                    });
                } else {
                    utilitiesDropdown.innerHTML = "<option value=''>Không có tiện ích</option>";
                }
            } catch (error) {
                console.error("Lỗi khi tải dữ liệu:", error);
                servicesDropdown.innerHTML = "<option value=''>Lỗi tải dữ liệu</option>";
                utilitiesDropdown.innerHTML = "<option value=''>Lỗi tải dữ liệu</option>";
            }

            // Xử lý sự kiện khi chọn dịch vụ (chỉ hiển thị modal cho dịch vụ)
            servicesDropdown.addEventListener("change", function () {
                const selectedOption = servicesDropdown.options[servicesDropdown.selectedIndex];

                if (!selectedOption || !selectedOption.value) {
                    return;
                }

                serviceInfo.innerHTML = `<strong>Dịch vụ:</strong> ${selectedOption.textContent} <br>
                                         <strong>Giá:</strong> ${selectedOption.dataset.price} VND
                                         <br>
                                         <strong>Thời gian áp dụng:</strong> ${selectedOption.dataset.time}`;

                serviceModal.show();
            });
        });

        // Sự kiện
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const poolId = urlParams.get("poolId");

            if (!poolId) {
                console.error("❌ Không tìm thấy poolId trong URL");
                return;
            }

            const apiUrl = `http://127.0.0.1:8000/api/pools/${poolId}/events`; // API động theo poolId

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Lỗi API: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    const eventList = document.getElementById("eventList");
                    eventList.innerHTML = "";

                    if (!Array.isArray(data.data) || data.data.length === 0) {
                        eventList.innerHTML = "<li class='list-group-item'>Không có sự kiện nào</li>";
                        return;
                    }

                    data.data.forEach(event => {
                        const li = document.createElement("li");
                        li.className = "list-group-item";

                        li.innerHTML = `
                            <a href="#" class="event-name">${event.name}</a>
                            <span>${event.type || "N/A"}</span>
                            <span>${event.organization_date || "Chưa cập nhật"}</span>
                            <span>${event.price ? event.price + " VNĐ" : "Miễn phí"}</span>
                            <span>${event.max_participants || 0}</span>
                            <button class="btn btn-primary" onclick="redirectToLogin()">Đăng ký</button>
                        `;

                        // Thêm sự kiện click vào tên sự kiện
                        const eventNameLink = li.querySelector(".event-name");
                        eventNameLink.addEventListener("click", function (e) {
                            e.preventDefault(); // Ngăn chặn chuyển hướng mặc định
                            showEventModal(event); // Gọi hàm hiển thị modal với dữ liệu sự kiện
                        });

                        eventList.appendChild(li);
                    });
                })
                .catch(error => {
                    console.error("❌ Lỗi khi tải danh sách sự kiện:", error);
                    document.getElementById("eventList").innerHTML =
                        "<li class='list-group-item text-danger'>Không thể tải dữ liệu sự kiện</li>";
                });
        });

        // Hàm hiển thị modal với mô tả sự kiện
        function showEventModal(event) {
            const modalDescription = document.getElementById("modalDescription");
            modalDescription.innerHTML = `
                <h4>${event.name}</h4>
                <p><strong>Mô tả:</strong> ${event.description}</p>
            `;
            const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
            eventModal.show();
        }

        document.getElementById("searchButton").addEventListener("click", function () {
            const type = document.getElementById("eventType").options[document.getElementById("eventType").selectedIndex].textContent;; // Lấy loại sự kiện từ input
            const organizationDate = document.getElementById("eventDate").value; // Lấy ngày tổ chức từ input

            // Kiểm tra xem cả 2 tham số có hợp lệ không
            if (!type || !organizationDate) {
                alert("Vui lòng nhập đầy đủ thông tin tìm kiếm.");
                return;
            }

            // URL API với tham số lọc
            const apiUrl = `http://127.0.0.1:8000/api/pools/15/events/filter?type=${encodeURIComponent(type)}&organization_date=${encodeURIComponent(organizationDate)}`;

            // Gửi yêu cầu đến API
            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Lỗi API: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data); // Xem dữ liệu trả về

                    const eventList = document.getElementById("eventList");
                    eventList.innerHTML = ""; // Xóa danh sách cũ

                    if (!Array.isArray(data.data) || data.data.length === 0) {
                        eventList.innerHTML = "<li class='list-group-item'>Không có sự kiện nào</li>";
                        return;
                    }

                    // Duyệt qua danh sách sự kiện và hiển thị
                    data.data.forEach(event => {
                        const li = document.createElement("li");
                        li.className = "list-group-item";

                        li.innerHTML = `
                            <a href="#" class="event-name">${event.name}</a>
                            <span>${event.type || "N/A"}</span>
                            <span>${event.organization_date || "Chưa cập nhật"}</span>
                            <span>${event.price ? event.price + " VNĐ" : "Miễn phí"}</span>
                            <span>${event.max_participants || 0}</span>
                            <button class="btn btn-primary" onclick="redirectToLogin()">Đăng ký</button>
                        `;

                        eventList.appendChild(li);
                    });
                })
                .catch(error => {
                    console.error("❌ Lỗi khi tải danh sách sự kiện:", error);
                    document.getElementById("eventList").innerHTML =
                        "<li class='list-group-item text-danger'>Không thể có dữ liệu sự kiện</li>";
                });
        });

    </script>
</body>

</html>
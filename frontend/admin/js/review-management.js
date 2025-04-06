let reviews = [
    {
      customer: "Nguyễn Văn A",
      review: "Dịch vụ rất tốt, nhân viên thân thiện.",
      pool: "Hồ bơi A",
      date: "2025-02-16"
    },
    {
      customer: "Trần Thị B",
      review: "Hồ bơi sạch sẽ, giá cả hợp lý.",
      pool: "Hồ bơi B",
      date: "2025-02-18"
    },
    {
      customer: "Lê Văn C",
      review: "Nhân viên phục vụ chưa nhiệt tình lắm.",
      pool: "Hồ bơi ACC",
      date: "2025-02-19"
    }
  ];
  
  // Hiển thị danh sách đánh giá
  function displayReviews() {
    const reviewList = document.getElementById("reviewList");
    reviewList.innerHTML = "";
  
    reviews.forEach((review, index) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${review.customer}</td>
        <td>${review.review}</td>
        <td>${review.pool}</td>
        <td>${review.date}</td>
      `;
      reviewList.appendChild(row);
    });
  }
  
  
  // Tìm kiếm đánh giá
  document.getElementById("searchReview").addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll("#reviewList tr").forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? "" : "none";
    });
  });
  
  // Hiển thị danh sách đánh giá khi tải trang
  displayReviews();
  
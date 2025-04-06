$(document).ready(function () {
  let poolId = 15; // Định ID hồ bơi mặc định (có thể thay đổi nếu cần)

  // Tải danh sách sự kiện khi trang load
  loadEvents(poolId);

  function loadEvents(poolId) {
      $.ajax({
          type: "GET",
          url: `http://127.0.0.1:8000/api/pools/${poolId}/events`,
          dataType: "json",
          success: function (response) {
              let eventList = "";
              response.forEach((event, index) => {
                  eventList += `
                      <tr>
                          <td>${index + 1}</td>
                          <td>${event.name}</td>
                          <td>${event.description}</td>
                          <td>${event.type}</td>
                          <td>${event.organization_date}</td>
                          <td>${event.max_participants ?? 'Không giới hạn'}</td>
                          <td>${event.price.toLocaleString()} VND</td>
                          <td>
                              <button class="btn btn-warning btn-sm edit-btn" data-id="${event.id_event}">Sửa</button>
                              <button class="btn btn-danger btn-sm delete-btn" data-id="${event.id_event}">Xóa</button>
                          </td>
                      </tr>
                  `;
              });
              $("#eventList").html(eventList);
          },
          error: function () {
              alert("Lỗi khi tải danh sách sự kiện!");
          }
      });
  }

  // Tìm kiếm sự kiện
  $("#searchEvent").on("input", function () {
      let searchText = $(this).val().toLowerCase();
      $("#eventList tr").filter(function () {
          $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
      });
  });

  // Mở modal thêm sự kiện
  $("#addEventBtn").click(function () {
      $("#addEventModal").modal("show");
  });

  // Xử lý thêm sự kiện
  $("#addEventForm").submit(function (event) {
      event.preventDefault();

      const eventData = {
          name: $("#eventName").val().trim(),
          description: $("#eventDescription").val().trim(),
          type: $("#eventType").val(),
          organization_date: $("#eventTime").val(),
          max_participants: $("#eventCapacity").val(),
          price: $("#eventFee").val(),
          id_pool: poolId
      };

      $.ajax({
          type: "POST",
          url: `http://127.0.0.1:8000/api/pools/${poolId}/events/create`,
          dataType: "json",
          contentType: "application/json",
          data: JSON.stringify(eventData),
          success: function () {
              alert("Sự kiện đã được thêm thành công!");
              $("#addEventModal").modal("hide");
              $("#addEventForm")[0].reset();
              loadEvents(poolId);
          },
          error: function (xhr) {
              alert("Lỗi khi thêm sự kiện: " + xhr.responseText);
          }
      });
  });

  // Xử lý cập nhật sự kiện
  $(document).on("click", ".edit-btn", function () {
      let eventId = $(this).data("id");
      let newName = prompt("Nhập tên mới cho sự kiện:");
      let newDescription = prompt("Nhập mô tả mới:");

      if (!newName || !newDescription) return;

      $.ajax({
          type: "PATCH",
          url: `http://127.0.0.1:8000/api/pools/${poolId}/events/${eventId}`,
          dataType: "json",
          contentType: "application/json",
          data: JSON.stringify({ name: newName, description: newDescription }),
          success: function () {
              alert("Cập nhật sự kiện thành công!");
              loadEvents(poolId);
          },
          error: function () {
              alert("Lỗi khi cập nhật sự kiện!");
          }
      });
  });

  // Xử lý xóa sự kiện
  $(document).on("click", ".delete-btn", function () {
      let eventId = $(this).data("id");
      if (!confirm("Bạn có chắc muốn xóa sự kiện này?")) return;

      $.ajax({
          type: "DELETE",
          url: `http://127.0.0.1:8000/api/pools/${poolId}/events/${eventId}`,
          dataType: "json",
          success: function () {
              alert("Xóa sự kiện thành công!");
              loadEvents(poolId);
          },
          error: function () {
              alert("Lỗi khi xóa sự kiện!");
          }
      });
  });
});

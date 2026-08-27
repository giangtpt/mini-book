# Debug Report

## Issue 1: Lỗi SSL Certificate khi cài đặt Composer/Laravel

### Issue
Khi chạy `composer create-project laravel/laravel mini-book-management` ở bước
setup ban đầu, lệnh liên tục báo lỗi:
```
The following exception indicates a possible issue with the Avast Firewall
In CurlDownloader.php line 401:
curl error 60 while downloading https://repo.packagist.org/packages.json:
SSL certificate problem: unable to get local issuer certificate
```
Không tải được Laravel, project không tạo được.

### Nguyên nhân
Bình thường PHP/Composer nhận chứng chỉ SSL thật từ Let's Encrypt khi kết
nối tới packagist.org, khớp với danh sách tin tưởng (`cacert.pem`) nên xác
thực thành công. Khi Avast bật HTTPS Scanning, nó chen vào giữa để quét nội
dung, tự cấp 1 chứng chỉ giả (do chính Avast tạo) thay cho chứng chỉ thật —
chứng chỉ giả này không có trong danh sách tin tưởng của Composer/PHP nên
bị từ chối, báo lỗi "unable to get local issuer certificate".

### Cách điều tra
Kiểm tra "Enable HTTPS Scanning" trong Avast — tùy chọn này nằm ở
**Settings → Protection → Core Shields → Web Shield**.

### Cách xử lý
Tắt công tắc **"Enable HTTPS scanning"** trong Avast (Settings → Protection
→ Core Shields → Web Shield). Chạy lại `composer create-project
laravel/laravel mini-book-management` → chạy thành công ngay.

### Kết quả
Lệnh chạy thành công, Laravel được cài đặt đầy đủ. Xác nhận nguyên nhân là
Avast's HTTPS Scanning chặn kết nối HTTPS của ứng dụng CLI.

**Bài học rút ra:** Khi gặp lỗi SSL certificate với các công cụ CLI
(Composer, npm, git) trên máy có cài antivirus, nên nghi ngờ phần mềm bảo
mật đang can thiệp HTTPS trước tiên, và kiểm tra kỹ trong phần cài đặt của
antivirus đó.

---

## Cải tiến 1: Thay JS `confirm()` bằng modal popup tự thiết kế

### Hiện trạng ban đầu
Chức năng Xóa (cả Sách và Thể loại) ban đầu dùng `onsubmit="return
confirm('Xác nhận xóa...?')"` — popup mặc định của trình duyệt để hỏi lại
người dùng trước khi xóa.

### Vấn đề với cách làm cũ
- Giao diện popup xấu, không đồng bộ được màu sắc/font với phần còn lại
  của trang — mỗi trình duyệt (Chrome, Firefox, Edge...) hiển thị 1 kiểu
  khác nhau, không kiểm soát được.
- Không thể tùy biến nội dung linh hoạt (ví dụ hiện tên sách/thể loại cụ
  thể trong câu hỏi một cách đẹp mắt).
- `confirm()` là hàm chặn luồng trình duyệt (blocking) — về lâu dài không
  phải cách làm khuyến khích cho giao diện web hiện đại.

### Cách sửa
Thay bằng 1 modal (popup) tự thiết kế bằng HTML + CSS + JavaScript thuần:
- Thêm 1 khối `<div class="modal-overlay">` ẩn sẵn (dùng `display: none`),
  chỉ hiện ra khi cần (`classList.add('active')`).
- Nút "Xóa" đổi từ submit form trực tiếp thành `<button
  onclick="openDeleteModal(id, ten)">` — chỉ chạy JavaScript để đổi nội
  dung modal (tên sách/thể loại tương ứng) và hiện modal lên, **chưa gửi
  gì lên server**.
- Chỉ khi người dùng bấm "Xác nhận xóa" bên trong modal, form thật mới
  được submit (gửi request `DELETE` thật sự lên server).
- Dùng chung 1 modal duy nhất cho toàn bộ danh sách (không tạo riêng 1
  modal cho mỗi dòng), tiết kiệm code — JS chỉ cần đổi nội dung + đường
  dẫn form mỗi lần mở.

### Lợi ích đạt được
- Giao diện đồng nhất trên mọi trình duyệt, style khớp hoàn toàn với theme
  chung của trang (bo góc, màu sắc, font).
- Hiển thị được đúng tên sách/thể loại cụ thể trong câu hỏi xác nhận, rõ
  ràng hơn popup mặc định chỉ hiện được 1 câu chung chung.
- Không chặn luồng trình duyệt (non-blocking) — trải nghiệm mượt hơn.
- Tách rõ 2 giai đoạn: "mở modal" (thuần Client, không tốn tài nguyên
  server) và "xác nhận xóa thật" (mới thực sự đi qua Route → Controller →
  Model) — giúp minh họa rõ khái niệm Client-side vs Server-side khi giải
  thích luồng hệ thống.


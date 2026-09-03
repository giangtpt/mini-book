# Debug Report

## Issue: Nhập sai mật khẩu Database trong file `.env`

### Issue
Khi chạy `php artisan migrate`, lệnh báo lỗi không kết nối được vào
database:
```
SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'
(using password: YES)
```
Không tạo được bảng, project không chạy tiếp được.

### Nguyên nhân
File `.env` đang khai báo sai giá trị `DB_PASSWORD` — gõ nhầm 1 mật khẩu
không đúng, trong khi Laragon mặc định tài khoản `root` **không có mật
khẩu** (để trống). Vì `.env` đang có sẵn 1 chuỗi ký tự ở `DB_PASSWORD`
thay vì để trống, Laravel dùng đúng giá trị sai đó để kết nối, MySQL từ
chối truy cập.

### Cách điều tra
1. Đọc kỹ thông báo lỗi — thấy rõ chữ "Access denied for user 'root'"
   → xác định ngay đây là lỗi sai thông tin đăng nhập, không phải lỗi
   cú pháp code hay lỗi migration.
2. Mở HeidiSQL (đang kết nối MySQL thành công sẵn từ trước) để so sánh —
   xác nhận HeidiSQL đang dùng tài khoản `root`, mật khẩu để trống, kết
   nối bình thường.
3. Mở lại file `.env`, so sánh dòng `DB_PASSWORD` với thông tin thật —
   phát hiện có giá trị bị gõ nhầm vào, trong khi đáng lẽ phải để trống.

### Cách xử lý
Sửa lại dòng `DB_PASSWORD=` trong `.env` (xóa giá trị sai, để trống đúng
như cấu hình mặc định của Laragon). Chạy thêm `php artisan config:clear`
để Laravel nạp lại cấu hình mới (tránh trường hợp Laravel đã cache lại
cấu hình cũ). Chạy lại `php artisan migrate`.

### Kết quả
Kết nối database thành công, migration chạy tạo bảng bình thường.

**Bài học rút ra:** Khi gặp lỗi kết nối database, nên đọc kỹ nội dung
thông báo lỗi trước — SQLSTATE và mã lỗi MySQL (ở đây là `1045 Access
denied`) thường chỉ thẳng ra nguyên nhân (sai tài khoản/mật khẩu), giúp
khoanh vùng nhanh hơn nhiều so với đoán mò. Ngoài ra, nên có 1 công cụ
khác (ở đây là HeidiSQL) đã kết nối thành công sẵn để đối chiếu lại đúng
thông tin đăng nhập thật, tránh việc tự nghi ngờ sai chỗ khác (như nghĩ
do lỗi migration hay lỗi code).

---

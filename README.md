# Mini Book Management

Ứng dụng quản lý sách cá nhân xây dựng bằng Laravel — quản lý thể loại và
sách, hỗ trợ tìm kiếm, lọc, phân trang, và xóa mềm (soft delete).

## Tính năng

- Quản lý Thể loại (Category): Thêm / Sửa / Xóa, hiển thị số sách theo từng
  thể loại.
- Quản lý Sách (Book): Thêm / Sửa / Xóa / Xem chi tiết.
- Tìm kiếm sách theo tên, lọc theo thể loại và trạng thái đọc.
- Phân trang danh sách.
- Xóa mềm (Soft Delete) — dữ liệu xóa có thể khôi phục lại.
- Giao diện responsive (Flexbox), xác nhận xóa qua modal popup.

## Công nghệ sử dụng

- PHP 8.3 / Laravel
- MySQL
- Blade Template
- HTML/CSS (Flexbox) + JavaScript thuần

## Yêu cầu môi trường

- PHP >= 8.2
- Composer
- MySQL (hoặc MariaDB)
- (Khuyến khích) Laragon / XAMPP nếu chạy trên Windows

## Hướng dẫn cài đặt và chạy project

1. Clone repository:
   ```
   git clone https://github.com/giangtpt/mini-book.git
   cd mini-book
   ```

2. Cài đặt các gói phụ thuộc PHP:
   ```
   composer install
   ```

3. Tạo file cấu hình môi trường từ file mẫu:
   ```
   cp .env.example .env
   php artisan key:generate
   ```

4. Mở file `.env`, cấu hình kết nối database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mini_book_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Tạo database rỗng tên `mini_book_management` trong MySQL (qua HeidiSQL,
   phpMyAdmin, hoặc dòng lệnh MySQL).

6. Chạy migration để tạo bảng:
   ```
   php artisan migrate
   ```

7. Khởi động server:
   ```
   php artisan serve
   ```
   Truy cập ứng dụng tại `http://127.0.0.1:8000`.

   (Nếu dùng Laragon, có thể truy cập trực tiếp qua domain ảo
   `http://mini-book-management.test` mà không cần chạy `php artisan serve`.)

## Cấu trúc Database

Xem chi tiết tại [`docs/erd.png`](docs/erd.png).

- **categories**: `id`, `name`, `created_at`, `updated_at`, `deleted_at`
- **books**: `id`, `title`, `author`, `category_id` (khóa ngoại), `description`,
  `published_year`, `status`, `created_at`, `updated_at`, `deleted_at`

Quan hệ: 1 Category có nhiều Book (1-N).

## Sơ đồ luồng hệ thống

Chi tiết các luồng chính (Thêm / Sửa / Xóa / Xem) cho cả Sách và Thể loại,
xem tại thư mục [`docs/`](docs/):

- [`docs/book_add_flow.png`](docs/book_add_flow.png) — Thêm sách
- [`docs/book_edit_flow.png`](docs/book_edit_flow.png — Sửa sách
- [`docs/book_delete_flow.png`](docs/book_delete_flow.png) — Xóa sách (2 giai đoạn: modal xác nhận rồi mới gửi request)
- [`docs/book_view_flow.png](docs/book_view_flow.png) — Xem chi tiết sách
- [`docs/category_add_flow.png`](docs/category_add_flow.png) — Thêm thể loại
- [`docs/category_edit_flow.png`](docs/category_edit_flow.png) — Sửa thể loại
- [`docs/category_delete_flow.png`](docs/category_delete_flow.png) — Xóa thể loại (có rẽ nhánh kiểm tra còn sách hay không)
- [`docs/system-flow-deploy.png`](docs/system-flow-deploy.png) — Deploy flow (Domain → DNS → Nginx → PHP-FPM → Laravel → MySQL)

**Lưu ý**: Thể loại (Category) không có trang xem chi tiết riêng — tên và số
sách đã hiển thị đủ ngay trong bảng danh sách.

## Debug Report

Xem chi tiết các lỗi thực tế đã gặp và cách xử lý tại
[`DEBUG_REPORT.md`](DEBUG_REPORT.md).

## Demo

Project chạy local trên môi trường phát triển (Laragon), chưa triển khai lên
server thật — không có URL demo public.

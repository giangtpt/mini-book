# Debug Report

## Issue: Không tạo lại được thể loại trùng tên với thể loại đã xóa

### Issue
Xóa 1 thể loại (ví dụ "Trinh thám"), sau đó tạo lại 1 thể loại mới với
đúng tên đó — hệ thống báo lỗi "The name has already been taken." (tên
đã được sử dụng), không cho tạo, dù thể loại cũ rõ ràng đã bị xóa.

### Cách điều tra
1. **Xác định lỗi xảy ra ở đâu**: thông báo "The name has already been
   taken." là lỗi validate (kiểm tra dữ liệu đầu vào) của Laravel, không
   phải lỗi Database (không có mã lỗi SQL nào kèm theo) — nên hướng điều
   tra tập trung vào quy tắc validate `unique`, chưa cần nghi ngờ đến
   Controller hay Model.
2. **Đặt câu hỏi đúng trọng tâm**: vì ứng dụng đã được chủ động thiết kế
   dùng xóa mềm (soft delete) từ đầu — không phải điều mới phát hiện —
   nên câu hỏi cần đặt ra là: liệu quy tắc `unique` có tự biết loại trừ
   những bản ghi đã bị đánh dấu xóa mềm hay không?
3. **Kiểm chứng**: mở trực tiếp bảng `categories` trong HeidiSQL, tìm
   đúng dòng thể loại vừa xóa — xác nhận dòng đó **vẫn còn tồn tại thật**
   trong database (đúng như thiết kế xóa mềm), chỉ có cột `deleted_at`
   được điền giá trị thời gian. Điều này khẳng định: quy tắc `unique`
   đang kiểm tra luôn cả dòng đã xóa mềm đó, vì nó vẫn "nhìn thấy" được
   trong bảng.
4. **Kết luận nguyên nhân**: quy tắc `unique` mặc định kiểm tra **toàn
   bộ dữ liệu có trong bảng**, không tự phân biệt được dòng nào đã bị
   đánh dấu xóa mềm — đây là hành vi mặc định của validate, không tự
   động tương thích với cơ chế xóa mềm mà ứng dụng đang dùng.

### Cách xử lý
Sửa trong file `app/Http/Controllers/CategoryController.php`, thêm điều
kiện: chỉ tính là trùng nếu dòng đó **chưa bị xóa** (`deleted_at` đang để
trống). Áp dụng sửa cho cả hàm `store()` (tạo mới) và `update()` (sửa).

**Before** (hàm `store()`):
```php
$request->validate([
    'name' => 'required|string|max:255|unique:categories,name',
]);
```

**After** (hàm `store()`):
```php
use Illuminate\Validation\Rule;

$request->validate([
    'name' => [
        'required', 'string', 'max:255',
        Rule::unique('categories', 'name')->whereNull('deleted_at'),
    ],
]);
```

**Before** (hàm `update()`):
```php
$request->validate([
    'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
]);
```

**After** (hàm `update()`):
```php
$request->validate([
    'name' => [
        'required', 'string', 'max:255',
        Rule::unique('categories', 'name')->whereNull('deleted_at')->ignore($category->id),
    ],
]);
```

### Kết quả
Tạo lại được thể loại trùng tên với thể loại đã xóa trước đó, không còn
bị chặn.

**Bài học rút ra:** Khi một bảng dữ liệu có dùng xóa mềm, mọi quy tắc
kiểm tra "không được trùng" phải tự thêm điều kiện loại trừ các dòng đã
xóa — vì các quy tắc đó mặc định không tự biết đến khái niệm "xóa mềm",
chỉ đơn giản kiểm tra toàn bộ dữ liệu có trong bảng.

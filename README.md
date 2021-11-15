-Pull git về 
-Chuyển folder vào trong xampp/htdocs
-Copy paste file .env.example, đổi tên thành .env
-Copy đoạn sau paste vào .env(thay thế đoạn tương tự trong file chứ ko phải paste ra cái mới nha má)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce (tên database)
DB_USERNAME=root
DB_PASSWORD=

-Chạy lệnh composer update, sau đó chạy php artisan key:generate
-Vào phpmyadmin, tạo database tên giống như tên chỗ DB_DATABASE, nhớ chọn utf32_unicode_ci
-Chạy lệnh php artisan migrate để tạo bảng cho database
-chạy php artisan serve để chạy server
-Route vào routes/api.php xem dùm !!! nhớ thêm /api/ vào trước mỗi route trong đó.

P/s: Nếu muốn tạo dữ liệu để test cho Category thì chạy lệnh php artisan category:add 5(tạo 5 record, muốn tạo mấy record cũng được)

TÊN DỰ ÁN : Fashion E-Commerce Website
Môn Học : Website application design and development
Giáo Viên : Nguyễn Hữu Quyền 
Nhóm : 5 
Thành Viên : 
    - Le Dinh Nhat Huy | 23090003
    - Nguyen Phuoc Hai | 23090030
    - Le Quang Tung    | 23090021
    - Truong Quynh Chau| 23090037
Commit Nhóm : 40 Commit 
    - Le Dinh Nhat Huy | 31 Commit 
    - Nguyen Phuoc Hai | 5 Commit   
    - Le Quang Tung    | 2 Commit
    - Truong Quynh Chau| 2 Commit
Năm Học : 2024–2025

I - MỤC TIÊU CỦA DỰ ÁN 
- Xây dựng một website bán hàng thời trang hoàn chỉnh từ frontend đến backend.
- Áp dụng kiến thức đã học
- Tiếp cận quy trình phát triển web thực tế
- Áp dụng Tailwind CSS (NodeJS + PostCSS)

II - Ý TƯỞNG & PHÂN TÍCH HỆ THỐNG
2.1 Ý TƯỞNG TỔNG 
- Website mô phỏng một cửa hàng thời trang online hiện đại, nơi người dùng có thể :
    + Xem sản phẩm mới, sản phẩm bán chạy
    + Xem bộ sưu tập (collections) theo phong cách
    + Đọc blog về thời trang / xu hướng
    + Thêm sản phẩm vào giỏ hàng
    + Đăng ký, đăng nhập tài khoản
    + Thanh toán & đặt hàng
2.2 ĐỐI TƯỢNG 
- Khách hàng mua sắm online
- Người dùng trẻ, quan tâm đến thời trang
- Quản trị viên quản lý sản phẩm & nội dung

III - MÔ HÌNH HỆ THỐNG 
- Frontend:
    + HTML + Tailwind CSS + Bootstrap (kết hợp, tuỳ trang)
- Backend:
    + PHP thuần (không dùng framework)
- Database: MySQL
- CSS Build Tool:
Tailwind CLI + PostCSS + Autoprefixer

IV - CHỨC NĂNG CHI TIẾT 
4.1 Trang chủ (Home)
- Hero video/banner toàn màn hình
- Hiển thị:
    + New Arrivals
    + Best Sellers
    + Collections
    + Blog nổi bật
- Thiết kế responsive cho mobile & desktop
4.2 Trang sản phẩm (Products)
- Hiển thị danh sách sản phẩm từ database
- Thông tin gồm:
    + Ảnh
    + Tên sản phẩm
    + Giá / Giá sale
- Có thể mở rộng:
    + Phân trang
    + Lọc sản phẩm 
4.3 Collections 
- Lấy dữ liệu từ bảng collections
- Mỗi collection gồm:
    + Tiêu đề
    + Mô tả
    + Hình ảnh đại diện
- Giao diện editorial style, hiện đại
- Responsive hoàn toàn
4.4 Blog
- Trang danh sách Blog:
    + Lấy dữ liệu từ bảng blogs
    + Hiển thị: 
        Ảnh đại diện 
        Ngày đăng
        Tiêu đề
        Mô tả ngắn
    + Giao diện card, bóng đổ, bo góc
- Trang chi tiết Blog:
    + Hiển thị nội dung đầy đủ bài viết
    + Hình ảnh lớn
    + Typography tối ưu cho đọc nội dung dài
4.5 Đăng ký & Đăng nhập
- Hệ thống user bằng PHP session
- Chức năng:
    + Register
    + Login
    + Logout
- Phân quyền:
    + User
    + Admin
4.6 Giỏ hàng (Cart)
- Thêm sản phẩm vào giỏ
- Hiển thị số lượng trên header
- Tính tổng tiền
- Chuẩn bị cho chức năng checkout
4.7 Trang Admin
- Dashboard
- Quản lý sản phẩm 
- Quản lý user 
- Quản lý blog
- Quản lý collections
- Quản lý đơn hàng / trạng thái
V - GIAO DIỆN & UI/UX
5.1 Thiết kế giao diện
- Phong cách: Modern – Clean – Fashion
- Màu sắc:
    + Trắng hồng chủ đạo
    + Điểm nhấn cam (brand color)
- Typography:
    + Font Inter / Poppins
- Hiệu ứng: 
    + Hover
    + Transition
    + Shadow
    + Animation nhẹ
5.2 Responsive Design
- Mobile-first
- Breakpoints:
    + Mobile
    + Tablet
    + Desktop
- Tailwind CSS được sử dụng mạnh cho layout responsive

VI - CÔNG NGHỆ SỬ DỤNG 
- Backend : PHP thuần
- Database : MySQL
- Frontend : HTML, CSS, JS
- CSS Framework : Tailwind CSS (CLI)
- UI hỗ trợ : Bootstrap
- Icons : uicons
- Build tool : NodeJS + PostCSS
- Quản lý mã : GitHub
- Deploy : Hosting Cpanel + Domain

VII - TRIỂN KHAI TAILWIND CLI 
8.1 Các bước triển khai
npm install -D tailwindcss@3 postcss autoprefixer
npx tailwindcss init -p

- input.css 
@tailwind base;
@tailwind components;
@tailwind utilities;

- build css 
npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --minify

VIII - CÁC CƠ SỞ DỮ LIỆU 
- Các bảng chính:
 + users
 + products 
 + collections
 + blogs
 + orders
 + orders_items
 + categories
 + carts 
 + cart_items
- Database được đính kèm trong file database.sql 

IX - HƯỚNG PHÁT TRIỂN TƯƠNG LAI 
- Thanh toán online qr, api banking
- Quản lý đơn hàng nâng cao
- Sản phẩm chi tiết
- Dashboard admin chuyên nghiệp hơn
- API & AJAX nâng cao

X - KẾT LUẬN TỔNG BÁO CÁO
- Thông qua quá trình thực hiện dự án Fashion E-Commerce Website, nhóm đã vận dụng và củng cố một cách toàn diện các kiến thức lý thuyết đã học vào thực tế triển khai một hệ thống website hoàn chỉnh. Dự án không chỉ dừng lại ở việc xây dựng giao diện hiển thị, mà còn bao gồm đầy đủ các thành phần quan trọng của một hệ thống web hiện đại như xử lý dữ liệu, quản lý người dùng, kết nối cơ sở dữ liệu và tối ưu trải nghiệm người dùng.
- Thông qua quá trình thực hiện dự án Fashion E-Commerce Website, nhóm đã vận dụng và củng cố một cách toàn diện các kiến thức lý thuyết đã học vào thực tế triển khai một hệ thống website hoàn chỉnh. Dự án không chỉ dừng lại ở việc xây dựng giao diện hiển thị, mà còn bao gồm đầy đủ các thành phần quan trọng của một hệ thống web hiện đại như xử lý dữ liệu, quản lý người dùng, kết nối cơ sở dữ liệu và tối ưu trải nghiệm người dùng.
- Trong quá trình phát triển, nhóm đã chủ động lựa chọn mô hình PHP thuần kết hợp MySQL, qua đó giúp hiểu sâu hơn về cách thức hoạt động của backend, cơ chế xử lý request–response, quản lý session và phân quyền người dùng. Việc không sử dụng framework giúp nhóm nắm vững bản chất của lập trình web, thay vì phụ thuộc vào các thư viện có sẵn.
- Trong quá trình thực hiện, nhóm cũng gặp phải nhiều khó khăn như:
    + Xung đột giữa Bootstrap và Tailwind CSS
    + Lỗi build Tailwind khi triển khai trên môi trường hosting
    + Vấn đề responsive trên nhiều kích thước màn hình
    + Đồng bộ dữ liệu giữa giao diện và cơ sở dữ liệu
- Tuy nhiên, thông qua việc tìm hiểu tài liệu và được thầy hướng dẫn tận tình, trao đổi trong nhóm và thử nghiệm nhiều giải pháp khác nhau, nhóm đã từng bước khắc phục các vấn đề trên. Điều này giúp các thành viên nâng cao đáng kể kỹ năng debug, tư duy giải quyết vấn đề và khả năng làm việc nhóm trong môi trường phát triển phần mềm.

XI - TÀI LIỆU THAM KHẢO 
- Thầy : Nguyền Hữu Quyền 
- https://tailwindcss.com
- https://getbootstrap.com
- https://w3school.com
- https://php.net

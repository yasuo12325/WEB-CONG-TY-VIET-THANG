# Website VIETTC., JSC

Website doanh nghiệp cho Công ty Cổ phần Thiết bị Công nghiệp và Chuyển giao Công nghệ Việt Thắng (VIETTC., JSC), xây dựng bằng **Laravel 13 + Filament 5 + MySQL**.

- Trang công khai: giới thiệu công ty, lĩnh vực hoạt động, danh mục & sản phẩm (kèm ảnh, thông số kỹ thuật, tài liệu PDF), tin tức, dự án, đối tác, liên hệ.
- Trang quản trị `/admin`: đăng nhập, phân quyền, CRUD toàn bộ nội dung — **không cần sửa code** để thêm/sửa/xóa sản phẩm hay nội dung khác.

## 1. Kiến trúc tổng quan

| Thành phần | Công nghệ |
|---|---|
| Backend / Frontend | Laravel 13 (PHP 8.4), Blade + Tailwind CSS v4 + Alpine.js |
| Trang quản trị | Filament 5 (chạy trong cùng ứng dụng Laravel, tại `/admin`) |
| Database | MySQL 8 |
| Auth & phân quyền | Filament auth + `spatie/laravel-permission` (2 role: `super-admin`, `editor`) |
| Lưu trữ file | Local disk Laravel (`storage/app/public`, symlink `public/storage`) — DB chỉ lưu đường dẫn |
| Build assets | Vite (chỉ chạy lúc build, không cần Node lúc production) |

Toàn bộ site (công khai + quản trị) là **một ứng dụng Laravel duy nhất**, dùng chung 1 database. Không có React/Vue/API riêng — Blade render server-side để đơn giản hoá triển khai trên hosting phổ thông (Hostinger) và tốt cho SEO.

## 2. Cấu trúc thư mục quan trọng

```
app/
  Models/                     Product, Category, ProductImage, ProductDocument,
                               ProductSpec, News, Project, Partner, ContactMessage, Setting, User
  Filament/
    Resources/                CRUD quản trị: Products, Categories, News, Projects, Partners,
                               ContactMessages, Users (mỗi resource có Schemas/ cho form, Tables/ cho bảng)
    Pages/ManageSettings.php  Trang chỉnh thông tin công ty (địa chỉ, điện thoại, logo, banner...)
  Http/Controllers/           HomeController, ProductController, NewsController, ProjectController,
                               ContactController, PageController — render các trang công khai
  Mail/NewContactMessageMail.php   Email thông báo khi có liên hệ mới
database/
  migrations/                 Toàn bộ schema (xem mục 3)
  seeders/                    RoleSeeder, AdminUserSeeder, SettingsSeeder, CategorySeeder, PartnerSeeder
resources/views/
  layouts/app.blade.php       Layout công khai (header/footer)
  home.blade.php, products/, news/, projects/, pages/   Các trang công khai
  filament/pages/manage-settings.blade.php              View trang cài đặt công ty
  components/product-card.blade.php                      Component thẻ sản phẩm dùng lại nhiều nơi
routes/web.php                 Toàn bộ route công khai (route /admin do Filament tự đăng ký)
```

## 3. Cấu trúc Database

- `categories` — danh mục sản phẩm, hỗ trợ 2 cấp (`parent_id`), có icon cho lưới "Lĩnh vực hoạt động".
- `products` — sản phẩm, có `status` (`draft`/`published`), `slug`, soft delete.
- `product_images`, `product_documents`, `product_specs` — bảng con 1-nhiều: ảnh, PDF, thông số kỹ thuật. Chỉ lưu **đường dẫn file**, file thật nằm trong `storage/app/public/products/...`.
- `news`, `projects` — tin tức, dự án (có `status`, soft delete).
- `partners` — đối tác/hãng cung cấp thiết bị.
- `contact_messages` — lead từ form Liên hệ.
- `settings` — bảng key-value chứa toàn bộ thông tin công ty (địa chỉ, điện thoại, logo, nội dung banner trang chủ...) — chỉnh qua `/admin/manage-settings`, không hard-code trong giao diện.
- `users`, `roles`, `permissions` (do `spatie/laravel-permission` quản lý) — tài khoản & phân quyền nhân viên.

Mọi thay đổi schema đều là **migration mới** (không sửa migration cũ) → `php artisan migrate` để nâng cấp an toàn.

## 4. Chạy dự án ở máy local

### Yêu cầu
- PHP 8.4+ với các extension: `openssl`, `pdo_mysql`, `mbstring`, `curl`, `fileinfo`, `zip`, `gd`, `intl`
- Composer 2
- Node.js 20+ và npm
- MySQL 8

### Các bước

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Mở `.env`, điền thông tin kết nối MySQL (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) và (tuỳ chọn) `ADMIN_EMAIL` / `ADMIN_PASSWORD` cho tài khoản quản trị đầu tiên.

```bash
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

Truy cập `http://127.0.0.1:8000` cho trang công khai, `http://127.0.0.1:8000/admin` cho trang quản trị.

Nếu không đặt `ADMIN_PASSWORD` trong `.env`, seeder sẽ tự sinh mật khẩu ngẫu nhiên và **in ra terminal một lần duy nhất** khi chạy `migrate --seed` — hãy đổi mật khẩu ngay sau khi đăng nhập lần đầu (Menu người dùng → Đổi mật khẩu, hoặc qua trang `/admin/users`).

### Chạy song song lúc phát triển (tuỳ chọn)

```bash
npm run dev        # Vite dev server, hot-reload CSS/JS
php artisan serve  # Laravel server
```

## 5. Vai trò & phân quyền

- **super-admin**: toàn quyền, bao gồm quản lý tài khoản nhân viên (`/admin/users`).
- **editor**: CRUD sản phẩm, danh mục, tin tức, dự án, đối tác, xem/xử lý liên hệ, sửa thông tin công ty — **không** thấy/sửa được mục quản lý tài khoản.

Gán role khi tạo/sửa tài khoản tại `/admin/users` (chỉ super-admin thấy mục này).

## 6. Cách đăng một sản phẩm mới (tóm tắt — xem chi tiết trong `DEPLOYMENT.md` phần cuối)

1. Đăng nhập `/admin`.
2. (Nếu cần) Tạo danh mục mới ở **Sản phẩm → Danh mục**.
3. Vào **Sản phẩm → Tạo** → điền tên, model, mô tả, chọn danh mục.
4. Tab **Hình ảnh**: bấm "Thêm ảnh", upload ảnh, đánh dấu ảnh đại diện.
5. Tab **Tài liệu (PDF)**: upload catalogue/brochure nếu có (không bắt buộc).
6. Tab **Thông số kỹ thuật**: thêm từng dòng thông số (nhóm / tên / giá trị).
7. Tab **Xuất bản & SEO**: chọn trạng thái **Đã xuất bản** khi sẵn sàng công bố (để **Bản nháp** nếu còn soạn).
8. Bấm **Tạo**. Sản phẩm Draft không hiển thị công khai; sản phẩm Published xuất hiện ngay tại trang `/san-pham`.

## 7. Backup & khôi phục database

Backup định kỳ bằng `mysqldump` (xem hướng dẫn cron trong `DEPLOYMENT.md`). Khôi phục:

```bash
mysql -u <user> -p <database> < backup-file.sql
```

File upload (ảnh/PDF) nằm trong `storage/app/public/` — nên backup cùng với database (ví dụ bằng `spatie/laravel-backup` hoặc rsync định kỳ).

## 8. Triển khai lên Hostinger

Xem hướng dẫn đầy đủ trong [`DEPLOYMENT.md`](DEPLOYMENT.md).

## 9. Quy ước bàn giao cho developer khác

- Không commit `.env` — mọi secret (DB, mail, v.v.) qua biến môi trường, xem `.env.example` để biết danh sách key cần cấu hình.
- Thay đổi schema luôn qua migration mới, không sửa migration cũ đã chạy production.
- Logic quản trị nằm trong `app/Filament/Resources` và `app/Filament/Pages` (theo quy ước Filament: `{Model}Resource.php`, `Pages/`, `Schemas/{Model}Form.php`, `Tables/{Model}Table.php`).
- Trang công khai dùng Blade thuần (`resources/views`), controller mỏng (`app/Http/Controllers`), không có tầng service thừa cho quy mô hiện tại.

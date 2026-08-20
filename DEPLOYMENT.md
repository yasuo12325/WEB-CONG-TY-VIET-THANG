# Hướng dẫn triển khai lên Hostinger

Tài liệu này hướng dẫn từ đầu: tạo hosting, database, cấu hình domain, đưa code lên qua GitHub, và luồng vận hành sau khi đã live.

## 0. Yêu cầu gói Hostinger

Chọn gói **Business** hoặc **Cloud Startup** trở lên (không dùng gói Premium/Shared thấp nhất) vì cần:
- PHP **8.4** (Hostinger cho chọn phiên bản PHP theo từng site trong hPanel).
- Truy cập **SSH** (có ở Business/Cloud) — giúp chạy `composer install`, `php artisan migrate`, tạo `storage:link` trực tiếp trên server. Không có SSH vẫn triển khai được nhưng phức tạp hơn (xem mục 6).
- 1 database **MySQL**.
- Custom document root cho từng domain (để trỏ thẳng vào thư mục `public/` của Laravel).

## 1. Tạo website & database trên Hostinger

1. Đăng nhập hPanel → **Websites** → **Add website** → chọn domain (hoặc dùng domain đã có).
2. Vào **Advanced → PHP Configuration** → chọn PHP **8.4**, bật các extension: `openssl`, `pdo_mysql`, `mbstring`, `curl`, `fileinfo`, `zip`, `gd`, `intl` (Hostinger thường bật sẵn hầu hết, kiểm tra lại cho đủ).
3. Vào **Databases → MySQL Databases** → tạo database mới, ghi lại: tên database, username, password, host (thường là `localhost`).
4. Vào **Advanced → SSH Access** → bật SSH, ghi lại host/port/username để dùng ở bước sau.
5. Vào **Domains → SSL** → bật SSL miễn phí (Let's Encrypt) cho domain.

## 2. Trỏ document root vào thư mục `public/`

Vào **Websites → (chọn site) → Advanced → Document Root**, sửa đường dẫn thành:

```
/home/<username>/domains/<domain>/public_html/current/public
```

(Ở đây `current/` là thư mục chứa toàn bộ code Laravel sẽ được đưa lên qua GitHub Actions — xem mục 4. Nếu Hostinger không cho phép custom document root ở gói bạn đang dùng, xem phương án dự phòng ở mục 6.)

## 3. Chuẩn bị `.env` production

SSH vào server (hoặc dùng File Manager), tại thư mục gốc dự án (`current/`), tạo file `.env` **không commit lên Git**:

```bash
cp .env.example .env
nano .env
```

Điền tối thiểu:

```env
APP_NAME="VIETTC., JSC"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://vietthang.vn

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=<tên database Hostinger>
DB_USERNAME=<user database Hostinger>
DB_PASSWORD=<mật khẩu database>

MAIL_MAILER=smtp
MAIL_HOST=<SMTP Hostinger, vd smtp.hostinger.com>
MAIL_PORT=587
MAIL_USERNAME=<email SMTP>
MAIL_PASSWORD=<mật khẩu email>
MAIL_FROM_ADDRESS="info@vietthang.vn"
MAIL_ADMIN_NOTIFY_ADDRESS="info@vietthang.vn"

ADMIN_EMAIL=admin@vietthang.vn
ADMIN_PASSWORD=<đặt một mật khẩu mạnh — chỉ dùng cho lần seed đầu tiên>
```

Sau đó tạo `APP_KEY` (chỉ làm **một lần**, không chạy lại sau này vì sẽ làm hỏng session/dữ liệu đã mã hoá):

```bash
php artisan key:generate
```

## 4. Thiết lập GitHub Actions để tự động deploy

Repo đã có sẵn workflow tại `.github/workflows/deploy.yml`. Khi push lên nhánh `main`, GitHub Actions sẽ:
1. Cài `composer install --no-dev --optimize-autoloader`.
2. Chạy `npm ci && npm run build` để build CSS/JS.
3. Đẩy toàn bộ file (trừ `.env`, `.git`, thư mục dev) lên Hostinger qua SFTP.
4. (Nếu cấu hình SSH secrets) SSH vào server chạy `migrate --force`, `storage:link`, `config:cache`.

### Cấu hình secrets trên GitHub

Vào repo trên GitHub → **Settings → Secrets and variables → Actions → New repository secret**, thêm:

| Secret | Giá trị |
|---|---|
| `SFTP_HOST` | Host SFTP Hostinger (xem trong hPanel → SSH Access) |
| `SFTP_USERNAME` | Username SSH/SFTP |
| `SFTP_PASSWORD` | Mật khẩu (hoặc dùng SSH key — khuyến nghị hơn) |
| `SFTP_REMOTE_PATH` | Đường dẫn thư mục đích, vd `/home/<username>/domains/<domain>/public_html/current` |
| `SSH_PRIVATE_KEY` | (Tuỳ chọn, nếu dùng SSH key thay vì mật khẩu) |

**Lần đầu tiên deploy thủ công** (trước khi bật Actions), khuyến nghị:
1. SSH vào server, `git clone <repo-url> current` để lấy code lần đầu (hoặc để GitHub Actions tự tạo thư mục).
2. Tạo `.env` (mục 3), chạy `composer install --no-dev`, `npm install && npm run build` (nếu server có Node; nếu không, để GitHub Actions build và đẩy `public/build` lên).
3. `php artisan migrate --seed --force`
4. `php artisan storage:link`
5. `php artisan config:cache && php artisan route:cache && php artisan view:cache`

Từ lần sau, chỉ cần `git push` lên `main` — Actions sẽ tự làm lại các bước build & deploy file.

## 5. Kiểm tra sau khi deploy

1. Truy cập `https://<domain>` — trang chủ phải hiển thị đúng (kiểm tra HTTPS khoá xanh).
2. Truy cập `https://<domain>/admin` — đăng nhập bằng tài khoản `ADMIN_EMAIL`/`ADMIN_PASSWORD` đã đặt ở bước 3.
3. **Đổi mật khẩu admin ngay** (Menu người dùng → hoặc vào `/admin/users` sửa tài khoản).
4. Vào `/admin/manage-settings` cập nhật lại thông tin công ty nếu cần (địa chỉ, điện thoại, logo...).
5. Thử tạo 1 sản phẩm test, publish, kiểm tra hiển thị đúng ở `/san-pham`, sau đó xoá sản phẩm test.
6. Thử gửi form Liên hệ, kiểm tra email nhận được và lead xuất hiện trong `/admin/contact-messages`.

## 6. Phương án dự phòng — gói hosting không hỗ trợ custom document root / không có SSH

Nếu gói Hostinger không cho đổi document root:
1. Đặt toàn bộ code Laravel ra ngoài `public_html` (vd `/home/<user>/laravel-app/`).
2. Copy nội dung thư mục `public/` của Laravel vào `public_html/`.
3. Sửa `public_html/index.php`: đổi 2 dòng `require __DIR__.'/../vendor/autoload.php'` và `$app = require_once __DIR__.'/../bootstrap/app.php'` thành đường dẫn trỏ tới `../laravel-app/vendor/autoload.php` và `../laravel-app/bootstrap/app.php`.

Nếu không có SSH: upload code qua File Manager/FTP (không qua GitHub Actions tự động), và chạy các lệnh `artisan` một lần duy nhất qua một route tạm thời được bảo vệ bằng token bí mật (xoá route này ngay sau khi dùng xong) — không khuyến nghị cho lâu dài, nên nâng cấp gói có SSH khi có thể.

## 7. Backup & khôi phục trên Hostinger

### Backup tự động (khuyến nghị)
Vào hPanel → **Backups** — Hostinger có backup tự động hàng ngày/tuần tuỳ gói. Bật tính năng này làm lớp bảo vệ đầu tiên.

### Backup thủ công / bổ sung bằng cron
Vào hPanel → **Advanced → Cron Jobs**, tạo job chạy hàng đêm:

```bash
mysqldump -u <user> -p'<password>' <database> | gzip > /home/<username>/backups/db-$(date +\%F).sql.gz
```

Kèm theo lệnh dọn các bản backup cũ hơn 30 ngày:

```bash
find /home/<username>/backups -name "*.sql.gz" -mtime +30 -delete
```

### Khôi phục

```bash
gunzip < backup-file.sql.gz | mysql -u <user> -p <database>
```

File upload (ảnh/PDF sản phẩm) nằm trong `storage/app/public/` trên server — nên đưa thư mục này vào lịch backup/rsync định kỳ cùng với database.

## 8. Nâng cấp / cập nhật code sau này

```bash
git pull origin main          # hoặc để GitHub Actions tự động khi push
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

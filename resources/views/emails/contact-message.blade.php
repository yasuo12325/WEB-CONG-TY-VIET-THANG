<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; color: #16295a; line-height: 1.6;">
    <h2>Liên hệ mới từ website</h2>

    <p><strong>Họ tên:</strong> {{ $contactMessage->name }}</p>
    <p><strong>Email:</strong> {{ $contactMessage->email }}</p>
    <p><strong>Điện thoại:</strong> {{ $contactMessage->phone ?: '—' }}</p>
    <p><strong>Tiêu đề:</strong> {{ $contactMessage->subject ?: '—' }}</p>

    <p><strong>Nội dung:</strong></p>
    <p style="white-space: pre-line;">{{ $contactMessage->message }}</p>

    <p>
        <a href="{{ url('/admin/contact-messages/'.$contactMessage->id.'/edit') }}"
           style="display:inline-block;padding:10px 20px;background:#d4a537;color:#050b1a;text-decoration:none;border-radius:4px;font-weight:bold;">
            Xem trong trang quản trị
        </a>
    </p>

    <p style="color:#888;font-size:12px;">{{ config('app.name') }}</p>
</body>
</html>

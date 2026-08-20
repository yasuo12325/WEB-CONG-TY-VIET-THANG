@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">Giới thiệu công ty</h1>
            <p class="mt-2 text-white/60">{{ $settings['company_name_intl'] }} ({{ $settings['company_short_name'] }})</p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 lg:px-8">
        <div class="grid grid-cols-1 gap-8 rounded-md border border-gray-100 bg-gray-50 p-6 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="text-xs uppercase tracking-wider text-gray-400">Thành lập</div>
                <div class="mt-1 text-xl font-bold text-navy-900">{{ $settings['founded_year'] }}</div>
            </div>
            <div>
                <div class="text-xs uppercase tracking-wider text-gray-400">Vốn điều lệ</div>
                <div class="mt-1 text-xl font-bold text-navy-900">{{ $settings['charter_capital'] }}</div>
            </div>
            <div>
                <div class="text-xs uppercase tracking-wider text-gray-400">Nhân sự</div>
                <div class="mt-1 text-xl font-bold text-navy-900">{{ $settings['employee_count'] }} người</div>
            </div>
            <div>
                <div class="text-xs uppercase tracking-wider text-gray-400">Tổng Giám đốc</div>
                <div class="mt-1 text-xl font-bold text-navy-900">{{ $settings['ceo_name'] }}</div>
            </div>
        </div>

        <div class="prose mt-10 max-w-none text-gray-700">
            <h2>Quá trình hình thành và phát triển</h2>
            <p>
                Tháng 04 năm 2003, {{ $settings['company_name'] }} chính thức khai trương và đi vào hoạt động,
                với tên giao dịch quốc tế {{ $settings['company_name_intl'] }} ({{ $settings['company_short_name'] }}).
            </p>
            <p>
                Tiền thân là một công ty chuyên hoạt động trong lĩnh vực kinh doanh xuất nhập khẩu các mặt hàng máy móc,
                thiết bị và công nghệ phục vụ ngành an ninh – quốc phòng. Đến nay, ngoài khả năng cung cấp các thiết bị
                máy móc đặc chủng, công ty còn phối hợp với các viện nghiên cứu, đơn vị nghiệp vụ trong và ngoài nước để
                thực hiện các giải pháp tư vấn, chuyển giao công nghệ.
            </p>
            <p>
                Công ty đã tự sản xuất một số trang thiết bị nghiệp vụ đặc biệt có chất lượng công nghệ cao phục vụ an
                ninh – quốc phòng. Với đội ngũ chuyên gia hàng đầu, được đào tạo bài bản trong và ngoài nước, công ty
                luôn tự hào là đơn vị bảo hành, bảo trì tốt nhất, kịp thời nhất và trách nhiệm nhất đối với các trang
                thiết bị, hệ thống đã cung cấp cho chủ đầu tư. Trải qua hơn 20 năm xây dựng và phát triển, công ty đã
                được nhiều cơ quan tín nhiệm và trao tặng bằng khen.
            </p>

            <h2>Cơ cấu tổ chức</h2>
            <p>{{ $settings['company_short_name'] }} được tổ chức gồm 5 phòng ban chịu sự quản lý trực tiếp của Ban Giám đốc:</p>
            <ul>
                <li><strong>Phòng Dự án &amp; Thương mại</strong> — nghiên cứu, tư vấn lập hồ sơ, triển khai dự án, phát triển thị trường và sản phẩm mới.</li>
                <li><strong>Phòng Tài chính - Hành chính, Nhân sự</strong> — quản lý tài chính, kế toán và nhân sự công ty.</li>
                <li><strong>Phòng Kỹ thuật &amp; Giải pháp</strong> — nghiên cứu, đánh giá chất lượng thiết bị, phối hợp chuyển giao công nghệ.</li>
                <li><strong>Phòng Nghiên cứu chế tạo</strong> — nghiên cứu và chế tạo các sản phẩm phục vụ dự án của công ty.</li>
                <li><strong>Phòng Bảo hành &amp; Bảo trì</strong> — chịu trách nhiệm bảo hành, bảo trì sản phẩm sau bán hàng.</li>
            </ul>

            <h2>Trụ sở &amp; văn phòng giao dịch</h2>
            <p><strong>Trụ sở chính:</strong> {{ $settings['headquarters_address'] }}</p>
            <p><strong>Văn phòng giao dịch:</strong> {{ $settings['office_address'] }}</p>
        </div>
    </section>
@endsection

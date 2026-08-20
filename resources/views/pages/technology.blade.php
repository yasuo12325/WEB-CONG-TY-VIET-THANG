@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">Công nghệ &amp; Chuyển giao công nghệ</h1>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 lg:px-8">
        <div class="prose max-w-none text-gray-700">
            <p>
                Bên cạnh việc nhập khẩu và phân phối các thiết bị An ninh - Quốc phòng đặc chủng, {{ config('app.name') }}
                còn phối hợp với các viện nghiên cứu, đơn vị nghiệp vụ và nhà sản xuất uy tín trong và ngoài nước để
                thực hiện tư vấn, chuyển giao công nghệ và tự sản xuất một số trang thiết bị nghiệp vụ đặc biệt.
            </p>

            <h2>Công nghệ và dây chuyền sản xuất</h2>
            <ul>
                <li>Công nghệ và dây chuyền sản xuất các trang thiết bị nghiệp vụ đặc biệt phục vụ an ninh - quốc phòng.</li>
                <li>Công nghệ lắp ráp Camera CCTV giám sát.</li>
            </ul>

            <h2>Đội ngũ kỹ thuật</h2>
            <p>
                Đội ngũ chuyên gia được đào tạo bài bản trong và ngoài nước, có văn bằng, chứng chỉ do các nhà sản xuất
                cấp — đảm bảo năng lực tư vấn kỹ thuật, tích hợp hệ thống, lắp đặt, bảo hành và bảo trì tốt nhất, kịp
                thời nhất cho khách hàng.
            </p>
        </div>
    </section>
@endsection

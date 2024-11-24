<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('output.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    </head>
    <body>
        <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
            <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px]">
                <a href="{{ route('front.check_booking') }}">
                    <img src="{{ asset('assets/images/icons/back.svg') }}" class="w-10 h-10" alt="icon">
                </a>
                <p class="font-bold text-lg leading-[27px]">Detail Pesanan</p>
                <div class="dummy-btn w-10"></div>
            </div>
            <section id="your-order" class="accordion flex flex-col rounded-[20px] p-4 pb-5 gap-5 mx-4 bg-white overflow-hidden transition-all duration-300 has-[:checked]:!h-[66px]">
                <label class="group flex items-center justify-between">
                    <h2 class="font-bold text-xl leading-[30px]">Pesanan</h2>
                    <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" class="w-7 h-7 transition-all duration-300 group-has-[:checked]:rotate-180" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="flex items-center gap-[14px]">
                    <div class="flex shrink-0 w-20 h-20 rounded-[20px] p-1 overflow-hidden">
                        <img src="{{ Storage::url($orderDetails->food->photos()->latest()->first()->photo) }}" class="w-full h-full object-contain" alt="">
                    </div>
                    <h3 class="font-bold text-lg leading-6">{{ $orderDetails->food->name }}</h3>
                </div>
                <hr class="border-[#EAEAED]">
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Penjual</p>
                    <p class="font-bold">{{ $orderDetails->food->seller->name }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Harga</p>
                    <p class="font-bold">Rp {{number_format($orderDetails->food->price, 0, ',', '.')}}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Jumlah</p>
                    <p class="font-bold">{{ $orderDetails->quantity }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Total Harga</p>
                    <p class="font-bold text-2xl leading-9 text-[#07B704]">Rp {{number_format($orderDetails->grand_total_amount, 0, ',', '.')}}</p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Waktu </p>
                    <p class="font-bold">{{ $orderDetails->created_at }}</p>
                </div>

                @if($orderDetails->is_paid)
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Status</p>
                    <p class="rounded-full p-[6px_14px] bg-[#07B704] font-bold text-sm leading-[21px] text-white">SUCCESS</p>
                </div>
                @else
                <div class="flex items-center justify-between">
                    <p class="font-semibold">Status</p>
                    <p class="rounded-full p-[6px_14px] bg-[#2A2A2A] font-bold text-sm leading-[21px] text-white">PENDING</p>
                </div>
                @endif

            </section>
            <section id="customer" class="accordion flex flex-col rounded-[20px] p-4 pb-5 gap-5 mx-4 bg-white overflow-hidden transition-all duration-300 has-[:checked]:!h-[66px] mb-10">
                <label class="group flex items-center justify-between">
                    <h2 class="font-bold text-xl leading-[30px]">Data Pembeli</h2>
                    <img src="{{ asset('assets/images/icons/arrow-up.svg') }}" class="w-7 h-7 transition-all duration-300 group-has-[:checked]:rotate-180" alt="icon">
                    <input type="checkbox" class="hidden">
                </label>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/delivery.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">ID Pesanan</p>
                        <p class="font-bold">{{ $orderDetails->booking_trx_id }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/user.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Nama</p>
                        <p class="font-bold">{{ $orderDetails->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/sms.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Email</p>
                        <p class="font-bold">{{ $orderDetails->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/call.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">NIM</p>
                        <p class="font-bold">{{ $orderDetails->nim }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/call.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Fakultas</p>
                        <p class="font-bold">{{ $orderDetails->faculty }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <img src="{{ asset('assets/images/icons/house-2.svg') }}" class="w-6 h-6 flex shrink-0" alt="icon">
                    <div class="flex flex-col gap-[6px]">
                        <p class="font-semibold">Jurusan</p>
                        <p class="font-bold">{{ $orderDetails->major }}</p>
                    </div>
                </div>
                <hr class="border-[#EAEAED]">
                <a href="{{ route('front.index') }}" class="rounded-full p-[12px_20px] text-center w-full bg-[#C5F277] font-bold">Yuk kembali order jajanan!</a>
                <hr class="border-[#EAEAED]">
                <div class="flex items-center gap-[10px]">
                    <img src="{{ asset('assets/images/icons/shield-tick.svg') }}" class="w-8 h-8 flex shrink-0" alt="icon">
                    <p class="leading-[26px]">ihatkan detail pesanan ini kepada penjual untuk dapat mengambil jajanan yang dibeli</p>
                </div>
            </section>
        </div>

        <script src="{{ asset('js/accordion.js') }}"></script>
    </body>
</html>
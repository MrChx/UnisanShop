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
                <a href="{{ route('front.booking', ['food' =>$food->slug]) }}">
                    <img src="{{asset('assets/images/icons/back.svg')}}" class="w-10 h-10" alt="icon">
                </a>
                <p class="font-bold text-lg leading-[27px]">Pengecekan</p>
                <div class="dummy-btn w-10"></div>
            </div>
            <div class="flex items-center rounded-3xl gap-[14px] p-[10px_16px_16px_10px] bg-white mx-4">
                <div class="flex shrink-0 w-20 h-20 rounded-2xl p-1 overflow-hidden">
                    <img src="{{ Storage::url($food->photos()->latest()->first()->photo) }}" class="w-full h-full object-contain" alt="">
                </div>
                <div class="flex flex-col w-full">
                    <h1 id="title" class="font-bold text-lg leading-6">{{ $food->name }}</h1>
                    <p class="font-semibold text-sm leading-[21px]">{{ $food->seller->name }}</p>
                </div>
                <div class="flex items-center shrink-0 gap-1">
                    {{-- <img src="{{asset('assets/images/icons/Star 1.svg')}}" class="w-[22px] h-[22px]" alt="star"> --}}
                    <h1 id="title" class="font-bold text-lg leading-6">( {{ $orderData['quantity'] }} )</h1>
                </div>
            </div>
            <form action="{{route('front.save_costumer_data')}}" method="POST" class="flex flex-col gap-5">
                @csrf
                <div class="flex flex-col rounded-[20px] p-4 mx-4 pb-5 gap-5 bg-white">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <h1 id="title" class="font-bold text-[22px] leading-9[30px]">Masukan Data</h1>
                        </div>
                    </div>
                    <hr class="border-[#EAEAED]">
                    <div class="flex flex-col gap-2">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="phone" class="font-semibold">NIM</label>
                        <div class="flex items-center w-full rounded-full ring-1 ring-[#090917] px-[14px] gap-[10px] overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-[#FFC700]">
                            <img src="{{asset('assets/images/icons/admin2.png')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <input type="text" name="nim" id="phone" class="appearance-none outline-none w-full font-semibold placeholder:font-normal placeholder:text-[#878785] py-[14px]" placeholder="Masukan nim">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="city" class="font-semibold">Fakultas</label>
                        <div class="flex items-center w-full rounded-full ring-1 ring-[#090917] px-[14px] gap-[10px] overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-[#FFC700]">
                            <img src="{{asset('assets/images/icons/admin2.png')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <input type="text" name="faculty" id="city" class="appearance-none outline-none w-full font-semibold placeholder:font-normal placeholder:text-[#878785] py-[14px]" placeholder="Masukan fakultas">
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="post" class="font-semibold">Jurusan</label>
                        <div class="flex items-center w-full rounded-full ring-1 ring-[#090917] px-[14px] gap-[10px] overflow-hidden transition-all duration-300 focus-within:ring-2 focus-within:ring-[#FFC700]">
                            <img src="{{asset('assets/images/icons/admin2.png')}}" class="w-6 h-6 flex shrink-0" alt="icon">
                            <input type="text" name="major" id="post" class="appearance-none outline-none w-full font-semibold placeholder:font-normal placeholder:text-[#878785] py-[14px]" placeholder="Masukan jurusan">
                        </div>
                    </div>
                    <hr class="border-[#EAEAED]">
                    <div class="flex items-center gap-[10px]">
                        <img src="{{asset('assets/images/icons/shield-tick.svg')}}" class="w-8 h-8 flex shrink-0" alt="icon">
                        <p class="leading-[26px]">UnisanShop melindungi data anda dengan baik dan amanah.</p>
                    </div>
                </div>
                <div id="bottom-nav" class="relative flex h-[100px] w-full shrink-0 mt-5">
                    <div class="fixed bottom-5 w-full max-w-[640px] z-30 px-4">
                        <div class="flex items-center justify-between rounded-full bg-[#2A2A2A] p-[10px] pl-6">
                            <div class="flex flex-col gap-[2px]">
                                <p id="grand-total" class="font-bold text-[20px] leading-[30px] text-white">Rp {{number_format($orderData['grand_total_amount'], 0, ',', '.')}}</p>
                                <p class="text-sm leading-[21px] text-[#878785]">Total Harga</p>
                            </div>
                            <button type="submit" class="rounded-full p-[12px_20px] bg-[#C5F277] font-bold">
                                Continue
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
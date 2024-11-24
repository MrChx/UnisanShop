<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('output.css')}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    </head>
    <body>
        <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
            <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px]">
                <a href="{{ route('front.index') }}">
                    <img src="assets/images/icons/back.svg" class="w-10 h-10" alt="icon">
                </a>
                <p class="font-bold text-lg leading-[27px]">Jajanan</p>
                <div class="dummy-btn w-10"></div>
            </div>
            {{-- <div class="px-4">
                <div class="flex items-center justify-between w-full rounded-2xl overflow-hidden bg-white">
                    <div class="flex flex-col gap-[2px] px-[30px] pr-4">
                        <h3 class="font-bold text-[22px] leading-[33px]">Lifestyle</h3>
                        <p class="text-[#878785]">6,223 Shoes</p>
                    </div>
                    <div class="flex shrink-0 w-[140px] h-[120px] overflow-hidden">
                        <img src="assets/images/thumbnails/photo1.png" class="w-full h-full object-cover object-left" alt="thumbnail">
                    </div>
                </div>
            </div> --}}
            <section id="fresh" class="flex flex-col gap-4 px-4 mb-[111px]">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold leading-[20px]">Lihat semua jajanan</h2>
                </div>
                <div class="flex flex-col gap-4">

                    @forelse ($popularFood as $itemPopularFood)
                        <a href="details.html">
                            <div class="flex items-center rounded-3xl p-[10px_16px_16px_10px] gap-[14px] bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700]">
                                <div class="w-20 h-20 flex shrink-0 rounded-2xl bg-[#D9D9D9] overflow-hidden">
                                    <img src="{{ Storage::url($itemPopularFood->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                                </div>
                                <div class="flex w-full items-center justify-between gap-[14px]">
                                    <div class="flex flex-col gap-[6px]">
                                        <h3 class="font-bold leading-[20px]">{{ $itemPopularFood->name }}</h3>
                                        <p class="text-sm leading-[21px] text-[#878785]">{{ $itemPopularFood->seller->name }}</p>
                                    </div>
                                    <div class="flex flex-col gap-1 items-end shrink-0">
                                        <div class="flex">
                                        </div>
                                        <p class="font-semibold text-sm leading-[21px]">{{ $itemPopularFood->category->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p>Belum ada makanan</p>
                    @endforelse
                </div>        
            </section>
            <div id="bottom-nav" class="relative flex h-[100px] w-full shrink-0">
                <nav class="fixed bottom-5 w-full max-w-[640px] px-4 z-30">
                    <div class="grid grid-flow-col auto-cols-auto items-center justify-between rounded-full bg-[#2A2A2A] p-2 px-[30px]">
                        <a href="{{ route('front.index') }}" class="mx-auto w-full">
                            <img src="{{ asset('assets/images/icons/3dcube-white.svg') }}" class="w-6 h-6" alt="icon">
                        </a>
                        <a href="{{ route('front.check_booking') }}" class="mx-auto w-full">
                            <img src="{{asset ('assets/images/icons/bag-2-white.svg')}}" class="w-6 h-6" alt="icon">
                        </a>
                        <a href="{{ route('front.viewAll') }}" class="active flex shrink-0 -mx-[22px]">
                            <div class="flex items-center rounded-full gap-[10px] p-[12px_16px] bg-[#C5F277]">
                                <img src="{{ asset('assets/images/icons/bag-2.svg') }}" class="w-6 h-6" alt="icon">
                                <span class="font-bold text-sm leading-[21px]">Jajanan</span>
                            </div>
                        </a>
                        <a href="{{ url('admin/login') }}" class="mx-auto w-full">
                            <img src="{{ asset('assets/images/icons/24-support-white.svg') }}" class="w-6 h-6" alt="icon">
                        </a>
                    </div>
        </div>
    </body>
</html>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('output.css')}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    </head>
    <body>
        <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
            <div id="top-bar" class="flex justify-between items-center px-4 mt-4">
                <img src="{{asset ('assets/images/icons/logo3.png')}}" class="w-20 h-auto" alt="logo">
                <a href="#">
                    <img src="{{asset ('assets/images/icons/notification.svg')}}" class="w-10 h-10" alt="icon">
                </a>
            </div>
            <form action="{{ route('front.search') }}" class="flex justify-between items-center mx-4">
                <div class="relative flex items-center w-full rounded-l-full px-[14px] gap-[10px] bg-white transition-all duration-300 focus-within:ring-2 focus-within:ring-[#FFC700]">
                    <img src="{{asset ('assets/images/icons/search-normal.svg')}}" class="w-6 h-6" alt="icon">
                    <input type="text" name="keyword" class="w-full py-[14px] appearance-none bg-white outline-none font-semibold placeholder:font-normal placeholder:text-[#878785]" placeholder="Cari jajanmu...">
                </div>
                <button type="submit" class="h-full rounded-r-full py-[14px] px-5 bg-[#C5F277]">
                    <span class="font-semibold">Cari</span>
                </button>
            </form>
            <section id="category" class="flex flex-col gap-4 px-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold leading-[20px]">Kategori</h2>
                </div>
                <div class="grid grid-cols-2 gap-4">

                    @forelse ($categories as $itemCategory)
                        <a href="{{ route('front.category', $itemCategory->slug) }}">
                            <div class="flex items-center justify-between w-full rounded-2xl overflow-hidden bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700]">
                                <div class="flex flex-col gap-[2px] px-[14px]">
                                    <h3 class="font-bold text-sm leading-[21px]">{{ $itemCategory->name }}</h3>
                                    <p class="text-xs leading-[18px] text-[#878785]">{{ $itemCategory->food->count() }}</p>
                                </div>
                                <div class="flex shrink-0 w-20 h-[90px] overflow-hidden">
                                    <img src="{{ Storage::url($itemCategory->icon) }}" class="w-full h-full object-cover object-left" alt="thumbnail">
                                </div>
                            </div>
                        </a>
                    @empty
                        <p>Balum ada data terbaru</p>
                    @endforelse
                    
                </div>
            </section>
            <section id="featured" class="flex flex-col gap-4">
                <div class="flex items-center justify-between px-4">
                    <h2 class="font-bold leading-[20px]">Jajanan</h2>
                </div>
                <div class="swiper w-full overflow-hidden">
                    <div class="swiper-wrapper">

                        @forelse ($popularFood as $itemPopularFood)
                            <div class="swiper-slide !w-fit py-[2px]">
                                <a href="{{ route('front.details', $itemPopularFood->slug) }}">
                                    <div class="flex flex-col shrink-0 w-[230px] h-full rounded-3xl gap-[14px] p-[10px] pb-4 bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700]">
                                        <div class="w-[210px] h-[230px] rounded-3xl bg-[#D9D9D9] overflow-hidden">
                                            <img src="{{ Storage::url($itemPopularFood->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                                        </div>
                                        <div class="flex flex-col gap-[14px] justify-between">
                                            <div class="flex items-center justify-between gap-4">
                                                <h3 class="font-bold leading-[20px]">{{ $itemPopularFood->name }}</h3>
                                                <p class="font-bold text-sm leading-[21px] text-nowrap">
                                                    Rp {{ number_format($itemPopularFood->price, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="flex items-center justify-between gap-2">
                                                <div class="flex items-center gap-1">
                                                    <p class="font-semibold text-sm leading-[21px]">{{ $itemPopularFood->stock}} Stok</p>
                                                </div>
                                                <p class="text-sm leading-[21px] text-[#878785]">{{ $itemPopularFood->category->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p>Belum ada data terbaru</p>
                        @endforelse

                    </div>
                </div>
            </section>
            <section id="fresh" class="flex flex-col gap-4 px-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold leading-[20px]">Terbaru</h2>
                </div>
                <div class="flex flex-col gap-4">

                    @forelse ($newFood as $itemNewFood)
                    <a href="{{ route('front.details', $itemNewFood->slug) }}">
                        <div class="flex items-center rounded-3xl p-[10px_16px_16px_10px] gap-[14px] bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700]">
                            <div class="w-20 h-20 flex shrink-0 rounded-2xl bg-[#D9D9D9] overflow-hidden">
                                <img src="{{ Storage::url($itemNewFood->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                            </div>
                            <div class="flex w-full items-center justify-between gap-[14px]">
                                <div class="flex flex-col gap-[6px]">
                                    <h3 class="font-bold leading-[20px]">{{ $itemNewFood->name }}</h3>
                                    <p class="text-sm leading-[21px] text-[#878785]">{{ $itemNewFood->category->name }}</p>
                                </div>
                                <div class="flex flex-col gap-1 items-end shrink-0">
                                    <div class="flex">
                                        <img src="{{asset ('assets/images/icons/Star 1.svg')}}" class="w-[18px] h-[18px] flex shrink-0" alt="star"><p class="font-semibold text-sm leading-[21px]">4.5</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <p>Belum ada data terbaru</p>
                    @endforelse
                    
                </div>
            </section>
            <div id="bottom-nav" class="relative flex h-[100px] w-full shrink-0">
                <nav class="fixed bottom-5 w-full max-w-[640px] px-4 z-30">
                    <div class="grid grid-flow-col auto-cols-auto items-center justify-between rounded-full bg-[#2A2A2A] p-2 px-[30px]">
                        <a href="index.html" class="active flex shrink-0 -mx-[22px]">
                            <div class="flex items-center rounded-full gap-[10px] p-[12px_16px] bg-[#C5F277]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                                    <path
                                      d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,160H40V56H216V200ZM176,88a48,48,0,0,1-96,0,8,8,0,0,1,16,0,32,32,0,0,0,64,0,8,8,0,0,1,16,0Z"
                                    ></path>
                                  </svg>
                                <span class="font-bold text-sm leading-[21px]">Menu</span>
                            </div>
                        </a>
                        <a href="{{ route('front.check_booking') }}" class="mx-auto w-full">
                            <img src="{{asset ('assets/images/icons/bag-2-white.svg')}}" class="w-6 h-6" alt="icon">
                        </a>
                        <a href="{{ route('front.viewAll') }}" class="mx-auto w-full">
                            <img src="{{asset ('assets/images/icons/cari.png')}}" class="w-6 h-6" alt="icon">
                        </a>
                        <a href="{{ url('admin/login') }}" class="mx-auto w-full">
                            <img src="{{asset ('assets/images/icons/admin.png')}}" class="w-6 h-6" alt="icon">
                        </a>
                    </div>
                </nav>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="{{ asset('js/index.js') }}"></script>
    </body>
</html>
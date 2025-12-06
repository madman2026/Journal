@props([
    'containerClass' => null,
    'swiperId' => 'swiper_' . rand(10, 99999),
    'items',
    'defaultLink',
    'type'
])

<div class="relative {{ $containerClass }} mb-6 w-full overflow-hidden rounded-2xl shadow-lg">
    <div class="swiper {{ $swiperId }}">
        <div class="swiper-wrapper">

            @foreach($items as $item)
                @php
                    $link = $item['slug']
                        ? route("$type.show", $item['slug'])
                        : $defaultLink;
                @endphp

                <a href="{{ $link }}" class="swiper-slide relative block select-none">
                    <img
                        src="{{ asset($item['image']) }}"
                        alt="{{ $item['title'] }}"
                        class="w-full h-72 md:h-96 rounded-2xl object-cover transition-transform duration-300 hover:scale-[1.03]
                        {{ $item['title'] === 'موسسه جواد الائمه' ? 'opacity-40' : '' }}"
                    >

                    <div class="absolute bottom-0 left-0 right-0 p-4 rounded-b-2xl bg-gradient-to-t from-black/80 to-transparent">
                        <h4 class="text-white font-bold text-lg drop-shadow">{{ $item['title'] }}</h4>

                        @if(!empty($item['body']))
                            <p class="text-white/90 text-sm mt-1">
                                {{ Str::limit($item['body'], 100) }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach

        </div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev !text-white"></div>
        <div class="swiper-button-next !text-white"></div>
        <div class="swiper-scrollbar"></div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {

    const selector = ".{{ $swiperId }}";

    new window.Swiper(selector, {
        slidesPerView: 1,
        spaceBetween: 30,

        pagination: {
            el: `${selector} .swiper-pagination`,
            clickable: true,
        },

        navigation: {
            nextEl: `${selector} .swiper-button-next`,
            prevEl: `${selector} .swiper-button-prev`,
        },

        scrollbar: {
            el: `${selector} .swiper-scrollbar`,
        },

        autoplay: {
            delay: 2500,
        },

        breakpoints: {
            1200: { slidesPerView: 4 },
            1024: { slidesPerView: 3 },
            800:  { slidesPerView: 2 },
            100:  { slidesPerView: 1 },
        }
    });

});
</script>
@endpush

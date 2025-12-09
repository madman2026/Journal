<div class="relative {{ $containerClass }} mb-4 w-full h-full overflow-hidden rounded-lg shadow-lg">
    <div id="{{ $swiperId }}" class="swiper">
        <div class="swiper-wrapper">
            @foreach($items as $item)
                <a class="swiper-slide" href="{{ !empty($item['slug']) ? route("$type.show", $item['slug']) : $defaultLink }}">
                    <img src="{{ asset($item['image'] ?? 'images/placeholder.png') }}"
                         alt="{{ $item['title'] ?? 'بدون عنوان' }}"
                         loading="lazy"
                         class="w-full h-96 rounded-2xl object-cover transition-transform duration-300 transform {{ ($item['title'] ?? '') === 'موسسه جواد الائمه' ? 'opacity-40' : '' }}" />
                    <div class="absolute rounded-b-2xl bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black to-transparent">
                        <h4 class="text-lg text-white font-bold">{{ $item['title'] ?? 'بدون عنوان' }}</h4>
                        <p class="text-sm text-white">{{ Illuminate\Support\Str::limit($item['body'] ?? '', 100) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev" aria-label="Previous slide"></div>
        <div class="swiper-button-next" aria-label="Next slide"></div>
        <div class="swiper-scrollbar"></div>
    </div>
</div>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">????? ? ??????</h1>

    @if($news->count())
        <div class="space-y-3">
            @foreach($news as $item)
                <a href="{{ route('magazine.show', $item->slug) }}" class="block rounded-lg bg-white/80 p-4 shadow hover:shadow-md transition">
                    <h2 class="font-semibold">{{ $item->title }}</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($item->body, 120) }}</p>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $news->links() }}
        </div>
    @else
        <p class="text-gray-600">????? ???? ????? ???? ?????.</p>
    @endif
</div>

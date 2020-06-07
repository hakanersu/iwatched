<x-app title="Series">
    <div class="container mx-auto">
        <x-filter/>
        <div class="popular-movies mb-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($movies as $movie)
                    <div>
                        <movie :title="{{ $movie }}" :key="{{ $movie->id }}"/>
                    </div>
                @endforeach
            </div>
        </div>
        {{ $movies->links() }}
    </div>
</x-app>

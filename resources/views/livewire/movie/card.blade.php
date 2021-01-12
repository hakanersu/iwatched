<div class="bg-white min-h-full flex flex-col shadow-md rounded-md">
    <div class="poster">
        <a href="{{ route('movies.show', [$movie->tconst]) }}">
            <img src="{{ $movie->image() }}" alt="{{ $movie->primary_title }}">
        </a>
    </div>
    <div class="flex flex-col flex-1 justify-between h-full">
        <div class="p-3">
            <div class="flex justify-between">
                <a href="{{ route('movies.show', [$movie->tconst]) }}">
                    <h1 class="text-gray-800 text-xl">{{ $movie->primary_title }}</h1>
                </a>
            </div>
            <h5 class="text-gray-500 text-sm">{{ $movie->genres }}</h5>
        </div>
        <div class="flex text-gray-800 p-3 justify-between items-center">
            <h3>{{ $movie->rating->average_rating ?? '-' }}</h3>
            <div class="flex items-center">
                <h3>{{ $movie->start_year }}</h3>
                <a href="https://www.imdb.com/title/{{ $movie->tconst }}" target="_blank" class="ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
                <svg wire:click="toggle" class="w-4 h-4 ml-2 cursor-pointer" fill="{{ $isWatched ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
            </div>
        </div>
    </div>
</div>

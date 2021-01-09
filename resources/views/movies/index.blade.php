<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movies') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:filter />
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach ($movies as $movie)
                    <div class="min-w-full min-h-full block">
                        <livewire:movie.card :movie="$movie" wire:key="movie-{{$movie->id}}" />
                    </div>
                @endforeach
            </div>
            <div class="py-3">
                {{ $movies->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
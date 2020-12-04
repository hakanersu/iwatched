<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $movie->primary_title }}
        </h2>
    </x-slot>
    <x-slot name="buttons">
        <livewire:watch-button :movie="$movie" wire:key="movie-{{$movie->id}}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md bg-white flex">
                <div class="bg-black">
                    <img src="{{ $movie->image() }}" alt="{{ $movie->primary_title }}" class="w-auto  poster">
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl leading-tight text-gray-800 mt-5 mb-3 mx-5 block">Directors</h3>
                    <table class="w-full mb-5">
                        <thead>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Name</th>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Job</th>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Birth year</th>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Death year</th>
                        </thead>
                        @foreach ($directors as $director)
                            <tr class="hover:bg-gray-100 border-b border-gray-200 py-10">
                                <td class="px-4 py-4">{{ $director->primary_name }}</td>
                                <td class="px-4 py-4">{{ collect(explode(',',$director->primary_profession))->map(fn($item) => \Str::ucfirst($item))->implode(',') }}</td>
                                <td class="px-4 py-4">{{ $director->birth_year ?? '-' }}</td>
                                <td class="px-4 py-4">{{ $director->death_year ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <h3 class="text-2xl leading-tight text-gray-800 mt-5 mb-3 mx-5 block">Writers</h3>
                    <table class="w-full">
                        <thead>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Name</th>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Job</th>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Birth year</th>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Death year</th>
                        </thead>
                        @foreach ($writers as $director)
                            <tr class="hover:bg-gray-100 border-b border-gray-200 py-10">
                                <td class="px-4 py-4">{{ $director->primary_name }}</td>
                                <td class="px-4 py-4">{{ collect(explode(',',$director->primary_profession))->map(fn($item) => \Str::ucfirst($item))->implode(',') }}</td>
                                <td class="px-4 py-4">{{ $director->birth_year ?? '-' }}</td>
                                <td class="px-4 py-4">
                                    @if($director->death_year)
                                        {{ $director->death_year }} ({{ $director->death_year-$director->birth_year }})
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <h3 class="text-2xl leading-tight text-gray-800 mt-5 mb-3 mx-5 block">Cast</h3>
                    <table class="w-full">
                        <thead>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Name</th>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Job</th>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Birth year</th>
                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Death year</th>
                        </thead>
                        @foreach ($movie->principal as $principal)
                            <tr class="hover:bg-gray-100 border-b border-gray-200 py-10">
                                <td class="px-4 py-4">{{ $principal->name->primary_name }}</td>
                                <td class="px-4 py-4">{{ \Str::ucfirst($principal->category) }}</td>
                                <td class="px-4 py-4">{{ $principal->name->birth_year ?? '-' }}</td>
                                <td class="px-4 py-4">
                                    @if($principal->name->death_year)
                                        {{ $principal->name->death_year }} ({{ $principal->name->death_year-$principal->name->birth_year }})
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

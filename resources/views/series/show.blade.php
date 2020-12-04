<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $series->primary_title }}
        </h2>
    </x-slot>
    <x-slot name="buttons">
        <livewire:watch-button :movie="$series" wire:key="movie-{{$series->id}}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-md bg-white flex">
                <div class="bg-black">
                    <img src="{{ $series->image() }}" alt="{{ $series->primary_title }}" class="w-auto  poster">
                </div>
                <div class="flex-1" x-data="{tab: 'season-1'}" x-cloak>
                    <div class="flex px-3 py-3">
                        @foreach ($seasons as $number => $season)
                            <x-step :step="$number"    @click="tab = 'season-{{ $number }}'"/>
                        @endforeach
                            <x-step step="Info" @click="tab = 'info'"/>
                    </div>
                    @foreach ($seasons as $season => $episodes)
                        <div id="season-{{ $season}}" x-show="tab === 'season-{{ $loop->index + 1 }}'">
                            <table class="w-full">
                                <thead>
                                <tr>
                                    <x-table.th title="#" />
                                    <x-table.th title="Title" />
                                    <x-table.th title=""/>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($episodes as $episode)
                                    <tr class="hover:bg-gray-100 py-10{{ $loop->last ? '' : ' border-b border-gray-200' }}">
                                        <td class="px-4 py-4 w-3 text-center" >{{  $loop->iteration }}</td>
                                        <td class="px-4 py-4">{{ $episode->original_title }}</td>
                                        <td class="px-4 py-4 text-right">
                                            <livewire:checkbox :episode="$episode" :name="$season.$loop->iteration" key="{{ $season.$loop->iteration }}"/>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                    <div x-show="tab === 'info'">
                        <h3 class="text-2xl leading-tight text-gray-800  mb-3 mx-3 block">Directors</h3>
                        <table class="w-full mb-5">
                            <thead>
                            <x-table.th title="Name" />
                            <x-table.th title="Job" />
                            <x-table.th title="Birth year" />
                            <x-table.th title="Death year" />
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
                            <x-table.th title="Name" />
                            <x-table.th title="Job" />
                            <x-table.th title="Birth year" />
                            <x-table.th title="Death year" />
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
                            <x-table.th title="Name" />
                            <x-table.th title="Job" />
                            <x-table.th title="Birth year" />
                            <x-table.th title="Death year" />
                            </thead>
                            @foreach ($series->principal as $principal)
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
    </div>
</x-app-layout>

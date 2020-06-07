<x-app :title="$title->primary_title">
    <div class="container mx-auto">
        <div class="flex items-stretch">
            <div class="w-64">
                <movie :title="{{ $title }}" />
            </div>
            <div class="flex-1 ml-3">

                <div class="bg-white shadow  rounded h-full relative overflow-hidden">
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
                        @foreach ($title->principal as $principal)
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
</x-app>

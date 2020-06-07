<x-app :title="$title->primary_title">
    <div class="container mx-auto">
        <series inline-template>
            <div class="flex items-stretch">
                <div class="w-64">
                    <movie :title="{{ $title }}"></movie>
                    <button @click="active = 'info'" class="bg-indigo-500 py-1 px-3 mt-3 text-white rounded w-full">Series info</button>
                </div>
                <div class="flex-1 ml-3">
                    <div class="bg-white shadow  rounded h-full relative overflow-hidden">
                        <ul class="flex p-3">
                          @foreach($seasons as $season)
                          <li class="mr-3">
                            <a
    					    	:class="{
                                    'border-blue-500 bg-blue-500 text-white': active === {{ $loop->iteration }},
                                    'border border-white text-blue-500 hover:bg-gray-200 hover:border-gray-200' : active !== {{ $loop->iteration}}}"
                                class="inline-block rounded py-1 px-3"
                                href="#"
                                @click.prevent="active = {{ $loop->iteration }}"
                            >
                                Season {{ $loop->iteration }}
                            </a>
                          </li>
                          @endforeach
                        </ul>
{{--                        <div>--}}
{{--                            <div class="mx-auto p-5 text-center">--}}
{{--                                <div class="mx-auto loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-10 w-10"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        @foreach ($seasons as $season => $episodes)
                            <div id="season-{{ $season}}" v-if="active === {{ $season }}">
                                 <table class="w-full">
                                    <thead>
                                        <tr>
                                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">No.</th>
                                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Title</th>
                                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">Run Time</th>
                                            <th class="text-left bg-gray-100 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($episodes as $episode)
                                       <tr class="hover:bg-gray-100 py-10{{ $loop->last ? '' : ' border-b border-gray-200' }}">
                                            <td class="px-4 py-4">{{  $loop->iteration }}</td>
                                            <td class="px-4 py-4">{{ $episode->original_title }}</td>
                                            <td class="px-4 py-4">{{ $episode->runtime_minutes === 'N' ? 'Unknown' : $episode->runtime_minutes. ' Minutes' }}</td>
                                            <td class="px-4 py-4">
                                                <div class="flex justify-end">
                                                    <checkbox :episode="{{ $episode }}" key="episode-{{ $episode->tconst }}"/>
                                                </div>
                                            </td>
                                       </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                        <div v-if="active === 'info'">
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
        </series>
    </div>
</x-app>

<div class="search-dropdown border py-2  ml-3 rounded flex-grow relative">
    <input type="search" wire:model.debounce.300ms="search" name="search" class="px-3 w-full outline-none border-0"  autocomplete="off" placeholder="Search your movie or tv show">
    @if (strlen($search) > 2)
    <ul class="absolute z-50 bg-white border border-gray-300 w-full rounded-md mt-2 text-gray-700 text-sm divide-y divide-gray-200">
        @forelse ($searchResults as $result)
        <li>
            <a href="/{{ $result->title_type === 'movie' ? 'movies' : 'series' }}/{{ $result->tconst }}" class="flex items-center px-4 py-4 hover:bg-gray-200 transition ease-in-out duration-150 justify-between">
                <div>
                    {{ $result->primary_title }}
                    <div class="text-sm text-gray-400">{{ $result->genres }} - {{ $result->start_year }}</div>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium leading-4 {{ $result->title_type === 'movie' ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800' }}">
                    {{ $result->title_type }}
                </span>
            </a>
        </li>
        @empty
        <li class="px-4 py-4">No results found for "{{ $search }}"</li>
        @endforelse
    </ul>
    @endif
</div>

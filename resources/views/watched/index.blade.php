<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Watched') }}
        </h2>
    </x-slot>
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded my-6">
        <table class="text-left w-full border-collapse">
                <thead>
                    <tr>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Type</th>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Title</th>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Year</th>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Rating</th>
                        <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Imdb</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr class="hover:bg-grey-lighter">
                        <td class="py-4 px-6 border-b border-grey-light">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium leading-4 {{ $item->title_type === 'movie' ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $item->title_type === 'movie' ? 'Movie' : 'TV Series' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 border-b border-grey-light">
                            <a href="{{ $item->url() }}">{{ $item->title->primary_title }}</a>
                        </td>
                        <td class="py-4 px-6 border-b border-grey-light text-sm">
                            {{ $item->title->start_year }}
                        </td>
                        <td class="py-4 px-6 border-b border-grey-light text-sm">
                            {{ optional($item->title->rating)->average_rating }}
                        </td>
                        <td class="py-4 px-6 border-b border-grey-light">
                            <a href="https://www.imdb.com/title/{{ $item->tconst }}" target="_blank">{{ $item->tconst }}</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="p-5">
                                There is no movies on your watched list.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            {{ $items->links() }}
    </div>
    </div>

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex  mx-auto bg-white p-5 shadow-lg rounded-lg">
                <div class="w-1/3 text-center">
                    <h1 class="text-5xl font-bold text-indigo-800 leading-none">{{ $watched->movie }}</h1>
                    <h3 class="text-gray-400 font-bold leading-6">Movies</h3>
                </div>
                <div class="w-1/3 text-center">
                    <h1 class="text-5xl font-bold text-indigo-800 leading-none">{{ $watched->tvseries }}</h1>
                    <h3 class="text-gray-400 font-bold leading-6">Tv series</h3>
                </div>
                <div class="w-1/3 text-center">
                    <h1 class="text-5xl font-bold text-indigo-800 leading-none">{{ $watched->tvepisode }}</h1>
                    <h3 class="text-gray-400 font-bold leading-6">Episodes</h3>
                </div>
            </div>

            <div class=" mx-auto bg-white shadow-md rounded my-6">
                <div class="text-center py-5 border-b">
                    <h1 class="text-2xl text-indigo-800 leading-none">Watched movies by release date</h1>
                </div>
                <table class="text-left w-full border-collapse">
                    @foreach($watchedByYears as $years)
                        <tr class="hover:bg-grey-lighter">
                            <td class="py-4 px-6 border-b border-grey-light">{{ $years->start_year }}</td>
                            <td class="py-4 px-6 border-b border-grey-light">{{ $years->count }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

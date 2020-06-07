@if ($paginator->hasPages())
    <div class="flex justify-between">
        @if ($paginator->onFirstPage())
            <button type="button" class="py-2 px-5 mt-4 bg-indigo-600 hover:bg-indigo-800 text-white rounded shadow outline-none appearance-none" rel="prev" aria-label="@lang('pagination.previous')">
                <span class="d-block d-md-none">@lang('pagination.previous')</span>
            </button>
        @else
            <button type="button" class="py-2 px-5 mt-4 bg-indigo-600 hover:bg-indigo-800 text-white rounded shadow outline-none appearance-none" wire:click.prevent="previousPage" rel="prev" aria-label="@lang('pagination.previous')">
                <span class="d-block d-md-none">@lang('pagination.previous')</span>
            </button>
        @endif

        @if ($paginator->hasMorePages())
            <button type="button" class="py-2 px-5 mt-4 bg-indigo-600 hover:bg-indigo-800 text-white rounded shadow outline-none appearance-none" wire:click.prevent="nextPage" rel="next" aria-label="@lang('pagination.next')">
                <span class="d-block d-md-none">@lang('pagination.next')</span>
            </button>
        @else
            <button type="button" class="py-2 px-5 mt-4 bg-indigo-600 hover:bg-indigo-800 text-white rounded shadow outline-none appearance-none" rel="next" aria-label="@lang('pagination.next')">
                <span class="d-block d-md-none">@lang('pagination.next')</span>
            </button>
        @endif

    </div>
@endif

<div>
    @if ($isWatched)
        <button wire:click="toggle" type="button" class="py-2 px-4 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none" tabindex="-1">Unwatch</button>
    @else
        <button wire:click="toggle" type="button" class="py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" tabindex="-1">Set watched</button>
    @endif

</div>

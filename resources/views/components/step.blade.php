<div {{ $attributes->merge(['class' => 'flex items-center text-sm leading-5 font-medium space-x-4 ml-3 cursor-pointer']) }} >
    <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full" x-bind:class="{'bg-indigo-600': tab === 'season-{{ $step }}'}">
        <p  x-bind:class="{'text-white': tab === 'season-{{ $step }}', 'text-indigo-600': tab !== 'season-{{ $step }}'}">{{ $step }}</p>
    </div>
</div>

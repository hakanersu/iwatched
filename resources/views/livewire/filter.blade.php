@php
$class = 'block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500';
@endphp
<form method="GET">
    <div class="flex mb-5">
        <div class="relative">
            <select onchange="this.form.submit()" name="selected_year" id="selected_year" class="{{ $class }}">
                <option value="">Year</option>
                @for($i=2020; $i>1900;$i--)
                    <option {{ request('selected_year') == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-4 w-4"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path></svg></div>
        </div>
        <div class="relative ml-2">
            <select onchange="this.form.submit()" name="not_watched" id="not_watched" class="{{ $class }}">
                <option value="no" {{ request('not_watched') === 'no' ? 'selected' : '' }}>All movies</option>
                <option value="yes" {{ request('not_watched') === 'yes' ? 'selected' : '' }}>Not watched</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-4 w-4"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path></svg></div>
        </div>
        <div class="relative ml-2">
            <select onchange="this.form.submit()" name="rating" id="rating" class="{{ $class }}">
                <option>Rating</option>
                <option value="1" {{ request('rating') === '1' ? 'selected' : '' }}>1</option>
                <option value="2" {{ request('rating') === '2' ? 'selected' : '' }}>2</option>
                <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>3</option>
                <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>4</option>
                <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>5</option>
                <option value="6" {{ request('rating') === '6' ? 'selected' : '' }}>6</option>
                <option value="7" {{ request('rating') === '7' ? 'selected' : '' }}>7</option>
                <option value="8" {{ request('rating') === '8' ? 'selected' : '' }}>8</option>
                <option value="9" {{ request('rating') === '9' ? 'selected' : '' }}>9</option>
                <option value="10" {{ request('rating') === '10' ? 'selected' : '' }}>10</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-4 w-4"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path></svg></div>
        </div>
    </div>
</form>

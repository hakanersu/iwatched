<form method="GET" action="{{ url()->full() }}">
    <div class="flex py-3">
        <div class="relative mr-3">
            <select onchange="this.form.submit()" name="selected_year" id="selected_year"  class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                <option value="">Year</option>
                @foreach(array_reverse(range(1900, \Carbon\Carbon::now()->year)) as $y)
                    <option value="{{ $y }}"  @if($y == request('selected_year')) selected @endif>{{ $y }}</option>
                @endforeach
            </select>

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="relative mr-3">
            <select onchange="this.form.submit()" name="not_watched" id="not_watched"  class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                <option value="no" {{ request('not_watched') === 'no' ? 'selected' : '' }}>All movies</option>
                <option value="yes" {{ request('not_watched') === 'yes' ? 'selected' : '' }}>Not watched</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="relative">
            <select onchange="this.form.submit()" name="rating" id="rating" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                <option>Rating</option>
                @foreach(range(1,10) as $rating)
                    <option value="{{ $rating }}" {{ request('rating') == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
    </div>
</form>

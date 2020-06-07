<div class="btn-status">
	<input type="checkbox" wire:model="checked" name="checkbox" id="checkbox{{ $episode->id }}" class="hidden checkbox" @if($episode->watched_at) checked @endif />
	<label
		for="checkbox{{ $episode->id }}"
		class="btn-change flex items-center p-1 rounded-lg w-12 h-6 cursor-pointer{{ $checked ? ' checked' : '' }}"
	></label>
</div>

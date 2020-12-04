<div class="btn-status flex justify-end" >
    <input type="checkbox" name="checkbox-{{ $name }}" wire:model="checked"  class="hidden checkbox" />
    <label
        wire:click="change()"
        for="checkbox-{{ $name }}"
        class="btn-change flex items-center p-1 rounded-lg w-12 h-6 cursor-pointer{{ $checked ? ' checked' : '' }}"
    ></label>
</div>

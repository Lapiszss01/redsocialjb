<div>
    <form wire:submit.prevent="save" class="mb-0 py-0">
        <x-textarea-post-input wire:model.defer="body" id="body" name="body"></x-textarea-post-input>

        <div class="dropzone relative flex items-center justify-center overflow-hidden max-w-full max-h-60 border-0" id="dropzone">
            <input type="file" wire:model="image" class="hidden" id="imageInput">
            <div class="cursor-pointer" onclick="document.getElementById('imageInput').click()">
                {{ __('Click to upload an image') }}
            </div>
        </div>

        @if ($image)
            <img src="{{ $image->temporaryUrl() }}" class="p-1 w-full max-w-lg h-auto object-cover rounded-lg mx-auto">
        @endif

        <livewire:components.publish-date-picker wire:model.defer="published_at"/>

        <div>
            <button type="submit" class="py-2 w-full border-gray-300 border-b-0 border-t-2 border-l-0 border-r-0">
                {{ __('Post') }}
            </button>
        </div>
    </form>

</div>

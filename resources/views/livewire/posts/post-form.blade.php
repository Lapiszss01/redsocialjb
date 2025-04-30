<div class="py-4 px-4"> <!-- padding inferior eliminado -->
    <form wire:submit.prevent="save" class="mb-0 py-0">
        <x-textarea-post-input wire:model.defer="body" id="body" name="body" />

        <div class="dropzone relative flex items-center justify-center overflow-hidden max-w-full max-h-60 border-0" id="dropzone">
            <input type="file" wire:model="image" class="hidden" id="imageInput">
            <div class="cursor-pointer" onclick="document.getElementById('imageInput').click()">
                {{ __('Click to upload an image') }}
            </div>
        </div>

        @if ($image)
            <img src="{{ $image->temporaryUrl() }}" class="p-1 w-full max-w-lg h-auto object-cover rounded-lg mx-auto">
        @endif

        <livewire:components.publish-date-picker wire:model.defer="published_at" />

        <button type="submit" class="w-full bg-gray-100 border-gray-300 py-2 my-2 rounded">
            {{ __('Post') }}
        </button>
    </form>
</div>


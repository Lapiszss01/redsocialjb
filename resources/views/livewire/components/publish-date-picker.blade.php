<div>
    <label for="published_at" class="block text-sm font-medium text-gray-700">{{__('Publish date')}}</label>
    <input type="datetime-local" id="published_at" wire:model="published_at" wire:change="emitPublishedAt" class="mt-1 p-2 w-full border rounded-md">
</div>

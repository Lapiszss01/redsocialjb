<div>
    <button wire:click="runJob" class="btn btn-danger bg-red-500 text-white px-2 py-1 rounded">Eliminar usuarios inactivos</button>

    @if($message)
        <p style="color: green;">{{ $message }}</p>
    @endif
</div>

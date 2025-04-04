<select wire:model="roleId" wire:change="updateRole($event.target.value)" class="border p-1 rounded">
    @foreach ($roles as $role)
        <option value="{{ $role->id }}">{{ $role->name }}</option>
    @endforeach
</select>

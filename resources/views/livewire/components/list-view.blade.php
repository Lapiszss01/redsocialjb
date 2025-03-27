<div class="p-4 bg-white shadow rounded-md">
    @if($title)
        <h2 class="text-lg font-bold mb-2">{{ $title }}</h2>
    @endif
    <ul class="space-y-2">
        @foreach ($items as $item)
            <li class="p-2 border rounded-md bg-gray-100">{{ $item }}</li>
        @endforeach
    </ul>
</div>

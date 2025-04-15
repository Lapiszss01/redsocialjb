<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <h3>Notis</h3>
    <ul>
        @foreach($notifications as $notification)
            <li>{{ $notification->message }}</li>
        @endforeach
    </ul>


</x-app-layout>

<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mt-8 grid gap-2 max-w-6xl mx-auto p-4 bg-white">
    <h2>{{__("Notifications")}}</h2>

        <div class="bg-white p-2 shadow-md rounded-lg w-full">
            @foreach($notifications as $notification)
                @include('notifications.notification-item', ['notification' => $notification])
            @endforeach
        </div>
    </div>
</x-app-layout>

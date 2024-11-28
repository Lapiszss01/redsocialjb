<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mx-auto mt-4 max-w-6xl ">
       <div>

           <div class="text-3xl">
               {{$user->name}}
               <span class="text-2xl text-gray-700">
                   - {{$user->username}}
               </span>
           </div>
            <br>
           <p>
               {{$user->biography}}
           </p>
            <br>
           <div
               class="px-4 mt-8 grid max-w-4xl gap-4 md:grid-cols-1 lg:grid-cols-1"
           >
            @foreach($posts as $post)
               @include('components.post-article')
            @endforeach
           </div>

       </div>
    </div>
</x-app-layout>


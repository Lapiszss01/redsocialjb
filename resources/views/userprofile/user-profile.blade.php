<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mx-auto mt-4 max-w-6xl ">
       <div class="bg-amber-300">

           <div class="text-3xl">
               {{$user->name}}
               <span class="text-2xl text-gray-700">
                   - {{$user->username}}
               </span>
           </div>



       </div>
    </div>
</x-app-layout>


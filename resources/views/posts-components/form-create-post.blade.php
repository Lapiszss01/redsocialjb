<script>
    Dropzone.autoDiscover = false;

    document.addEventListener("DOMContentLoaded", function () {
        let myDropzone = new Dropzone("#dropzone", {
            url: "{{ route('posts.upload') }}",
            paramName: "file",
            maxFilesize: 2, // 2MB
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Arrastra o haz clic para subir una imagen",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            success: function (file, response) {
                document.getElementById("image_url").value = response.path; // Guarda la URL en un input hidden
            },
            removedfile: function (file) {
                document.getElementById("image_url").value = ""; // Limpia el input si se borra la imagen
                file.previewElement.remove();
            }
        });
    });
</script>

<form method="POST" action="{{ route('post.store') }}" id="postForm">
    @csrf
    <article class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900">
        <!-- Dropzone -->
        <div class="dropzone border-2 border-dashed p-4" id="dropzone">
        </div>

        <!-- Campo oculto para la imagen -->
        <input type="hidden" name="image_url" id="image_url">

        <!-- Campo de texto -->
        <x-textarea-post-input id="body" name="body"></x-textarea-post-input>

        <!-- Botón de Enviar -->
        <button type="submit" class="p-2">Postear</button>
    </article>
</form>

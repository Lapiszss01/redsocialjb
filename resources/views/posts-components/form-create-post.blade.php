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

<div class="rounded-lg border-2 border-gray-300">
    <article class="flex flex-col overflow-hidden rounded bg-white shadow">
        <form method="POST" action="{{ route('post.store') }}" id="postForm" class="mb-0 py-0" >
            @csrf
            <!-- Campo de texto -->
            <x-textarea-post-input id="body" name="body"></x-textarea-post-input>

            <!-- Dropzone -->
            <div class="dropzone relative flex items-center justify-center overflow-hidden max-w-full max-h-60 border-0" id="dropzone">
                <input type="hidden" name="image_url" id="image_url">
            </div>

            <!-- Botón de Enviar -->
            <div>
                <button type="submit" class="py-2 w-full border-gray-300 border-b-0 border-t-2 border-l-0 border-r-0">Postear</button>
            </div>
        </form>
    </article>
</div>

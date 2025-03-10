<script>
    Dropzone.autoDiscover = false;

    document.addEventListener("DOMContentLoaded", function () {
        let myDropzone = new Dropzone("#dropzone", {
            url: "{{ route('posts.upload') }}",
            paramName: "file",
            maxFilesize: 2, // 2MB
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            maxFiles: 1, // Solo permite una imagen
            dictDefaultMessage: @json(__('Dropzone Message')),
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            init: function () {
                this.on("addedfile", function (file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]); // Elimina la imagen anterior antes de agregar la nueva
                    }
                });

                this.on("success", function (file, response) {
                    document.getElementById("image_url").value = response.path; // Guarda la URL en un input hidden
                });

                this.on("removedfile", function (file) {
                    document.getElementById("image_url").value = ""; // Limpia el input si se borra la imagen
                });
            }
        });
    });
</script>

<div class="rounded-lg border-2 border-gray-300">


    <article class="flex flex-col overflow-hidden rounded bg-white shadow">

        @isset($post)

            <form method="POST" action="{{ route('post.show.store',$post) }}" id="postForm" class="mb-0 py-0" >
                @csrf
                <x-textarea-post-input id="body" name="body"></x-textarea-post-input>

                <div class="dropzone relative flex items-center justify-center overflow-hidden max-w-full max-h-60 border-0" id="dropzone">
                    <input type="hidden" name="image_url" id="image_url">
                </div>

                <div>
                    <button type="submit" class="py-2 w-full border-gray-300 border-b-0 border-t-2 border-l-0 border-r-0">
                        {{__("Post")}}</button>
                </div>
            </form>
        @else

            <form method="POST" action="{{ route('post.store') }}" id="postForm" class="mb-0 py-0" >
                @csrf
                <x-textarea-post-input id="body" name="body"></x-textarea-post-input>

                <div class="dropzone relative flex items-center justify-center overflow-hidden max-w-full max-h-60 border-0" id="dropzone">
                    <input type="hidden" name="image_url" id="image_url">
                </div>

                <div>
                    <button type="submit" class="py-2 w-full border-gray-300 border-b-0 border-t-2 border-l-0 border-r-0">
                        {{__("Post")}}</button>
                </div>
            </form>
        @endif
    </article>
</div>

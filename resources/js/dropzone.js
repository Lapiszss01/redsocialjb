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

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>
    </header>

    {{-- DROPZONE FUERA del <form> principal --}}
    <div>
        <x-input-label for="profile_photo" :value="__('Profile Photo')" />

        <form action="{{ route('profile.upload-photo') }}"
              class="dropzone mt-2 border border-dashed border-gray-400 rounded-md p-4"
              id="profilePhotoDropzone"
              enctype="multipart/form-data">
            @csrf
        </form>


    </div>

    <form method="post" action="{{ route('userprofile.update', $user) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="biography" :value="__('Biography')" />
            <x-textarea-input id="biography" name="biography" type="text" class="mt-1 block w-full" :biography="$user->biography" required autofocus autocomplete="biography" />
            <x-input-error class="mt-2" :messages="$errors->get('biography')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>

<!-- Dropzone -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
    Dropzone.options.profilePhotoDropzone = {
        url: "{{ route('profile.upload-photo') }}",
        paramName: 'file',
        maxFilesize: 2, // MB
        acceptedFiles: 'image/*',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        init: function () {
            var dropzone = this;

            @if ($user->profile_photo)

            var mockFile = {
                name: "Current Profile Photo",
                size: 12345,
                type: 'image/jpeg',
                accepted: true
            };

            dropzone.emit("addedfile", mockFile);
            dropzone.emit("thumbnail", mockFile, "{{ Storage::url($user->profile_photo) }}");
            dropzone.emit("complete", mockFile);

            dropzone.files.push(mockFile);
            @endif

            this.on("maxfilesexceeded", function(file) {
                dropzone.removeAllFiles();
                dropzone.addFile(file);
            });

            this.on("success", function(file, response) {
                console.log('Foto subida:', response.path);

                dropzone.removeAllFiles();
                dropzone.emit("addedfile", file);
                dropzone.emit("thumbnail", file, response.path);
                dropzone.emit("complete", file);
                dropzone.files.push(file);
            });

            this.on("removedfile", function(file) {
                console.log("Archivo eliminado");
            });
        }
    };
</script>

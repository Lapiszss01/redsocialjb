<form method="POST" action="{{ route('post.show.store',$post) }}">
    <article
        class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900"
    >
        <x-textarea-post-input id="body" name="body"></x-textarea-post-input>
        <button type="submit" class="p-2">
            {{__("Reply")}}
        </button>
    </article>
    @csrf
</form>

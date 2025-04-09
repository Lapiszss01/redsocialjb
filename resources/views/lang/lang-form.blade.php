<form action="{{ route('change.language') }}" method="POST">
    @csrf
    <select name="language" onchange="this.form.submit()">
        <option value="es" {{ session('locale') == 'es' ? 'selected' : '' }}>Español</option>
        <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>English</option>
    </select>
</form>






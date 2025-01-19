<form action="{{ route('projects.store') }}" method="POST">
    @csrf
    <input type="text" name="project_name" placeholder="Projekt neve" required>
</form>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

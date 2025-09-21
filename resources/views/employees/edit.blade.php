<h1>Mitarbeiter bearbeiten</h1>
<form action="{{ route('employees.update', $employee) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="{{ $employee->name }}" required><br>
    <label for="email">E-Mail:</label><br>
    <input type="email" id="email" name="email" value="{{ $employee->email }}" required><br>
    <label for="role">Rolle:</label><br>
    <input type="text" id="role" name="role" value="{{ $employee->role }}" required><br>
    <button type="submit">Aktualisieren</button>
</form>

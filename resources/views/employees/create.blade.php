<h1>Neuen Mitarbeiter erstellen</h1>
<form action="{{ route('employees.store') }}" method="POST">
    @csrf
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="email">E-Mail:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="role">Rolle:</label><br>
    <input type="text" id="role" name="role" required><br>
    <button type="submit">Speichern</button>
</form>

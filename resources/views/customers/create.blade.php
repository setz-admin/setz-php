<h1>Neuen Kunden erstellen</h1>
<form action="{{ route('customers.store') }}" method="POST">
    @csrf
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="email">E-Mail:</label><br>
    <input type="email" id="email" name="email" required><br>
    <button type="submit">Speichern</button>
</form>

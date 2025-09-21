<h1>Kunden bearbeiten</h1>
<form action="{{ route('customers.update', $customer) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="{{ $customer->name }}" required><br>
    <label for="email">E-Mail:</label><br>
    <input type="email" id="email" name="email" value="{{ $customer->email }}" required><br>
    <button type="submit">Aktualisieren</button>
</form>

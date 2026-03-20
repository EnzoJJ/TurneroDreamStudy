<h1>Formulario de Peluqueros</h1>
<form method="POST" action="{{ route('barbers.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Nombre" required>
    <button type="submit">Guardar</button>
</form>
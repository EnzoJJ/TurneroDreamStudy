<h1>¡Hola, {{ $turn->client_name }}!</h1>
<p>Has solicitado un turno para el {{ $turn->start_time }}.</p>
<p>Para confirmar tu asistencia, haz clic en el siguiente enlace:</p>

<a href="{{ route('turns.confirm', ['token' => $turn->token]) }}" 
   style="background: black; color: white; padding: 10px 20px; text-decoration: none;">
   CONFIRMAR TURNO
</a>

<p>Si no solicitaste este turno, puedes ignorar este correo.</p>
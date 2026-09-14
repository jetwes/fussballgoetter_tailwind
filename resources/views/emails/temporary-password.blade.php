<p>Hallo {{ $user->name }},</p>

<p>du hast ein neues Passwort angefordert. Wir haben ein vorläufiges Passwort für dich erzeugt. Damit es aktiv wird, musst du den Link in dieser E-Mail anklicken.</p>

<p>
    <strong>Benutzername:</strong> {{ $user->email }}<br>
    <strong>Passwort:</strong> {{ $temporaryPassword }}
</p>

<p>Bitte diesen Link klicken, um das Passwort zu aktivieren – danach das Passwort im Portal bitte wieder ändern:<br>
<a href="{{ $link }}">{{ $link }}</a></p>

<p>Deine Fußballgötter</p>

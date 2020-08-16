Hallo {{ $username }}, <br><br>

Du hast ein neues Passwort angefordert. Es wurde ein neues Passwort generiert. Damit dieses aktiviert wird muss der Link in dieser E-Mail angeklickt werden. <br>
<br>
<h4>Benutzername: {{ $email }}</h4>
<h4>Passwort: {{ $temp_password }}</h4><br>

Bitte diesen Link klicken um das PW zu aktivieren - danach bitte das Passwort im Portal wieder ändern. <br><br>
<h4>Link: <a href="{{ $link }}"><strong>{{ $link }}</strong></a></h4><br>
<br>
Deine Fußballgötter

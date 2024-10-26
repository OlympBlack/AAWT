@component('mail::message')
# Bienvenue {{ $student->firstname }}

Votre compte étudiant a été créé avec succès.

Voici vos informations de connexion :
Email : {{ $student->email }}
Mot de passe temporaire : {{ $temporaryPassword }}

Veuillez vous connecter et changer votre mot de passe dès que possible.

@component('mail::button', ['url' => route('login')])
Se connecter
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent


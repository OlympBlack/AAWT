@component('mail::message')
# Bienvenue dans l'équipe enseignante

Bonjour {{ $user->firstname }},

Un compte enseignant a été créé pour vous. Voici vos informations de connexion :

Email : {{ $user->email }}
Mot de passe temporaire : {{ $temporaryPassword }}

Veuillez vous connecter et changer votre mot de passe dès que possible.

@component('mail::button', ['url' => route('login')])
Se connecter
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent

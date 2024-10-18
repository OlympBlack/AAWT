# MySchoolManager | Projet d'Aspect Avancé des Technologie Web IFRI 2024 - 2025 GROUPE 2

## Description

MySchoolManager est une plateforme de gestion d'établissements scolaires développée en Laravel. Elle permet de gérer les élèves, les enseignants, les inscriptions, les notes, et bien plus, avec une interface moderne et intuitive.

## Installation

### Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- PHP >= 8.2.x
- Composer
- MySQL ou un autre serveur de base de données compatible
- Node.js & npm (pour la gestion des dépendances front-end)
- OpenSSL activé dans PHP (pour les connexions sécurisées)

### Étapes d'installation

1. **Cloner le projet :**
   ```bash
   git clone https://github.com/OlympBlack/AAWT-Groupe2.git
   ```
2. **Accéder au dossier du projet :**
   ```bash
   cd myschoolmanager
   ```
3. **Installer les dépendances PHP :**
    ```bash
    composer install
    ```
4. **Configurer les variables d'environnement :**
```bash
    cp .env.example .env 
  ```
5. **Exécuter les migrations  :**
```bash
     php artisan migrate 
 ```
6. **Installer les dépendances front-end :**
```bash
npm install
npm run dev
```
7. **Démarrer le serveur local :**
Vous pouvez maintenant démarrer le serveur Laravel avec :
```bash  
php artisan serve 
```
- L'application sera accessible sur ``` http://localhost:8000 ```

## Comment travailler sur le projet

Pour travailler sur le projet, suivez les étapes ci-dessous :

Assurez-vous d'obtenir l'autorisation nécessaire pour travailler sur le projet.
    
- Clonez le référentiel sur votre machine si ce n'est pas déjà fait.
    
- Avant de commencer à travailler sur une nouvelle fonctionnalité, assurez-vous de créer une branche distincte pour celle-ci.

- Utilisez la commande suivante pour créer une nouvelle branche à partir de la branche principale (main)
    
```bash
    git checkout -b nom_de_votre_branche
```	
    
- Travaillez sur votre branche en effectuant les modifications nécessaires.
    
- Une fois que vous avez terminé les modifications, ajoutez les fichiers modifiés au suivi Git en utilisant la commande : ``` git add ```

- Validez vos modifications en créant un commit descriptif : 
```bash
git commit -m "Description du commit"
```	

- Poussez votre branche sur le référentiel distant en utilisant la commande :
```bash
git push origin nom_de_votre_branche
```

-  Une fois que vous êtes satisfait de vos modifications et que vous souhaitez les intégrer au projet principal, créez une demande de fusion (pull request) sur la plateforme de gestion des projets.

- Attendez la revue de code et les commentaires des autres membres de l'équipe.

- Effectuez les ajustements nécessaires en fonction des commentaires reçus et continuez à pousser vos modifications sur votre branche.

- Une fois que votre demande de fusion a été approuvée, votre branche peut être fusionnée avec la branche principale (main) du projet.

## L'erreur à éviter

Afin de maintenir un flux de travail efficace et de garantir la qualité du code, voici quelques erreurs à éviter lors de votre contribution au projet :

- Ne travaillez pas directement sur la branche principale (main) du projet.
    
- Utilisez des branches distinctes pour chaque fonctionnalité.
    
- N'oubliez pas de créer des commits cohérents et descriptifs pour chaque modification.
    
- N'oubliez pas de tester vos modifications avant de les pousser sur le référentiel distant.
    
- Ne fusionnez pas votre propre branche sans passer par une revue de code par d'autres membres de l'équipe.
    
- Prenez en compte les commentaires et les suggestions de l'équipe lors de la revue de code et apportez les ajustements nécessaires.

- En suivant ces bonnes pratiques, nous pourrons maintenir un flux de travail efficace et garantir la qualité du code produit.

## Aide

Vous vous sentez pas à l'aise avec les commandes ? Vous pouvez faire les choses avec l'interface graphique de l'éditeur VS Code.

## Plus d'aide 

Contactez les autres membres de l'équipe


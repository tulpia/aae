### Webpack du projet tutoré de l'application d'auto-éval

## Features
- SCSS/SaSS
- ES6 (Babel)
- Webpack-Dev-Server
- Autoprefixer (PostCSS)
- Imports de fichiers SCSS (CSSLoader)
- EsLint/Prettier basé sur airbnb-style-guide

## Pré-requis
- Node/NPM ou Yarn
- Un serveur local
- **Ligne de commande pour windows**: Windows Subsystem for Linux si possible, sinon Git Bash/Cygwin, au pire testez avec CMD/Powershell
- Une expérience avec la ligne de commande si possible

## Installation
1. Clonez la répo chez vous
2. Ouvrez la ligne de commande à l'endroit où elle a été clonée
3. Tapez `` npm install ``
4. Puis `` npm run watch ``


## Comment ça fonctionne ?
**Webpack** est un module bundler/task runner similaire à gulp: il s'occupe de compiler vos fichiers Javascripts, CSS, Images, etc... grâce à un système de gestion de dépendances de module. Ces modules sont en fait des sortes de plugins qui vont améliorer votre environnement de travail, comme prendre en charge les fichiers SCSS, minifier votre code, transpiler votre Javascript pour améliorer la compatibilité avec d'autres navigateurs plus anciens,...

## Utilisation
Il ya deux dossiers majeurs dans ce webpack que j'ai créé, public et src:
- **src**: Dossier où tous les fichiers contribuant au code comme le CSS, le Javascript mais aussi les images et les SVGs seront déposés.
Au moment de la compilation, ces fichiers seront compilés et déplacés dans le fichier **public**
- **public**: Dossier où votre structure HTML/PHP sera codée. On peut très bien intégrer un wordpress ou tout autre CMS à l'intérieur. Les fichiers CSS et JS seront dans un fichier dist/, il faudra donc soit les mettre sur toutes les pages HTML qu'on va créé, soit si on part sur du PHP, faire un header.php et un footer.php et les foutre dedans ces deux-là respectivement.
Il est possible que l'on utilise une architecture MVC, React/Vue ou autre merde du genre pour le projet, auquel cas il faudra changer un peu le webpack.config.js pour changer l'output.

## TODO
- J'attends du feedback :)

### Webpack du projet tutoré de l'application d'auto-éval

## Features
- SCSS/SaSS
- ES6 (Babel)
- Webpack-Dev-Server
- Autoprefixer (PostCSS)
- Imports de fichiers SCSS (CSSLoader)

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

# Projet AAE

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
3. Tapez `npm install`
4. Puis `npm run start`

## Comment ça fonctionne ?

**Webpack** est un module bundler/task runner similaire à gulp: il s'occupe de compiler vos fichiers Javascripts, CSS, Images, etc... grâce à un système de gestion de dépendances de module. Ces modules sont en fait des sortes de plugins qui vont améliorer votre environnement de travail, comme prendre en charge les fichiers SCSS, minifier votre code, transpiler votre Javascript pour améliorer la compatibilité avec d'autres navigateurs plus anciens,...

## Utilisation

Il ya deux dossiers majeurs dans ce webpack que j'ai créé, public et src:

- **src**: Dossier où tous les fichiers contribuant au code comme le CSS, le Javascript mais aussi les images et les SVGs seront déposés.
  Au moment de la compilation, ces fichiers seront compilés et déplacés dans le fichier **public**
- **public**: Dossier où votre structure HTML/PHP sera codée. Au moment du setup de votre serveur local (MAMP, WAMP, virtual host), pointez l'url vers ce dossier.

# Instructions

## Webpack

Webpack vous permet de compiler les fichiers qui sont présent dans le dossier **src**. Dans le cas du scss, il le converti, l'auto-prefix et le minifie en css et pour le js, il le transpile et le minifie pour maximiser la compatibilité.\
Les commandes importantes :

- `npm run watch` (non-fonctionnel pour l'instant) : permet d'activer webpack-dev-server,
- `npm run start` : permet de passer webpack en 'watch', c'est à dire qu'à chaque modif de votre code, webpack recompilera le tout (remplace le watch pour le moment),
- `npm run dev` : compile votre code sans minification, transpilation, tree-shaking, etc...
- `npm run build` : compile votre code pour le préparer à être mis en ligne,

## PHP

- Ecrivez toute votre logique PHP dans le dossier public. Vous pouvez faire autant de sous-dossiers que vous voulez dans ce dossier public.

## CSS (SCSS)

- Ecrivez tout votre css dans les fichiers **.scss** qui se trouvent dans le dossier **src/scss**.
- Lorsque vous créez une page/template php, essayez de créer un nouveau fichier .scss pour celle-ci. Cela permet de garder une structure propre et rendre notre code mieux organisé et plus lisible. Lorsque vous créez des fichiers .scss, respectez la **nomenclature** déjà en place avec les autres fichiers : mettez un `_` (un underscore lol) suivi d'un `page-` devant le nom du fichier (sans mettre des espaces hein). Par exemple: `_page-questions.scss`.
- Importez vos fichiers .scss créés dans main.scss (ya des instructions dans ce fichier)
- N'ECRIVEZ PAS DU CSS. Ecrivez du scss. Ca prends limite une aprem à apprendre si vous possédez des bases en css normal.\
  _Exemple de code css:_

```
.class-parent {
    foo: bar;
}
.class-parent .class-enfant {
    foo: bar;
}
```

_Exemple de code scss:_

```
.class-parent {
    foo: bar;
    .class-enfant {
        foo: bar;
    }
}
```

- Le SCSS permet, parmis pleins d'autre features, de faire du **code-nesting**, ce qui le rapproche beaucoup plus d'une syntaxe d'un vrai langage de programmation, rendant le code plus lisible et plus facile à écrire.
- Si vous avez le courage (lol), apprenez aussi la nomenclature de classes css **[BEM](http://getbem.com/introduction/)**
- **pour Geoffrey**: il faudrait qu'on voit si on peut pas quand même jarter bootstrap parce que ça rajoute une énorme charge dans le fichier compilé, genre environ 700ko. On peut juste utiliser flexbox je pense.

## JS

- Ecrivez votre JS dans le dossier **src/js**, dans des fichiers que vous allez créér et importer ensuite dans le fichier principal, **app.js**, de cette manière: `import 'nomdufichier.js;'`
- Comme pour le scss, vous pouvez créér autant de fichiers par page/fonction que vous voulez ajouter au site, n'oubliez juste pas de l'importer dans le app.js. Encore une fois, séparer votre code en plusieurs morceaux permet de le rendre plus lisible par les autres et plus facile à écrire aussi.
- **Ecrivez votre JS SANS JQUERY**. Vous n'avez pas besoin de jquery. Si vous vous demandez comment faire un truc sans jquery, demandez-moi.
- **Respectez la syntaxe ES6+**, c'est à dire pas de `var` (visez pour des `let` si votre variable peut changer dans vos fonctions, ou `const` si votre variable ne changera pas de valeur). Utilisez les arrow functions quand vous pouvez.\
  _Exemple de code ES6 :_

```import SplitText from '@js/_private/SplitText.js'
import 'gsap/ScrollToPlugin' // eslint-disable-line no-unused-vars
import Barba from 'barba.js'
import axios from 'axios'
import { TweenMax, Expo, TimelineLite } from 'gsap'
import { breakpoints } from '@js/_private/breakpoints.js'
import debounce from 'lodash.debounce'
import datepicker from 'js-datepicker'
let tlIntro
let picker
let compteurLoader = 0
document.addEventListener('DOMContentLoaded', () => {
  Barba.BaseView.extend({
    namespace: 'page-home',
    onEnter: () => {
      if (window.innerWidth > breakpoints.tablet) {
        const listImages = document.querySelectorAll('img[src]')
        const loader = document.querySelector('.loader')
        const loaderHider = document.querySelector('.loader-hider')
        let compteurPercent
        for (let i = 0; i < listImages.length; i++) {
          listImages[i].addEventListener('load', function (e) {
            compteurLoader++
          })
          ...
```

- Vous voulez importer une librairie javascript comme GSAP ? Installez-là depuis NPM puis importez la dans le fichier dans lequel vous avez besoin exemple : `import nomLibrairie from 'nomLibrairie'`
- Privilégiez les requêtes AJAX au rechargement forcé de page. Formulaire avec récupération de réponses de questions ? Faite une requête POST vers un controller PHP qui retourne des données JSON comme [celui-ci](https://github.com/tulpia/SPUE6/blob/master/public/controller.php). D'ailleurs, utilisez axios au lieu de \$.ajax ou des requêtes XHR, c'est un meilleur moyen de faire des requêtes ajax. [Voici la doc](https://github.com/axios/axios)

## JavaScript Style Guide : AirBnb

Vu que l'on est en groupe, et qu'on écrit pas tous du code de la même façon, j'ai décidé d'implémenter un style guide : celui de AirBnb.
Un style guide est un répertoire de règle que votre code devra respecter pour être compilé par webpack. **En gros, si votre code est pas propre, webpack refusera de le compiler**.\
[voici toutes les règles que ce style guide implémente](https://github.com/airbnb/javascript). C'est une longe liste mais ça vous aidera à devenir un meilleur dev à la longue.\
D'ailleurs, je vous reccommande **très fortement** (en gros je vous oblige) à utiliser Visual Studio Code qui possède une intégration ESLint/Prettier superbe. En gros, votre code sera corrigé à l'enregistrement de celui-ci (si vous êtes en watch)
[voici comment faire sur VSCode](https://blog.echobind.com/integrating-prettier-eslint-airbnb-style-guide-in-vscode-47f07b5d7d6a)

## Alias

Dans votre code JS et CSS, j'ai mis en place des alias qui va vous permettre d'accéder facilement aux différents fichiers et dossiers du dossier **src**.
Qu'est-ce qu'un alias ? C'est un bout de code qui va vous permettre de faire référence à un dossier plus simplement. Par exemple, imaginons que dans un de mes fichiers .scss, je veux qu'une classe possède une image en background, et que cette image est dans le dossier image. Au lieu de l'importer à coup de `background-image: url('../images/image.jpg')`, on va l'importer avec `background-image: url('~@img/image.jpg')`. Ca vous a l'air peut être un peu con, mais c'est très pratique parce que en fait la première syntaxe que j'ai tapé en exemple ne fonctionnera pas parce que webpack ne reconnaît pas ce chemin.\
Liste d'alias :

- @font: les polices
- @img: images
- @svg: les svgs
- @js: le JS

# GIT

## Git Flow

Ce projet se basera sur la méthodolgie Git Flow, comme on l'avait prévu au début.
[Voici la doc](https://danielkummer.github.io/git-flow-cheatsheet/).\
En gros, si vous développez une feature importante, créez une branche feature avec la commande `git flow feature start nomFeature`, faites vos git add et vos commits et, quand vous avez fini, fermez cette feature `git flow feature finish nomFeature`, si c'est une modif rapide, faite une hotfix, etc..

## Comment ça fonctionne ?
**Webpack** est un module bundler/task runner similaire à gulp: il s'occupe de compiler vos fichiers Javascripts, CSS, Images, etc... grâce à un système de gestion de dépendances de module. Ces modules sont en fait des sortes de plugins qui vont améliorer votre environnement de travail, comme prendre en charge les fichiers SCSS, minifier votre code, transpiler votre Javascript pour améliorer la compatibilité avec d'autres navigateurs plus anciens,...

## Utilisation
Il ya deux dossiers majeures dans ce webpack que j'ai créé, public et src:
- **src**: Dossier où tous les fichiers contribuant au code comme le CSS, le Javascript mais aussi les images et les SVGs seront déposés.
Au moment de la compilation, ces fichiers seront compilés et déplacés dans le fichier **public**
- **public**: Dossier où votre structure HTML/PHP sera codée. On peut très bien intégrer un wordpress ou tout autre CMS à l'intérieur. Les fichiers CSS et JS seront dans un fichier dist/, il faudra donc soit les mettre sur toutes les pages HTML qu'on va créé, soit si on part sur du PHP, faire un header.php et un footer.php et les foutre dedans ces deux-là respectivement.
Il est possible que l'on utilise une architecture MVC, React/Vue ou autre merde du genre pour le projet, auquel cas il faudra changer un peu le webpack.config.js pour changer l'output.

## TODO
rien pour l'instant, j'attends du feedback :)

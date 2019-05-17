/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _js_app_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js/app.js */ \"./src/js/app.js\");\n/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scss/main.scss */ \"./src/scss/main.scss\");\n/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_scss_main_scss__WEBPACK_IMPORTED_MODULE_1__);\n\n\n\n//# sourceURL=webpack:///./src/index.js?");

/***/ }),

/***/ "./src/js/app.js":
/*!***********************!*\
  !*** ./src/js/app.js ***!
  \***********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _js_home_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @js/home.js */ \"./src/js/home.js\");\n/* harmony import */ var _js_home_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_js_home_js__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _js_header_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @js/header.js */ \"./src/js/header.js\");\n/* harmony import */ var _js_header_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_js_header_js__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _js_pageProf_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @js/pageProf.js */ \"./src/js/pageProf.js\");\n/* harmony import */ var _js_pageProf_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_js_pageProf_js__WEBPACK_IMPORTED_MODULE_2__);\n// importez vos fichiers javascripts, créé dans le même dossier que ce fichier Javascript, avec la syntaxe affichée ci-dessous\n\n\n\n\n//# sourceURL=webpack:///./src/js/app.js?");

/***/ }),

/***/ "./src/js/header.js":
/*!**************************!*\
  !*** ./src/js/header.js ***!
  \**************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("document.addEventListener('DOMContentLoaded', () => {\n  const btnHeaderContainer = document.querySelector('.header-connected__btn-deconnect');\n\n  if (btnHeaderContainer) {\n    btnHeaderContainer.addEventListener('click', () => {\n      btnHeaderContainer.classList.toggle('active');\n    });\n  }\n});\n\n//# sourceURL=webpack:///./src/js/header.js?");

/***/ }),

/***/ "./src/js/home.js":
/*!************************!*\
  !*** ./src/js/home.js ***!
  \************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("\n\n//# sourceURL=webpack:///./src/js/home.js?");

/***/ }),

/***/ "./src/js/pageProf.js":
/*!****************************!*\
  !*** ./src/js/pageProf.js ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("// /* eslint-disable func-names */\n// /* eslint-disable no-console */\n// import axios from 'axios';\n// let formData;\n// if (document.querySelector('.btn-onglet')) {\n//   document.addEventListener('DOMContentLoaded', () => {\n//     // -----\n//     // ONGLETS\n//     // -----\n//     const btnOnglets = document.querySelectorAll('.btn-onglet');\n//     const secOnglets = document.querySelectorAll('.sec-onglet');\n//     for (const btn of btnOnglets) {\n//       btn.addEventListener('click', () => {\n//         if (document.querySelector('.sec-onglet.active')) {\n//           document.querySelector('.sec-onglet.active').classList.remove('active');\n//         }\n//         if (document.querySelector('.btn-onglet.active')) {\n//           document.querySelector('.btn-onglet.active').classList.remove('active');\n//         }\n//         for (const sec of secOnglets) {\n//           if (btn.getAttribute('data-name') === sec.getAttribute('data-name')) {\n//             sec.classList.add('active');\n//             btn.classList.add('active');\n//           }\n//         }\n//       });\n//     }\n//     btnOnglets[0].click();\n//     // -----\n//     // FILTRE\n//     // -----\n//     const formulaire = document.querySelector('.filtreFormulaireResultats');\n//     const formulaireResultContainer = document.querySelector('.content__list-questions--resultats');\n//     const formulaireQuestionnaires = document.querySelector('.filtreFormulaireQuestionnaires');\n//     const formulaireQuestionnairesResultContainer = document.querySelector(\n//       '.content__list-questions--questionnaires'\n//     );\n//     // fonction pour créér des exos\n//     const createExo = (content, finalContainer) => {\n//       // creation du container\n//       const createContainer = document.createElement('div');\n//       createContainer.className = 'question-container';\n//       // creation du conteneur du titre\n//       const createTitleContainer = document.createElement('div');\n//       createTitleContainer.className = 'questions-container__title-container';\n//       createContainer.appendChild(createTitleContainer);\n//       // creation du titre\n//       const createTitle = document.createElement('p');\n//       createTitle.className = 'question-container__title';\n//       createTitle.innerText = content.titre;\n//       createTitleContainer.appendChild(createTitle);\n//       // creation du formulaire\n//       const createForm = document.createElement('form');\n//       createForm.className = 'questions-container__btn-editer';\n//       createForm.setAttribute('method', 'post');\n//       createForm.setAttribute('action', 'index.php');\n//       createTitleContainer.appendChild(createForm);\n//       // creation des inputs hidden\n//       const createHiddenInput1 = document.createElement('input');\n//       createHiddenInput1.setAttribute('type', 'hidden');\n//       createHiddenInput1.setAttribute('name', 'action');\n//       createHiddenInput1.setAttribute('value', 'show_questionnaireDetail');\n//       createForm.appendChild(createHiddenInput1);\n//       const createHiddenInput2 = document.createElement('input');\n//       createHiddenInput2.setAttribute('type', 'hidden');\n//       createHiddenInput2.setAttribute('name', 'idQuestionnaire');\n//       createHiddenInput2.setAttribute('value', content.id);\n//       createForm.appendChild(createHiddenInput2);\n//       // creation du bouton fleche\n//       const createLabelFleche = document.createElement('label');\n//       createLabelFleche.className = 'btn-editer';\n//       createForm.appendChild(createLabelFleche);\n//       const createLabelInput = document.createElement('input');\n//       createLabelInput.setAttribute('type', 'submit');\n//       createLabelInput.className = 'btn-editer-text';\n//       createLabelFleche.appendChild(createLabelInput);\n//       // creation des details - container\n//       const createDetailsContainer = document.createElement('div');\n//       createDetailsContainer.className = 'question-container__details';\n//       createContainer.appendChild(createDetailsContainer);\n//       // creation des details - matiere\n//       const createDetailsMatiere = document.createElement('p');\n//       createDetailsMatiere.className = 'details__matiere';\n//       createDetailsMatiere.innerText = content.matiere;\n//       createDetailsContainer.appendChild(createDetailsMatiere);\n//       // creation des details - classe\n//       const createDetailsClasse = document.createElement('span');\n//       createDetailsClasse.className = 'details__matiere';\n//       createDetailsClasse.innerText = `, ${content.niveau}`;\n//       createDetailsMatiere.appendChild(createDetailsClasse);\n//       // creation des details - date\n//       const createDetailsDate = document.createElement('p');\n//       createDetailsDate.className = 'details__date';\n//       createDetailsDate.innerText = content.dateCrea;\n//       createDetailsContainer.appendChild(createDetailsDate);\n//       finalContainer.appendChild(createContainer);\n//     };\n//     const createExoResultat = (content, finalContainer) => {\n//       // creation du container\n//       const createContainer = document.createElement('div');\n//       createContainer.className = 'question-container';\n//       // check si c'est une archive$\n//       if (content.isArchive === 1) {\n//         createContainer.classList.add('is-archive')\n//       }\n//       // creation du conteneur du titre\n//       const createTitleContainer = document.createElement('div');\n//       createTitleContainer.className = 'questions-container__title-container';\n//       createContainer.appendChild(createTitleContainer);\n//       // creation du titre\n//       const createTitle = document.createElement('p');\n//       createTitle.className = 'question-container__title';\n//       createTitle.innerText = content.titre;\n//       createTitleContainer.appendChild(createTitle);\n//       // creation du formulaire\n//       const createForm = document.createElement('form');\n//       createForm.className = 'questions-container__btn-editer';\n//       createForm.setAttribute('method', 'post');\n//       createForm.setAttribute('action', 'index.php');\n//       createTitleContainer.appendChild(createForm);\n//       // creation des inputs hidden\n//       const createHiddenInput1 = document.createElement('input');\n//       createHiddenInput1.setAttribute('type', 'hidden');\n//       createHiddenInput1.setAttribute('name', 'action');\n//       createHiddenInput1.setAttribute('value', 'show_resultatDetail');\n//       createForm.appendChild(createHiddenInput1);\n//       const createHiddenInput2 = document.createElement('input');\n//       createHiddenInput2.setAttribute('type', 'hidden');\n//       createHiddenInput2.setAttribute('name', 'idResultat');\n//       createHiddenInput2.setAttribute('value', content.id);\n//       createForm.appendChild(createHiddenInput2);\n//       // creation du bouton fleche\n//       const createLabelFleche = document.createElement('label');\n//       createLabelFleche.className = 'btn-editer';\n//       createForm.appendChild(createLabelFleche);\n//       const createLabelInput = document.createElement('input');\n//       createLabelInput.setAttribute('type', 'submit');\n//       createLabelInput.className = 'btn-editer-text';\n//       createLabelFleche.appendChild(createLabelInput);\n//       // creation des details - container\n//       const createDetailsContainer = document.createElement('div');\n//       createDetailsContainer.className = 'question-container__details';\n//       createContainer.appendChild(createDetailsContainer);\n//       // creation des details - date\n//       const createDetailsDate = document.createElement('p');\n//       createDetailsDate.className = 'details__matiere';\n//       createDetailsDate.innerText = content.dateAccessible;\n//       createDetailsContainer.appendChild(createDetailsDate);\n//       // creation des details - matiere\n//       const createDetailsMatiere = document.createElement('span');\n//       createDetailsMatiere.className = 'details__matiere';\n//       createDetailsMatiere.innerText = `, ${content.matiere}`;\n//       createDetailsDate.appendChild(createDetailsMatiere);\n//       // creation des details - classe\n//       const createDetailsClasse = document.createElement('p');\n//       createDetailsClasse.className = 'details__matiere';\n//       createDetailsClasse.innerText = content.classe;\n//       createDetailsContainer.appendChild(createDetailsClasse);\n//       // creation des details - classe - classeNom\n//       if (content.ClasseNom) {\n//         const createDetailsClasseNom = document.createElement('span');\n//         createDetailsClasseNom.className = 'details__matiere';\n//         createDetailsClasseNom.innerText = ` ${content.ClasseNom}`;\n//         createDetailsClasse.appendChild(createDetailsClasseNom);\n//       }\n//       // creation des details - classe - classeNom - optionCours\n//       if (content.optionCours !== null) {\n//         const createDetailsoptionCours = document.createElement('span');\n//         createDetailsoptionCours.className = 'details__matiere';\n//         createDetailsoptionCours.innerText = ` ${content.optionCours}`;\n//         createDetailsClasse.appendChild(createDetailsoptionCours);\n//       }\n//       // creation des reponses - container\n//       const createReponses = document.createElement('p');\n//       createReponses.className = 'details__matiere';\n//       createReponses.innerText = `Réponses : ${content.nbRepondu} / ${content.nbAutoEval}`;\n//       createDetailsContainer.appendChild(createReponses);\n//       // creation des reponses - container\n//       if (content.dateDerReponse !== null) {\n//         const createLastReponse = document.createElement('p');\n//         createLastReponse.className = 'details__matiere';\n//         createLastReponse.innerText = `Dernière réponse le : ${content.dateDerReponse}`;\n//         createDetailsContainer.appendChild(createLastReponse);\n//       }\n//       finalContainer.appendChild(createContainer);\n//     };\n//     // requete ajax pour le filtre questionnaires\n//     if (formulaireQuestionnaires) {\n//       const formulaireLoading = document.querySelector('.loading-container--questionnaires');\n//       formulaireQuestionnaires.addEventListener('submit', function (e) {\n//         e.preventDefault();\n//         formulaireLoading.classList.add('active');\n//         formData = new FormData(formulaireQuestionnaires);\n//         axios({\n//             method: 'post',\n//             url: formulaireQuestionnaires.getAttribute('action'),\n//             data: formData\n//           })\n//           .then(response => {\n//             if (formulaireLoading.classList.contains('active')) {\n//               formulaireLoading.classList.remove('active');\n//             }\n//             if (response.data) {\n//               formulaireQuestionnairesResultContainer.innerText = '';\n//               for (const reponse of response.data.items) {\n//                 console.log(reponse);\n//                 createExo(reponse, formulaireQuestionnairesResultContainer);\n//               }\n//             }\n//           })\n//           .catch(() => {\n//             console.log('fatal error');\n//           });\n//       });\n//     }\n//     // requete ajax pour le filtre resultats\n//     if (formulaire) {\n//       const formulaireLoading = document.querySelector('.loading-container--resultats');\n//       formulaire.addEventListener('submit', function (e) {\n//         e.preventDefault();\n//         formulaireLoading.classList.add('active');\n//         formData = new FormData(formulaire);\n//         axios({\n//             method: 'post',\n//             url: formulaire.getAttribute('action'),\n//             data: formData\n//           })\n//           .then(response => {\n//             if (formulaireLoading.classList.contains('active')) {\n//               formulaireLoading.classList.remove('active');\n//             }\n//             if (response.data) {\n//               formulaireResultContainer.innerText = '';\n//               for (const reponse of response.data.items) {\n//                 console.log(reponse);\n//                 createExoResultat(reponse, formulaireResultContainer);\n//               }\n//             }\n//             console.log(response);\n//           })\n//           .catch(() => {\n//             console.log('fatal error');\n//           });\n//       });\n//     }\n//   });\n// }\n\n//# sourceURL=webpack:///./src/js/pageProf.js?");

/***/ }),

/***/ "./src/scss/main.scss":
/*!****************************!*\
  !*** ./src/scss/main.scss ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// extracted by mini-css-extract-plugin\n\n//# sourceURL=webpack:///./src/scss/main.scss?");

/***/ })

/******/ });
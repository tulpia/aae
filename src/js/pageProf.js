/* eslint-disable func-names */
/* eslint-disable no-console */
import axios from 'axios';

let formData;

document.addEventListener('DOMContentLoaded', () => {
  // -----
  // ONGLETS
  // -----
  const btnOnglets = document.querySelectorAll('.btn-onglet');
  const secOnglets = document.querySelectorAll('.sec-onglet');

  for (const btn of btnOnglets) {
    btn.addEventListener('click', () => {
      if (document.querySelector('.sec-onglet.active')) {
        document.querySelector('.sec-onglet.active').classList.remove('active');
      }
      if (document.querySelector('.btn-onglet.active')) {
        document.querySelector('.btn-onglet.active').classList.remove('active');
      }
      for (const sec of secOnglets) {
        if (btn.getAttribute('data-name') === sec.getAttribute('data-name')) {
          sec.classList.add('active');
          btn.classList.add('active');
        }
      }
    });
  }

  btnOnglets[0].click();

  // -----
  // FILTRE
  // -----
  const formulaire = document.querySelector('.filtreFormulaireResultats');
  const formulaireResultContainer = document.querySelector('.content__list-questions--resultats');
  const formulaireQuestionnaires = document.querySelector('.filtreFormulaireQuestionnaires');
  const formulaireQuestionnairesResultContainer = document.querySelector(
    '.content__list-questions--questionnaires'
  );

  // fonction pour créér des exos
  const createExo = (content, finalContainer) => {
    // creation du container
    const createContainer = document.createElement('div');
    createContainer.className = 'question-container';

    // creation du conteneur du titre
    const createTitleContainer = document.createElement('div');
    createTitleContainer.className = 'questions-container__title-container';
    createContainer.appendChild(createTitleContainer);

    // creation du titre
    const createTitle = document.createElement('p');
    createTitle.className = 'question-container__title';
    createTitle.innerText = content.titre;
    createTitleContainer.appendChild(createTitle);

    // creation du formulaire
    const createForm = document.createElement('form');
    createForm.className = 'questions-container__btn-editer';
    createForm.setAttribute('method', 'post');
    createForm.setAttribute('action', 'index.php');
    createTitleContainer.appendChild(createForm);

    // creation des inputs hidden
    const createHiddenInput1 = document.createElement('input');
    createHiddenInput1.setAttribute('type', 'hidden');
    createHiddenInput1.setAttribute('name', 'action');
    createHiddenInput1.setAttribute('value', 'show_questionnaireDetail');
    createForm.appendChild(createHiddenInput1);

    const createHiddenInput2 = document.createElement('input');
    createHiddenInput2.setAttribute('type', 'hidden');
    createHiddenInput2.setAttribute('name', 'idQuestionnaire');
    createHiddenInput2.setAttribute('value', content.id);
    createForm.appendChild(createHiddenInput2);

    // creation du bouton fleche
    const createLabelFleche = document.createElement('label');
    createLabelFleche.className = 'btn-editer';
    createForm.appendChild(createLabelFleche);

    const createLabelInput = document.createElement('input');
    createLabelInput.setAttribute('type', 'submit');
    createLabelInput.className = 'btn-editer-text';
    createLabelFleche.appendChild(createLabelInput);

    // creation des details - container
    const createDetailsContainer = document.createElement('div');
    createDetailsContainer.className = 'question-container__details';
    createContainer.appendChild(createDetailsContainer);

    // creation des details - matiere
    const createDetailsMatiere = document.createElement('p');
    createDetailsMatiere.className = 'details__matiere';
    createDetailsMatiere.innerText = content.matiere;
    createDetailsContainer.appendChild(createDetailsMatiere);

    // creation des details - classe
    const createDetailsClasse = document.createElement('span');
    createDetailsClasse.className = 'details__matiere';
    createDetailsClasse.innerText = `, ${content.niveau}`;
    createDetailsMatiere.appendChild(createDetailsClasse);

    // creation des details - date
    const createDetailsDate = document.createElement('p');
    createDetailsDate.className = 'details__date';
    createDetailsDate.innerText = content.dateCrea;
    createDetailsContainer.appendChild(createDetailsDate);

    finalContainer.appendChild(createContainer);
  };

  const createExoResultat = (content, finalContainer) => {
    // creation du container
    const createContainer = document.createElement('div');
    createContainer.className = 'question-container';

    // check si c'est une archive$
    if (content.isArchive === 1) {
      createContainer.classList.add('is-archive')
    }

    // creation du conteneur du titre
    const createTitleContainer = document.createElement('div');
    createTitleContainer.className = 'questions-container__title-container';
    createContainer.appendChild(createTitleContainer);

    // creation du titre
    const createTitle = document.createElement('p');
    createTitle.className = 'question-container__title';
    createTitle.innerText = content.titre;
    createTitleContainer.appendChild(createTitle);

    // creation du formulaire
    const createForm = document.createElement('form');
    createForm.className = 'questions-container__btn-editer';
    createForm.setAttribute('method', 'post');
    createForm.setAttribute('action', 'index.php');
    createTitleContainer.appendChild(createForm);

    // creation des inputs hidden
    const createHiddenInput1 = document.createElement('input');
    createHiddenInput1.setAttribute('type', 'hidden');
    createHiddenInput1.setAttribute('name', 'action');
    createHiddenInput1.setAttribute('value', 'show_resultatDetail');
    createForm.appendChild(createHiddenInput1);

    const createHiddenInput2 = document.createElement('input');
    createHiddenInput2.setAttribute('type', 'hidden');
    createHiddenInput2.setAttribute('name', 'idResultat');
    createHiddenInput2.setAttribute('value', content.id);
    createForm.appendChild(createHiddenInput2);

    // creation du bouton fleche
    const createLabelFleche = document.createElement('label');
    createLabelFleche.className = 'btn-editer';
    createForm.appendChild(createLabelFleche);

    const createLabelInput = document.createElement('input');
    createLabelInput.setAttribute('type', 'submit');
    createLabelInput.className = 'btn-editer-text';
    createLabelFleche.appendChild(createLabelInput);

    // creation des details - container
    const createDetailsContainer = document.createElement('div');
    createDetailsContainer.className = 'question-container__details';
    createContainer.appendChild(createDetailsContainer);

    // creation des details - date
    const createDetailsDate = document.createElement('p');
    createDetailsDate.className = 'details__matiere';
    createDetailsDate.innerText = content.dateAccessible;
    createDetailsContainer.appendChild(createDetailsDate);

    // creation des details - matiere
    const createDetailsMatiere = document.createElement('span');
    createDetailsMatiere.className = 'details__matiere';
    createDetailsMatiere.innerText = `, ${content.matiere}`;
    createDetailsDate.appendChild(createDetailsMatiere);

    // creation des details - classe
    const createDetailsClasse = document.createElement('p');
    createDetailsClasse.className = 'details__matiere';
    createDetailsClasse.innerText = content.classe;
    createDetailsContainer.appendChild(createDetailsClasse);

    // creation des details - classe - classeNom
    if (content.ClasseNom) {
      const createDetailsClasseNom = document.createElement('span');
      createDetailsClasseNom.className = 'details__matiere';
      createDetailsClasseNom.innerText = ` ${content.ClasseNom}`;
      createDetailsClasse.appendChild(createDetailsClasseNom);
    }

    // creation des details - classe - classeNom - optionCours
    if (content.optionCours !== null) {
      const createDetailsoptionCours = document.createElement('span');
      createDetailsoptionCours.className = 'details__matiere';
      createDetailsoptionCours.innerText = ` ${content.optionCours}`;
      createDetailsClasse.appendChild(createDetailsoptionCours);
    }

    // creation des reponses - container
    const createReponses = document.createElement('p');
    createReponses.className = 'details__matiere';
    createReponses.innerText = `Réponses : ${content.nbRepondu} / ${content.nbAutoEval}`;
    createDetailsContainer.appendChild(createReponses);

    // creation des reponses - container
    if (content.dateDerReponse !== null) {
      const createLastReponse = document.createElement('p');
      createLastReponse.className = 'details__matiere';
      createLastReponse.innerText = `Dernière réponse le : ${content.dateDerReponse}`;
      createDetailsContainer.appendChild(createLastReponse);
    }

    finalContainer.appendChild(createContainer);
  };

  // requete ajax pour le filtre questionnaires
  if (formulaireQuestionnaires) {
    const formulaireLoading = document.querySelector('.loading-container--questionnaires');

    formulaireQuestionnaires.addEventListener('submit', function (e) {
      e.preventDefault();
      formulaireLoading.classList.add('active');

      formData = new FormData(formulaireQuestionnaires);
      axios({
          method: 'post',
          url: formulaireQuestionnaires.getAttribute('action'),
          data: formData
        })
        .then(response => {
          if (formulaireLoading.classList.contains('active')) {
            formulaireLoading.classList.remove('active');
          }
          if (response.data) {
            formulaireQuestionnairesResultContainer.innerText = '';
            for (const reponse of response.data.items) {
              console.log(reponse);
              createExo(reponse, formulaireQuestionnairesResultContainer);
            }
          }
        })
        .catch(() => {
          console.log('fatal error');
        });
    });
  }

  // requete ajax pour le filtre resultats
  if (formulaire) {
    const formulaireLoading = document.querySelector('.loading-container--resultats');

    formulaire.addEventListener('submit', function (e) {
      e.preventDefault();
      formulaireLoading.classList.add('active');

      formData = new FormData(formulaire);
      axios({
          method: 'post',
          url: formulaire.getAttribute('action'),
          data: formData
        })
        .then(response => {
          if (formulaireLoading.classList.contains('active')) {
            formulaireLoading.classList.remove('active');
          }
          if (response.data) {
            formulaireResultContainer.innerText = '';
            for (const reponse of response.data.items) {
              console.log(reponse);
              createExoResultat(reponse, formulaireResultContainer);
            }
          }
          console.log(response);
        })
        .catch(() => {
          console.log('fatal error');
        });
    });
  }
});
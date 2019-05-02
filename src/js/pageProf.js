/* eslint-disable func-names */
/* eslint-disable no-console */
import axios from "axios";

let formData;

document.addEventListener('DOMContentLoaded', () => {
  // -----
  // ONGLETS
  // -----
  const btnOnglets = document.querySelectorAll('.btn-onglet')
  const secOnglets = document.querySelectorAll('.sec-onglet')

  for (const btn of btnOnglets) {
    btn.addEventListener('click', () => {
      if (document.querySelector('.sec-onglet.active')) {
        document.querySelector('.sec-onglet.active').classList.remove('active')
      }
      if (document.querySelector('.btn-onglet.active')) {
        document.querySelector('.btn-onglet.active').classList.remove('active')
      }
      for (const sec of secOnglets) {
        if (btn.getAttribute('data-name') === sec.getAttribute('data-name')) {
          sec.classList.add('active')
          btn.classList.add('active')
        }
      }
    })
  }

  btnOnglets[0].click()

  // -----
  // FILTRE
  // -----
  const formulaire = document.querySelector(".filtreFormulaire")
  const formulaireResultContainer = document.querySelector('.content__list-questions')

  // fonction pour créér des exos
  const createExo = (content) => {
    // creation du container
    const createContainer = document.createElement('div')
    createContainer.className = 'question-container'

    // creation du conteneur du titre
    const createTitleContainer = document.createElement('div')
    createTitleContainer.className = 'questions-container__title-container'
    createContainer.appendChild(createTitleContainer)

    // creation du titre
    const createTitle = document.createElement('p')
    createTitle.className = 'question-container__title'
    createTitle.innerText = content.titre
    createTitleContainer.appendChild(createTitle)

    // creation du formulaire
    const createForm = document.createElement('form')
    createForm.className = 'questions-container__btn-editer'
    createForm.setAttribute('method', 'post')
    createForm.setAttribute('action', 'index.php')
    createTitleContainer.appendChild(createForm)

    // creation des inputs hidden
    const createHiddenInput1 = document.createElement('input')
    createHiddenInput1.setAttribute('type', 'hidden')
    createHiddenInput1.setAttribute('name', 'action')
    createHiddenInput1.setAttribute('value', 'show_questionnaireDetail')
    createForm.appendChild(createHiddenInput1)

    const createHiddenInput2 = document.createElement('input')
    createHiddenInput2.setAttribute('type', 'hidden')
    createHiddenInput2.setAttribute('name', 'idQuestionnaire')
    createHiddenInput2.setAttribute('value', content.id)
    createForm.appendChild(createHiddenInput2)

    // creation du bouton fleche
    const createLabelFleche = document.createElement('label')
    createLabelFleche.className = 'btn-editer'
    createForm.appendChild(createLabelFleche)

    const createLabelInput = document.createElement('input')
    createLabelInput.setAttribute('type', 'submit')
    createLabelInput.className = 'btn-editer-text'
    createLabelFleche.appendChild(createLabelInput)

    // creation des details - container
    const createDetailsContainer = document.createElement('div')
    createDetailsContainer.className = 'question-container__details'
    createContainer.appendChild(createDetailsContainer)

    // creation des details - matiere
    const createDetailsMatiere = document.createElement('p')
    createDetailsMatiere.className = 'details__matiere'
    createDetailsMatiere.innerText = content.matiere
    createDetailsContainer.appendChild(createDetailsMatiere)

    // creation des details - classe
    const createDetailsClasse = document.createElement('span')
    createDetailsClasse.className = 'details__matiere'
    createDetailsClasse.innerText = `, ${content.classe}`
    createDetailsMatiere.appendChild(createDetailsClasse)

    // creation des details - date
    const createDetailsDate = document.createElement('p')
    createDetailsDate.className = 'details__date'
    createDetailsDate.innerText = content.dateAccessible
    createDetailsContainer.appendChild(createDetailsDate)

    formulaireResultContainer.appendChild(createContainer)
  }

  // requete ajax
  if (formulaire) {
    const formulaireLoading = document.querySelector('.loading-container')

    formulaire.addEventListener("submit", function (e) {
      e.preventDefault();
      formulaireLoading.classList.add('active')

      formData = new FormData(formulaire);
      axios({
          method: "post",
          url: formulaire.getAttribute("action"),
          data: formData
        }).then((response) => {
          if (formulaireLoading.classList.contains('active')) {
            formulaireLoading.classList.remove('active')
          }
          if (response.data) {
            formulaireResultContainer.innerText = ''
            for (const reponse of response.data.items) {
              console.log(reponse)
              createExo(reponse)
            }
          }
          console.log(response)
        })
        .catch(() => {
          console.log('fatal error')
        })
    })
  }
})
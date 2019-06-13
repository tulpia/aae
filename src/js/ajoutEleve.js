/* eslint-disable func-names */
/* eslint-disable no-console */
import axios from 'axios';

let formData;

if (document.querySelector('.formulaireAjoutEleves')) {

  document.addEventListener('DOMContentLoaded', () => {
    const formContainer = document.querySelector('.formulaireAjoutEleves');
    const loadingContainer = formContainer.querySelector('.loading-container--submit');
    const feedback = formContainer.querySelector('.links-container');
    const feedbackContainer = formContainer.querySelector('.feedback-container');
    const linksContainer = formContainer.querySelector('.links-container__links');

    // Fonction pour créer des liens pour télécharger les fichiers
    const downloadCsv = (data) => {
      const linkContainer = document.createElement('a');
      linkContainer.setAttribute('href', data);
      const linkText = document.createElement('p');
      linkText.innerHTML = data;
      linkContainer.appendChild(linkText);
      linksContainer.appendChild(linkContainer);
    }

    formContainer.addEventListener('submit', (e) => {
      e.preventDefault();

      // Ajout de la classe disabled au formulaire
      formContainer.classList.add('disabled');

      // Ajout de la classe active au loader
      loadingContainer.classList.add('active');

      formData = new window.FormData(formContainer);

      axios({
          method: 'post',
          url: formContainer.getAttribute('action'),
          data: formData,
          config: {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        })
        .then((response) => {
          console.log(response);
          if (response.data) {
            console.log(response.data);
            // Jarté la classe disabled du formulaire
            if (formContainer.classList.contains('disabled')) {
              formContainer.classList.remove('disabled');
            };

            // Jarté la classe active du loader
            if (loadingContainer.classList.contains('active')) {
              loadingContainer.classList.remove('active');
            };

            // -----FEEDBACK
            feedback.classList.add('active');
            // Telechargements

            for (const link of response.data.links) {
              downloadCsv(link);
            }
            // Message renvoyé
            feedbackContainer.innerHTML = response.data.message
          }
        })
        .catch((error) => {
          console.log(error);
        });
    })
  })
}
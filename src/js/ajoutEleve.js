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
    const uploadOk = formContainer.querySelector('.upload-ok');
    const btnSubmit = formContainer.querySelector('.btn-submit--real');
    const ohShitContainer = document.querySelector('.oh-shit__container');

    // Fonction pour créer des liens pour télécharger les fichiers
    // eslint-disable-next-line no-unused-vars
    const downloadCsv = data => {
      const divLinkContainer = document.createElement('div');
      const linkContainer = document.createElement('a');
      linkContainer.setAttribute('href', data.name);
      const linkText = document.createElement('p');
      linkText.innerHTML = data.name;
      linkContainer.appendChild(linkText);
      const linkWarning = document.createElement('p');
      linkWarning.className = 'warning';
      linkWarning.innerHTML = data.message;
      divLinkContainer.appendChild(linkContainer);
      divLinkContainer.appendChild(linkWarning);
      linksContainer.appendChild(divLinkContainer);
      if (data.error) {
        divLinkContainer.classList.add('error');
      }
    };

    formContainer.addEventListener('submit', e => {
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
        .then(response => {
          console.log(response);
          if (response.data) {
            console.log(response.data);
            // Jarté la classe disabled du formulaire
            if (formContainer.classList.contains('disabled')) {
              formContainer.classList.remove('disabled');
            }

            // Jarté la classe active du loader
            if (loadingContainer.classList.contains('active')) {
              loadingContainer.classList.remove('active');
            }

            // Ajout de la classe sur le bouton cachant le submit
            if (!uploadOk.classList.contains('active')) {
              uploadOk.classList.add('active');
            }

            // Ajout du disabled au bouton submit
            btnSubmit.disabled = true;

            // Ajout de la classe active au oh shit container
            // ohShitContainer.classList.add('active');

            // -----FEEDBACK
            feedback.classList.add('active');
            // Telechargements

            for (const link of response.data.links) {
              downloadCsv(link);
              console.log(link);
            }
            // Message renvoyé
            feedbackContainer.innerHTML = response.data.message;
          }
        })
        .catch(error => {
          console.log(error);
        });
    });

    // Oh Shit - requete ajax
    // const formOhShit = ohShitContainer.querySelector('form');
    // const ohShitFeedback = ohShitContainer.querySelector('.feedback-container');
    // const ohShitUploadOk = ohShitContainer.querySelector('.upload-ok');
    // const ohShitLoader = ohShitContainer.querySelector('.loading-container');

    // formOhShit.addEventListener('submit', e => {
    //   e.preventDefault();

    //   ohShitLoader.classList.add('active');

    //   axios({
    //     method: 'post',
    //     url: formOhShit.getAttribute('action'),
    //     config: {
    //       headers: {
    //         'Content-Type': 'multipart/form-data'
    //       }
    //     }
    //   })
    //     .then(response => {
    //       console.log(response);

    //       if (response.data.code === 200) {
    //         // On jarte le loader
    //         if (ohShitLoader.classList.contains('active')) {
    //           ohShitLoader.classList.remove('active');
    //         }

    //         // On ajoute un done sur le bouton
    //         if (!ohShitUploadOk.classList.contains('active')) {
    //           ohShitUploadOk.classList.add('active');
    //         }

    //         // On ajoute la classe au feedback container
    //         if (!ohShitFeedback.classList.contains('active')) {
    //           ohShitFeedback.querySelector('p').innerHTML = response.data.message;
    //           ohShitFeedback.classList.add('active');
    //         }
    //       }
    //     })
    //     .catch(error => {
    //       console.log(error);
    //     });
    // });
  });
}

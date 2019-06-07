/* eslint-disable func-names */
/* eslint-disable no-console */
import axios from 'axios';

let formData;

if (document.querySelector('.formulaireAjoutEleves')) {
  document.addEventListener('DOMContentLoaded', () => {
    const formContainer = document.querySelector('.formulaireAjoutEleves');
    console.log(formContainer);

    console.log('heeloo')

    formContainer.addEventListener('submit', (e) => {
      e.preventDefault();

      formData = new window.FormData(formContainer);

      for (const pair of formData.entries()) {
        console.log(`${pair[0]  }, ${  pair[1]}`);
      }

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
        })
        .catch((error) => {
          console.log(error);
        });
    })
  })
}
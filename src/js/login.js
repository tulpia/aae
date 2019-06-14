if (document.querySelector('.block-login')) {
  document.addEventListener('DOMContentLoaded', () => {
    const inputProf = document.querySelector('.profCheck');
    const inputEleve = document.querySelector('.eleveCheck');
    const passwordContainer = document.querySelector('.pwd');

    inputProf.addEventListener('change', () => {
      if (inputProf.checked) {
        if (!passwordContainer.classList.contains('active')) {
          passwordContainer.classList.add('active')
        }
      }
    })

    inputEleve.addEventListener('change', () => {
      if (inputEleve.checked) {
        if (passwordContainer.classList.contains('active')) {
          passwordContainer.classList.remove('active')
        }
      }
    })
  })
}
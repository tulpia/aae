if (document.querySelector('.block-login')) {
  document.addEventListener('DOMContentLoaded', () => {
    const inputProf = document.querySelector('.profCheck');
    const inputEleve = document.querySelector('.eleveCheck');
    const passwordContainer = document.querySelector('.pwd');
    const forgotPwd = document.querySelector('.btn-link');

    inputProf.addEventListener('change', () => {
      if (inputProf.checked) {
        if (!passwordContainer.classList.contains('active')) {
          passwordContainer.classList.add('active');
        };
        if (!forgotPwd.classList.contains('active')) {
          forgotPwd.classList.add('active')
        };
      };
    });

    inputEleve.addEventListener('change', () => {
      if (inputEleve.checked) {
        if (passwordContainer.classList.contains('active')) {
          passwordContainer.classList.remove('active');
        };
        if (forgotPwd.classList.contains('active')) {
          forgotPwd.classList.remove('active')
        };
      };
    });
  });
};
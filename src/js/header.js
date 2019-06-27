document.addEventListener('DOMContentLoaded', () => {
    const btnHeaderContainer = document.querySelector('.account-container')

    if (btnHeaderContainer) {
        btnHeaderContainer.addEventListener('click', () => {
            btnHeaderContainer.classList.toggle('active')
        })
    }

    // Refermer le menu quand on clique hors du conteneur
    window.onclick = function(e) {
	  if (!e.target.matches('.account-container')) {

	    if (btnHeaderContainer.classList.contains('active')) {
	    	btnHeaderContainer.classList.remove('active');
	    }
	  }
	}
})
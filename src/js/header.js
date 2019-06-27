document.addEventListener('DOMContentLoaded', () => {
	window.onscroll = function() { stickyHeader() };

	var header = document.querySelector('.entire-header-container');
	var sticky = header.offsetTop,
		smaller = header.offsetHeight;

	function stickyHeader() {
		if (window.pageYOffset > sticky) {
	    	header.classList.add("sticky");
	  	} else {
	    	header.classList.remove("sticky");
	  	}
	}


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


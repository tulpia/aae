document.addEventListener('DOMContentLoaded', () => {
    const btnHeaderContainer = document.querySelector('.header-connected__btn-deconnect')

    if (btnHeaderContainer) {
        btnHeaderContainer.addEventListener('click', () => {
            btnHeaderContainer.classList.toggle('active')
        })
    }
})
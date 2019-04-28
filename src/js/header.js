document.addEventListener('DOMContentLoaded', () => {
    const btnHeaderContainer = document.querySelector('.header-connected__btn-deconnect')

    btnHeaderContainer.addEventListener('click', () => {
        btnHeaderContainer.classList.toggle('active')
    })
})
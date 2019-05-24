document.addEventListener('DOMContentLoaded', () => {
    const btnHeaderContainer = document.querySelector('.account-container')

    if (btnHeaderContainer) {
        btnHeaderContainer.addEventListener('click', () => {
            btnHeaderContainer.classList.toggle('active')
        })
    }
})
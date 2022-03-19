let element = document.getElementById('mainNav');

window.addEventListener('scroll', () => {
    if (window.scrollY > 1.5) {
        element?.classList.add('navbar-shrink');
    } else {
        element?.classList.remove('navbar-shrink');
    }
})
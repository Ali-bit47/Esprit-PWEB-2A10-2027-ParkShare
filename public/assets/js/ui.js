(() => {
    const spinner = document.querySelector('.page-spinner');
    const hideSpinner = () => {
        if (!spinner) return;
        spinner.classList.add('is-hidden');
        window.setTimeout(() => spinner.remove(), 300);
    };

    if (document.readyState === 'complete') {
        hideSpinner();
    } else {
        window.addEventListener('load', hideSpinner, { once: true });
    }

    const backToTop = document.querySelector('.back-to-top');
    if (!backToTop) return;

    const updateBackToTop = () => {
        backToTop.classList.toggle('is-visible', window.scrollY > 300);
    };

    window.addEventListener('scroll', updateBackToTop, { passive: true });
    updateBackToTop();
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();

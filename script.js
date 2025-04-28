document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.feature-section');

    function checkSections() {
        sections.forEach(section => {
            const rect = section.getBoundingClientRect();
            const isVisible = (rect.top <= window.innerHeight && rect.bottom >= 0);

            if (isVisible) {
                section.classList.add('active');
            } else {
                section.classList.remove('active');
            }
        });
    }

    window.addEventListener('scroll', checkSections);
    checkSections(); // Initial check
});

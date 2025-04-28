document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.feature-section');

    function checkSections() {
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollPosition = window.pageYOffset;

            if (scrollPosition > sectionTop + sectionHeight - windowHeight && scrollPosition < sectionTop + sectionHeight) {
                section.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', checkSections);
    checkSections(); // Initial check
});

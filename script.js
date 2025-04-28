document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.feature-section');

    function checkSections() {
        sections.forEach(section => {
            const rect = section.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            const isVisible = rect.top <= windowHeight * 0.75 && rect.bottom >= 0; // Adjusted trigger point

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

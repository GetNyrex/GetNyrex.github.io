// Fade-in animation on page load
window.addEventListener("load", () => {
  document.body.classList.add("loaded");
});

// Button click ripple animation
document.querySelectorAll("button").forEach(button => {
  button.addEventListener("click", function (e) {
    const ripple = document.createElement("span");
    ripple.classList.add("ripple");
    this.appendChild(ripple);

    // Position the ripple
    const x = e.clientX - this.getBoundingClientRect().left;
    const y = e.clientY - this.getBoundingClientRect().top;
    ripple.style.left = `${x}px`;
    ripple.style.top = `${y}px`;

    // Remove ripple after animation
    setTimeout(() => ripple.remove(), 600);
  });
});

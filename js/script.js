/*=============== CHANGE BACKGROUND HEADER ===============*/
function scrollHeader(){

    const header = document.getElementById('nav');
    const logo = document.getElementById('top-logo');

    // When the scroll is greater than 80 viewport height, add the scroll-header class to the header tag
    if(this.scrollY >= 80) header.classList.add('scroll-nav');  else header.classList.remove('scroll-nav');
    if(this.scrollY >= 80) logo.src = "img/logob.png";  else logo.src = "img/logow.png";
}
window.addEventListener('scroll', scrollHeader)


// Hambergar
const hamb = document.querySelector(".hamburger");
const navMenu = document.querySelector(".navmenu");

hamb.addEventListener("click", () => {
    hamb.classList.toggle("active");
    navMenu.classList.toggle("active");
})
document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
    hamb.classList.remove("active");
    navMenu.classList.remove("active");
}))
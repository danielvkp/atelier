(function() {
    "use strict";

    const ud_header = document.querySelector(".ud-header")


    const sticky = ud_header.offsetTop

    const top_header = document.getElementById('top_header')

    let navbarToggler = document.querySelector("#navbarToggler")
    const navbarCollapse = document.querySelector("#navbarCollapse")

    navbarToggler.addEventListener("click", () => {
        navbarToggler.classList.toggle("navbarTogglerActive")
        navbarCollapse.classList.toggle("hidden")
    })

    document.querySelectorAll("#navbarCollapse ul li:not(.submenu-item) a").forEach((e) =>
        e.addEventListener("click", () => {
            navbarToggler.classList.remove("navbarTogglerActive")
            navbarCollapse.classList.add("hidden")
        })
    )

    const submenuItems = document.querySelectorAll(".submenu-item")
    submenuItems.forEach((el) => {
        el.querySelector("a").addEventListener("click", () => {
            el.querySelector(".submenu").classList.toggle("hidden")
        })
    })



    Math.easeInOutQuad = function(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return (c / 2) * t * t + b;
        t--;
        return (-c / 2) * (t * (t - 2) - 1) + b;
    };


})()
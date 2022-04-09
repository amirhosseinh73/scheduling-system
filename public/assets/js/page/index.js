const docReadyFunctions = function () {
    loadSwiper();
};

doc_ready( docReadyFunctions );

function loadSwiper() {
    new Swiper(".mySwiper", {
        autoplay: {
            delay: 5000,
        },
        effect: "fade",
        loop: true,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
    });
}

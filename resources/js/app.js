import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.Swiper = Swiper;
AOS.init();

const initSwiper = (selector, breakpoints) => {
    const container = document.querySelector(selector);
    if (!container) return;

    new Swiper(selector, {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: `${selector} .swiper-pagination`,
            clickable: true,
        },
        navigation: {
            nextEl: `${selector} .swiper-button-next`,
            prevEl: `${selector} .swiper-button-prev`,
        },
        scrollbar: {
            el: `${selector} .swiper-scrollbar`,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        breakpoints,
    });
};

if (location.pathname === "/" || location.pathname === "") {
    initSwiper(".activity-swiper-container", {
        0: { slidesPerView: 1 },
        800: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1200: { slidesPerView: 4 },
    });

    initSwiper(".tip-swiper-container", {
        0: { slidesPerView: 1 },
        800: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
        1200: { slidesPerView: 4 },
    });

    initSwiper(".magazine-swiper-container", {
        800: { slidesPerView: 1 },
        1024: { slidesPerView: 2 },
        1280: { slidesPerView:3 }
    });
}

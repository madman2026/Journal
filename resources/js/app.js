import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.Swiper = Swiper;

// Initialize AOS
AOS.init();

// Helper function to init Swiper
const initSwiper = (selector, breakpoints = {}) => {
    const container = document.querySelector(selector);
    if (!container) return;

    return new Swiper(selector, {
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

// Only init swipers on home page
if (["/", ""].includes(location.pathname)) {
    const swiperConfigs = [
        { selector: ".activity-swiper-container", breakpoints: { 0: { slidesPerView: 1 }, 800: { slidesPerView: 2 }, 1024: { slidesPerView: 3 }, 1200: { slidesPerView: 4 } } },
        { selector: ".tip-swiper-container", breakpoints: { 0: { slidesPerView: 1 }, 800: { slidesPerView: 2 }, 1024: { slidesPerView: 3 }, 1200: { slidesPerView: 4 } } },
        { selector: ".magazine-swiper-container", breakpoints: { 800: { slidesPerView: 1 }, 1024: { slidesPerView: 2 }, 1280: { slidesPerView: 3 } } },
    ];

    swiperConfigs.forEach(config => initSwiper(config.selector, config.breakpoints));
}

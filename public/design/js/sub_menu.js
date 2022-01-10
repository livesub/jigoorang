// 서브카테고리

var swiper = new Swiper(".submenu", {
    slidesPerView: 10,
    spaceBetween: 0,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
    },
    breakpoints: {
          200: {
               slidesPerView: 2,
               spaceBetween: 0
          },
        320: {
            slidesPerView: 4,
            spaceBetween: 0
        },
        480: {
            slidesPerView: 4,
            spaceBetween: 0
        },
        640: {
            slidesPerView: 4,
            spaceBetween: 0
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 0
        },
        1024: {
            slidesPerView: 5,
            spaceBetween: 0
        },
        1200: {
            slidesPerView: 7,
            spaceBetween: 0
        }
    }
});

var swiper = new Swiper(".submenu_sol", {
    slidesPerView: 10,
    spaceBetween: 10,
    navigation: {
        nextEl: '.swiper-button-next01',
        prevEl: '.swiper-button-prev01'
    },
    breakpoints: {
          320: {
               slidesPerView: 4,
               spaceBetween: 10
          },
    
          480: {
               slidesPerView: 4,
               spaceBetween: 10
          },
        640: {
            slidesPerView: 5,
            spaceBetween: 10
        },
        768: {
            slidesPerView: 10,
            spaceBetween: 10
        },
        910: {
          slidesPerView: 9.5,
          spaceBetween: 10
      },
        1024: {
            slidesPerView: 9.5,
            spaceBetween: 10
        },
        1200: {
            slidesPerView: 10,
            spaceBetween: 10
        }
    }
});
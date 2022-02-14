// 서브카테고리

var swiper3 = new Swiper(".submenu", {
    slidesPerView: 10,
    spaceBetween: 0,

    observer: true, 
    observeParents: true,

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

function sub_slide(cot) {
    alert()
    swiper3.slideTo(cot, 800, true)
}


var swiper4 = new Swiper(".submenu_sol", {
    //initialSlide: $("#tt").val(),
    freeMode : false,
    // slideToClickedSlide : $("#tt").val(),
    watchOverflow : true,
    slidesPerView: 'auto',
    //centerInsufficientSlides: true,
    spaceBetween: 0,
    navigation: {
        nextEl: '.swiper-button-next01',
        prevEl: '.swiper-button-prev01'
    },

    clickable: true,
    freeMode : false,
    observer: true,	// 추가
    observeParents: true,	// 추가


    breakpoints: {
        320: {
            slidesPerView: 4,
            spaceBetween: 0
        },

        480: {
            slidesPerView: 5.5,
            spaceBetween: 0
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
    },

});


function sub_m_slide(num) {
    swiper4.slideTo(num, 800, true)
}
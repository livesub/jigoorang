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
    initialSlide: $("#tt").val(),
    slidesPerView: 'auto',
    spaceBetween: 10,
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
    },

});


//서브 슬라이드 메뉴 버튼 이벤트
// let act_btn = document.querySelectorAll(".swiper-wrapper.submenu_innr .swiper-slide");

// function handleClick(event) {

//   if (event.target.classList[1] === "active") {
//     event.target.classList.remove("active");
//   } else {
//     for (var i = 0; i < act_btn.length; i++) {
//         act_btn[i].classList.remove("active");
//     }

//     event.target.classList.add("active");
//   }
// }

// function init() {
//   for (var i = 0; i < act_btn.length; i++) {
//     act_btn[i].addEventListener("click", handleClick);
//   }
// }

// init();
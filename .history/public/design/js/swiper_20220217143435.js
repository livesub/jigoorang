// 메인 스와이퍼

var swiper = new Swiper(".mainSwiper", {
  autoplay : {  // 자동 슬라이드 설정 , 비 활성화 시 false
    delay : 3000,   // 시간 설정
    disableOnInteraction : false,  // false로 설정하면 스와이프 후 자동 재생이 비활성화 되지 않음
  },
  pagination: {
    el: ".swiper-pagination",
  },
  // navigation: {
  //   nextEl: ".swiper-button-next",
  //   prevEl: ".swiper-button-prev",
  // },
});

var swiper = new Swiper(".bastSwiper", {
  slidesPerView: 4,
  spaceBetween: 10,
  grabCursor: true,
  // pagination: {
  //   el: ".swiper-pagination",
  //   clickable: true,
  // },
  navigation: {
    nextEl: ".swiper-button-next-1",
    prevEl: ".swiper-button-prev-1",
  },

  breakpoints: {
    290: {
      slidesPerView: 2.1,
      spaceBetween: 0,
    },
    360: {
      slidesPerView: 2.3,
      spaceBetween: 0,
    },
    480: {
      slidesPerView: 3.2,
      spaceBetween: 10,
    },
    980: {
      slidesPerView: 3.5,
      spaceBetween: 10,
    },
    1024: {
      slidesPerView: 4,
      spaceBetween: 10,
    },
    1200: {
      slidesPerView: 4,
      spaceBetween: 10,
    },
    1460: {
      slidesPerView: 4,
      spaceBetween: 10,
    },
    1600: {
      slidesPerView: 4,
      spaceBetween: 10,
    },
  }
});


var swiper = new Swiper(".saleSwiper", {
  slidesPerView: 5.5,
  spaceBetween: 0,
  slidesPerGroup: 2,
  grabCursor: true,
  // pagination: {
  //   el: ".swiper-pagination",
  //   clickable: true,
  // },
  navigation: {
    nextEl: ".swiper-button-next-2",
    prevEl: ".swiper-button-prev-2",
  },

  breakpoints: {
    290: {
      slidesPerView: 2.1,
      spaceBetween: 5,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    360: {
      slidesPerView: 2.1,
      spaceBetween: 7,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    480: {
      slidesPerView: 3.5,
      spaceBetween: 10,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    980: {
      slidesPerView: 3.5,
      spaceBetween: 10,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    1024: {
      slidesPerView: 4.5,
      spaceBetween: 10,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    1200: {
      slidesPerView: 5.3,
      spaceBetween: 10,
      slidesOffsetBefore: 0,
    },
    1460: {
      slidesPerView: 6.5,
      spaceBetween: 10,
      slidesOffsetBefore: 120,
    },
    1600: {
      slidesPerView: 6.5,
      spaceBetween: 10,
      slidesOffsetBefore: 200,
    },

    1800: {
      slidesPerView: 6.5,
      spaceBetween: 10,
      slidesOffsetBefore: 270,
    },

    1900: {
      slidesPerView: 6.5,
      spaceBetween: 10,
      slidesOffsetBefore: 335,
    },

  }
});

var swiper = new Swiper(".saleSwiper2", {
  slidesPerView: 5.3,
  spaceBetween: 0,
  slidesPerGroup: 2,
  grabCursor: true,
  // pagination: {
  //   el: ".swiper-pagination",
  //   clickable: true,
  // },
  navigation: {
    nextEl: ".swiper-button-next-3",
    prevEl: ".swiper-button-prev-3",
  },

  // centeredSlides: true,


  breakpoints: {
    290: {
      slidesPerView: 2.1,
      spaceBetween: 5,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    360: {
      slidesPerView: 2.1,
      spaceBetween: 7,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    480: {
      slidesPerView: 3.5,
      spaceBetween: 10,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    980: {
      slidesPerView: 3.5,
      spaceBetween: 10,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    1024: {
      slidesPerView: 4.5,
      spaceBetween: 10,
      slidesOffsetBefore: 0,
      slidesPerGroup: 2,
    },
    1200: {
      slidesPerView: 5.3,
      spaceBetween: 10,
      slidesOffsetBefore: 0,
    },
    1460: {
      slidesPerView: 6.5,
      spaceBetween: 10,
      slidesOffsetBefore: 120,
    },
    1600: {
      slidesPerView: 6.5,
      spaceBetween: 10,
      slidesOffsetBefore: 200,
    },

    1800: {
      slidesPerView: 6.5,
      spaceBetween: 10,
      slidesOffsetBefore: 270,
    },
    1900: {
      slidesPerView: 6.5,
      spaceBetween: 10,
      slidesOffsetBefore: 335,
    },
  }
});

var swiper = new Swiper(".saleSwiper3", {
  slidesPerView: 4,
  spaceBetween: 0,
  slidesPerGroup: 2,
  grabCursor: true,
  // pagination: {
  //   el: ".swiper-pagination",
  //   clickable: true,
  // },
  navigation: {
    nextEl: ".swiper-button-next-4",
    prevEl: ".swiper-button-prev-4",
  },

  breakpoints: {
    290: {
      slidesPerView: 2.1,
      spaceBetween: 5,
      slidesPerGroup: 2,
    },
    360: {
      slidesPerView: 2.1,
      spaceBetween: 7,
      slidesPerGroup: 2,
    },
    480: {
      slidesPerView: 3.5,
      spaceBetween: 10,
      slidesPerGroup: 2,
    },
    1024: {
      slidesPerView: 4,
      spaceBetween: 10,
      slidesPerGroup: 2,
    },
  }
});



var swiper = new Swiper(".Swiper3", {
  pagination: {
    el: ".swiper-pagination",
  },
  // navigation: {
  //   nextEl: ".swiper-button-next",
  //   prevEl: ".swiper-button-prev",
  // },
  autoplay : {  // 자동 슬라이드 설정 , 비 활성화 시 false
    delay : 3000,   // 시간 설정
    disableOnInteraction : false,  // false로 설정하면 스와이프 후 자동 재생이 비활성화 되지 않음
  },
});




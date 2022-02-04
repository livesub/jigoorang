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

// var swiper4 = new Swiper(".submenu_sol", {
//     //initialSlide: $("#tt").val(),
//     freeMode : false,
//     slideToClickedSlide : $("#tt").val(),
//     watchOverflow : true,
//     slidesPerView: 'auto',
//     //centerInsufficientSlides: true,
//     spaceBetween: 10,
//     navigation: {
//         nextEl: '.swiper-button-next01',
//         prevEl: '.swiper-button-prev01'
//     },

//     clickable: true,
//     freeMode : false,
//     observer: true,	// 추가
//     observeParents: true,	// 추가


//     breakpoints: {
//         320: {
//             slidesPerView: 4.4,
//             spaceBetween: 0
//         },

//         480: {
//             slidesPerView: 5.5,
//             spaceBetween: 0
//           },
//         640: {
//             slidesPerView: 5,
//             spaceBetween: 10
//         },
//         768: {
//             slidesPerView: 10,
//             spaceBetween: 10
//         },
//         910: {
//           slidesPerView: 9.5,
//           spaceBetween: 10
//       },
//         1024: {
//             slidesPerView: 9.5,
//             spaceBetween: 10
//         },
//         1200: {
//             slidesPerView: 10,
//             spaceBetween: 10
//         }
//     },

// });


// function sub_m_slide(num) {
//     swiper4.slideTo(num, 1000, false)
// }


var swiper = new Swiper('.submenu_sol', {
    slidesPerView: 'auto',
    preventClicks: true,
    preventClicksPropagation: false,
});
// var $snbSwiperItem = $('.submenu_sol .swiper-wrapper .swiper-slide a');
// $snbSwiperItem.click(function(){
//     var target = $(this).parent();
//     $snbSwiperItem.parent().removeClass('on')
//     target.addClass('on');
//     muCenter(target);
// })

function muCenter(num){
    var snbwrap = $('.submenu_sol .swiper-wrapper');
    var targetPos = num.position();
    var box = $('.submenu_sol');
    var boxHarf = box.width()/2;
    var pos;
    var listWidth=0;
    
    snbwrap.find('.swiper-slide').each(function(){ listWidth += $(this).outerWidth(); })
    
    var selectTargetPos = targetPos.left + target.outerWidth()/2;
    if (selectTargetPos <= boxHarf) { // left
        pos = 0;
    }else if ((listWidth - selectTargetPos) <= boxHarf) { //right
        pos = listWidth-box.width();
    }else {
        pos = selectTargetPos - boxHarf;
    }
    
    setTimeout(function(){snbwrap.css({
        "transform": "translate3d("+ (pos*-1) +"px, 0, 0)",
        "transition-duration": "500ms"
    })}, 200);
}
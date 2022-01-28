// function openModal(){

//     document.querySelector('body').classList.add('modal-open')

// }

// function closeModal() {

//     document.querySelector('body').classList.remove('modal-open')

// }

// function openmodal_001() {

//     openModal();

//     document.querySelector('.modal.modal_001').classList.add('in');

// }

// function closemodal_001(){

//     closeModal();

//     document.querySelector('.modal.modal_001').classList.remove('in');

// }



function detilopenModal() {

    document.querySelector('body').classList.add('modal-open')

}

function detilcloseModal() {

    document.querySelector('body').classList.remove('modal-open')

}

function detilopenmodal_001() {

    detilopenModal();

    document.querySelector('.modal.modal_001').classList.add('in');

}

function detilclosemodal_001() {

    detilcloseModal();

    document.querySelector('.modal.modal_001').classList.remove('in');

}




// 개인정보 처리방침 모달
function detil2openModal() {

    document.querySelector('body').classList.add('modal-open')

}

function detil2closeModal() {

    document.querySelector('body').classList.remove('modal-open')

}

function detil2openmodal_001() {

    detil2openModal();

    document.querySelector('.modal.modal_001_1').classList.add('in');

}

function detil2closemodal_001() {

    detil2closeModal();

    document.querySelector('.modal.modal_001_1').classList.remove('in');

}










//배송지 모달 (추가)

function addressopenModal() {

    document.querySelector('body').classList.add('modal-open')

}

function addresscloseModal() {

    document.querySelector('body').classList.remove('modal-open')

}

function addressopenmodal_001() {

    addressopenModal();

    document.querySelector('.modal.modal_002').classList.add('in');

    baesongji();

}

function review_big(img_big) {
    addressopenModal();
    document.querySelector('.modal.modal_002').classList.add('in');
    $("#big_img").attr("src", img_big);
}

function addressclosemodal_001() {

    addresscloseModal();

    document.querySelector('.modal.modal_002').classList.remove('in');

}







//배송지 모달 (주소)

// function addressopen() {

//     document.querySelector('body').classList.add('modal-open')

// }

// function addressclose() {

//     document.querySelector('body').classList.remove('modal-open')

// }

// function addressopen_001() {

//     addressopen();

//     document.querySelector('.modal.modal_003').classList.add('in');

// }

// function addressclose_001() {
//     addressclose();
//     document.querySelector('.modal ').classList.remove('in');
// }





//배송지 모달 (입력)

function addressinputopen() {

    document.querySelector('body').classList.add('modal-open')

}

function addressinputclose() {

    document.querySelector('body').classList.remove('modal-open')

}

function addressinputopen_001() {

    addressinputopen();

    document.querySelector('.modal.modal_004').classList.add('in');

}

function addressinputclose_001() {

    addressinputclose();

    document.querySelector('.modal.modal_002').classList.remove('in');

}





//회원정보 (휴대폰 번호 변경)

function phoninputopen() {

    document.querySelector('body').classList.add('modal-open')

}

function phoninputclose() {

    document.querySelector('body').classList.remove('modal-open')

}

function phoninputopen_001() {

    phoninputopen();

    document.querySelector('.modal.modal_005').classList.add('in');

}

function phoninputclose_001() {

    phoninputclose();

    document.querySelector('.modal.modal_005').classList.remove('in');

}





//회원정보 (비밀번호 변경)

function pwinputopen() {

    document.querySelector('body').classList.add('modal-open')

}

function pwinputclose() {

    document.querySelector('body').classList.remove('modal-open')

}

function pwinputopen_001() {

    pwinputopen();

    document.querySelector('.modal.modal_006').classList.add('in');

}

function pwinputclose_001() {

    pwinputclose();

    document.querySelector('.modal.modal_006').classList.remove('in');

}








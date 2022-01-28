function openModal(){
    document.querySelector('body').classList.add('modal-open')
}
function closeModal() {
    document.querySelector('body').classList.remove('modal-open')
}
function openmodal_001() {
    openModal();
    document.querySelector('.modal_sh.modal_001').classList.add('in');
}        
function closemodal_001(){
    closeModal();
    document.querySelector('.modal_sh.modal_001').classList.remove('in');
}


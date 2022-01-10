
let imageMap = {};
function imageFormData() {
    let formData = new FormData();

    for (let key in imageMap) {
        console.log(imageMap[key]);
        formData.append("review_img[]", imageMap[key], imageMap[key].name);
    }

    // for (let value of formData.entries()) {
    //   console.log(value);
    // }
    return formData;
}

// let showimage = ["../../recources/imgs/arrow-option-01.png", "../../recources/imgs/arrow-option-01.png", "../../recources/imgs/arrow-option-01.png", "../../recources/imgs/arrow-option-01.png", "../../recources/imgs/arrow-option-01.png"]; //이미지 값 넣는곳
// changeWriteFile(showimage); //수정 함수 호출 

function changeWriteFile(uploadedUrls) {
    const view = document.querySelector(".flies");
    const fileUploaderEl = document.querySelector("#file_uploader");
    const parentEl = fileUploaderEl.parentElement.parentElement;
    const filesEl = view.parentElement.lastElementChild;
    let cnt = Number(filesEl.childElementCount);
    const attatchedFiles = fileUploaderEl.files;

    if (cnt + attatchedFiles.length > 5) {
        alert("파일 첨부는 최대 5개까지 가능합니다.");
        fileUploaderEl.value = "";
        return;
    }


    if (uploadedUrls != undefined) {
        for (const url of uploadedUrls) {
            makePreviewDiv(filesEl, url);
        }
    } else if (attatchedFiles.length > 0) {
        for (const file of attatchedFiles) {
            makePreviewDiv(filesEl, file);
        }
    }

    fileUploaderEl.value = "";
}

function makePreviewDiv(filesEl, fileOrUrl) {
    const childEl = document.createElement("div");
    childEl.classList.add("img_files");
    const image = document.createElement('img');
    childEl.id = "file_img_" + Date.now();
    if (fileOrUrl instanceof File) {
        image.src = URL.createObjectURL(fileOrUrl);
        imageMap[childEl.id] = fileOrUrl;
    } else if (typeof fileOrUrl === 'string') {
        console.log(fileOrUrl);
        image.src = fileOrUrl;
    }
    image.classList.add("img");

    const childRemoveEl = document.createElement("div");
    childRemoveEl.classList.add("remove");
    childRemoveEl.onclick = function (event) {
        attached_file_del(event, typeof fileOrUrl === 'string' ? fileOrUrl : null);
    };
    childRemoveEl.innerText = "remove";
    childEl.append(image);
    childEl.append(childRemoveEl);

    filesEl.append(childEl);
}

function attached_file_del(evnt, url) {
    var con_test = confirm("첨부파일을 삭제 하시겠습니까?");

    if (url != null) {
        console.log(url);
        //ajax file delete code (ajax 삭제 코드 넣는곳)
    }

    if (con_test == true) {
        const parentEl = evnt.target.parentElement;
        parentEl.remove();
        delete imageMap[parentEl.id];
    }
    else if (con_test == false) {
        return false;
    }
}
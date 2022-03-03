//const { exists } = require("laravel-mix/src/File");

let imageMap = {};
function review_save(review_type){
    var hap = 0;
    for(var k = 1; k <= 5; k++)
    {
        var obj_name = "score" + k;

        if($("#"+obj_name).val() == "" || $("#"+obj_name).val() == "0"){
            alert($("#ment" + k).text() + "를 평가 하세요.");
            return false;
        }

        hap = hap + parseFloat($("#"+obj_name).val());
    }

    var average = hap / 5;

    if($.trim($("#review_content").val()) == ""){
        alert("리뷰를 작성하세요\n(최소20자 이상)");
        $("#review_content").focus();
        return false;
    }

    //if(getTextLength($("#review_content").val()) < 20){
    if($("#review_content").val().length < 20){
        alert("리뷰를 작성하세요\n(최소20자 이상)");
        $("#review_content").focus();
        return false;
    }

    $("#temporary_yn").val(review_type);
    $("#average").val(average);

    let formData = new FormData(document.getElementById('review_form'));    //이미지와 form 값을 다 넘길때

    for (let key in imageMap) {
        //console.log(imageMap[key]);
        formData.append("review_img[]", imageMap[key], imageMap[key].name);
    }

    // for (let value of formData.entries()) {
    //   console.log(value);
    // }

    const target = document.getElementById('tmp_save_y');
    target.disabled = true;
    const target2 = document.getElementById('tmp_save_n');
    target2.disabled = true;

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
        type : 'post',
        url: $("#form_route").val(),
        processData: false,
        contentType: false,
        cache : false,
        data: formData,
        dataType : 'json',
        success : function(data){

            if(data.status == "img_error"){
                alert("이미지 용량이 큽니다\n용량을 줄여서 올려 주세요.");
                location.reload();
            }

            if(data.status == "temp_save"){
                alert("리뷰가 임시 등록되었습니다.");
                location.href = data.route;
            }

            if(data.status == "save_ok"){
                if (confirm("리뷰가 등록되었습니다.\n해당페이지에서 확인하시겠습니까?") == true){    //확인
                    location.href = data.my_page;
                }else{   //취소
                    location.href = data.route;
                }
            }

            if(data.status == "error"){
                alert("잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.");
                location.href = data.route;
            }
        },
        error: function(result){
            console.log(result);
        },

    });
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

    // if(fileUploaderEl.value!=""){
    //     var fileSize = attatchedFiles[0].size;
    //     var maxSize = 2 * 1024 * 1024;//2MB

    //     if(fileSize > maxSize){
    //        alert("첨부파일 사이즈는 2MB 이내로 등록 가능합니다. ");
    //        return;
    //     }
    // }

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

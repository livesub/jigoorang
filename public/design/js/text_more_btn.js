//글자 더보기(정량평가)
function more(cnt) {
    var content = $('#content_'+ cnt);
    var content_txt = content.text();

    var btn_more = $('#cot_more_'+ cnt);

    toggle_content();

    function toggle_content(){
        if(content.hasClass('short')){
            // 접기 상태
            btn_more.html('더보기');
            content.removeClass('short');
            content.addClass('notshort');
        }else{
            // 더보기 상태
            btn_more.html('접기');
            content.html(content_txt);
            content.addClass('short');
            content.removeClass('notshort');
        }
    }

}


function btn(cnt) {
    var content = $('#content_'+ cnt);
    var content_txt = content.text();
    var btn_more = $('#cot_more_'+ cnt);

    if(content_txt.length < 200){
        btn_more.hide();
        content.removeClass('notshort');
    }
}


//글자 더보기(쇼핑))
function shop_more(cnt) {
    var content = $('#shop_content_'+ cnt);
    var content_txt = content.text();

    var btn_more = $('#shop_cot_more_'+ cnt);

    toggle_content();

    function toggle_content(){
        if(content.hasClass('short')){
            // 접기 상태
            btn_more.html('더보기');
            content.removeClass('short');
            content.addClass('notshort');
        }else{
            // 더보기 상태
            btn_more.html('접기');
            content.html(content_txt);
            content.addClass('short');
            content.removeClass('notshort');
        }
    }
}

function shop_btn(cnt) {
    var content = $('#shop_content_'+ cnt);
    var content_txt = content.text();
    var btn_more = $('#shop_cot_more_'+ cnt);

    if(content_txt.length < 200){
        btn_more.hide();
        content.removeClass('notshort');
    }
}


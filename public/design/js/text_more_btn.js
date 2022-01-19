//글자 더보기
function more(cnt) {
    $('.box').each(function(){
        var content = $('#content_'+ cnt);
        var content_txt = content.text();
        var btn_more = $('#cot_more_'+ cnt);

        if(content_txt.length < 200){
            btn_more.hide();
            content.removeClass('notshort');
        }

        btn_more.click(toggle_content);

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
    });
}

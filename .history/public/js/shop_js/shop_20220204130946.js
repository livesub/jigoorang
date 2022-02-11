var option_add = false;
var supply_add = false;
var isAndroid = (navigator.userAgent.toLowerCase().indexOf("android") > -1);
var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

$(function() {
    // 선택옵션
    /* 가상커서 ctrl keyup 이베트 대응 */
    /*
    $(document).on("keyup", "select.it_option", function(e) {
        var sel_count = $("select.it_option").length;
        var idx = $("select.it_option").index($(this));
        var code = e.keyCode;
        var val = $(this).val();

        option_add = false;
        if(code == 17 && sel_count == idx + 1) {
            if(val == "")
                return;

            sel_option_process(true);
        }
    });
    */

    /* 키보드 접근 후 옵션 선택 Enter keydown 이벤트 대응 */
    $(document).on("keydown", "select.it_option", function(e) {
        var sel_count = $("select.it_option").length;
        var idx = $("select.it_option").index($(this));
        var code = e.keyCode;
        var val = $(this).val();

        option_add = false;
        if(code == 13 && sel_count == idx + 1) {
            if(val == "")
                return;

            sel_option_process(true);
        }
    });

    if(isAndroid) {
        $(document).on("touchend", "select.it_option", function() {
            option_add = true;
        });
    } else {
        var it_option_events = isSafari ? "mousedown" : "mouseup";

        $(document).on(it_option_events, "select.it_option", function(e) {
            option_add = true;
        });
    }

    $(document).on("change", "select.it_option", function() {
        var sel_count = $("select.it_option").length,
            idx = $("select.it_option").index($(this)),
            val = $(this).val(),
            item_code = $("input[name='item_code[]']").val(),
            post_url = $("#ajax_option_url").val(),
            $this = $(this),
            op_0_title = $this.find("option:eq(0)").text();

        // 선택값이 없을 경우 하위 옵션은 disabled
        if(val == "") {
            $("select.it_option:gt("+idx+")").val("").attr("disabled", true);
            return;
        }

        $this.trigger("select_it_option_change", [$this]);

        // 하위선택옵션로드
        if(sel_count > 1 && (idx + 1) < sel_count) {
            var opt_id = "";

            // 상위 옵션의 값을 읽어 옵션id 만듬
            if(idx > 0) {
                $("select.it_option:lt("+idx+")").each(function() {
                    if(!opt_id)
                        opt_id = $(this).val();
                    else
                        opt_id += chr(30)+$(this).val();
                });

                opt_id += chr(30)+val;
            } else if(idx == 0) {
                opt_id = val;
            }

            $.ajax({
                type: 'get',
                url: post_url,
                dataType: 'text',
                data: {
                    'item_code' : item_code,
                    'opt_id'    : opt_id,
                    'idx'       : idx,
                    'sel_count' : sel_count,
                    'op_title'  : op_0_title,
                },
                success: function(data) {
                    $("select.it_option").eq(idx+1).empty().html(data).attr("disabled", false);

                    // select의 옵션이 변경됐을 경우 하위 옵션 disabled
                    if(idx+1 < sel_count) {
                        var idx2 = idx + 1;
                        $("select.it_option:gt("+idx2+")").val("").attr("disabled", true);
                    }

                    $this.trigger("select_it_option_post", [$this, idx, sel_count, data]);
                },error: function(result) {
                    console.log(result);
                }
            });

        } else if((idx + 1) == sel_count) { // 선택옵션처리
            if(option_add && val == "")
                return;

            var info = val.split(",");
            // 재고체크
            if(parseInt(info[2]) < 1) {
                alert("선택하신 선택옵션상품은 재고가 부족하여 구매할 수 없습니다.");
                return false;
            }

//            if(option_add) sel_option_process(true);
            sel_option_process(true);
        }
    });

    // 추가옵션
    /* 가상커서 ctrl keyup 이베트 대응 */
    /*
    $(document).on("keyup", "select.it_supply", function(e) {
        var $el = $(this);
        var code = e.keyCode;
        var val = $(this).val();

        supply_add = false;
        if(code == 17) {
            if(val == "")
                return;

            sel_supply_process($el, true);
        }
    });
    */

    /* 키보드 접근 후 옵션 선택 Enter keydown 이벤트 대응 */
    $(document).on("keydown", "select.it_supply", function(e) {
        var $el = $(this);
        var code = e.keyCode;
        var val = $(this).val();

        supply_add = false;
        if(code == 13) {
            if(val == "")
                return;

            sel_supply_process($el, true);
        }
    });

    if(isAndroid) {
        $(document).on("touchend", "select.it_supply", function() {
            supply_add = true;
        });
    } else {
        var it_supply_events = isSafari ? "mousedown" : "mouseup";

        $(document).on(it_supply_events, "select.it_supply", function(e) {
            supply_add = true;
        });
    }

    $(document).on("change", "select.it_supply", function() {
        var $el = $(this);
        var val = $(this).val();

        if(val == "")
            return;
/*
        if(supply_add)
            sel_supply_process($el, true);
*/
        sel_supply_process($el, true);
    });

    // 수량변경 및 삭제
    //$(document).on("click", "#sit_sel_option li button", function() {
    $(document).on("click", "#sit_sel_option button", function() {
        var $this = $(this),
            mode = $this.text(),
            this_qty, max_qty = 9999, min_qty = 1,
            $el_qty = $(this).closest("div").find("input[name^=ct_qty]"),
            stock = parseInt($(this).closest("div").find("input.sio_stock").val());

         switch(mode) {
            case "+":
                this_qty = parseInt($el_qty.val().replace(/[^0-9]/, "")) + 1;

                if(this_qty > stock) {
                    alert("재고수량 보다 많은 수량을 구매할 수 없습니다.");
                    this_qty = stock;
                }

                if(this_qty > max_qty) {
                    this_qty = max_qty;
                    alert("최대 구매수량은 "+number_format(String(max_qty))+" 입니다.");
                }

                if(isNaN(this_qty)){
                    this_qty = 1;
                }

                $el_qty.val(this_qty);
                $this.trigger("sit_sel_option_success", [$this, mode, this_qty]);

                price_calculate();

                break;

            case "-":
                this_qty = parseInt($el_qty.val().replace(/[^0-9]/, "")) - 1;

                if(this_qty < min_qty) {
                    this_qty = min_qty;
                    alert("최소 구매수량은 "+number_format(String(min_qty))+" 입니다.");
                }

                if(isNaN(this_qty)){
                    this_qty = 1;
                }

                $el_qty.val(this_qty);
                $this.trigger("sit_sel_option_success", [$this, mode, this_qty]);
                price_calculate();
                break;

            case "X":
                if(confirm("선택하신 옵션항목을 삭제하시겠습니까?")) {
                    var $el = $(this).closest("div");
                    var del_exec = true;
                    if($("#sit_sel_option .sit_spl_list").length > 0) {
                        // 선택옵션이 하나이상인지
                        if($el.hasClass("sit_opt_list")) {
                            if($(".sit_opt_list").length <= 1)
                                del_exec = false;
                        }
                    }

                    if(del_exec) {
                        // 지우기전에 호출해야 trigger 를 호출해야 합니다.
                        $this.trigger("sit_sel_option_success", [$this, mode, ""]);
                        $el.closest("div").remove();
                        price_calculate();
                    } else {
                        alert("선택옵션은 하나이상이어야 합니다.");
                        return false;
                    }
                }
                break;

            default:
                alert("올바른 방법으로 이용해 주십시오.");
                break;
        }
    });

    // 수량직접입력
    $(document).on("keyup", "input[name^=ct_qty]", function() {
        var $this = $(this),
            val= $this.val(),
            force_val = 0;

            if(val != "") {
            if(val.replace(/[0-9]/g, "").length > 0) {
                alert("수량은 숫자만 입력해 주십시오.");
                force_val = 1;
                $(this).val(force_val);
            } else {
                var d_val = parseInt(val);
                if(d_val < 1 || d_val > 9999) {
                    alert("수량은 1에서 9999 사이의 값으로 입력해 주십시오.");
                    force_val = 1;
                    $(this).val(force_val);
                } else {
                    var stock = parseInt($(this).closest("div").find("input.sio_stock").val());

                    if(d_val > stock) {
                        alert("재고수량 보다 많은 수량을 구매할 수 없습니다.");
                        force_val = stock;
                        $(this).val(force_val);
                    }
                }
            }

            $this.trigger("change_option_qty", [$this, val, force_val]);

            price_calculate();
        }
    });
});



//디자인 변견 장바구니 스크립트 변경(220118)
function new_sel_option(num, click){
    var mode = click,el_qty,stock,this_qty, max_qty = 9999, min_qty = 1;

    el_qty = $('input[name="qty_ct_tmp['+num+']"]');
    stock = parseInt($('input[class="sio_stock['+num+']"]').val());

    switch(mode) {
        case "+":
            this_qty = parseInt(el_qty.val().replace(/[^0-9]/, "")) + 1;

            if(this_qty > stock) {
                alert("재고수량 보다 많은 수량을 구매할 수 없습니다.");
                this_qty = stock;
            }

            if(this_qty > max_qty) {
                this_qty = max_qty;
                alert("최대 구매수량은 "+number_format(String(max_qty))+" 입니다.");
            }

            if(isNaN(this_qty)){
                this_qty = 1;
            }

            el_qty.val(this_qty);
            //$this.trigger("sit_sel_option_success", [$this, mode, this_qty]);

            new_price_calculate(num);
        break;

        case "-":
            this_qty = parseInt(el_qty.val().replace(/[^0-9]/, "")) - 1;
            if(this_qty < min_qty) {
                this_qty = min_qty;
                alert("최소 구매수량은 "+number_format(String(min_qty))+" 입니다.");
            }

            if(isNaN(this_qty)){
                this_qty = 1;
            }

            el_qty.val(this_qty);
            //$this.trigger("sit_sel_option_success", [$this, mode, this_qty]);
            new_price_calculate(num);
        break;

        default:
            alert("올바른 방법으로 이용해 주십시오.");
        break;
    }
}

//수량직접입력 디자인 변견 장바구니 스크립트 변경(220118)
function new_ct_qty(num, sct_qty){
    var el_qty = $('input[name="qty_ct_tmp['+num+']"]');
    var stock = parseInt($('input[class="sio_stock['+num+']"]').val());

    if(el_qty.val() == ""){
        el_qty.val(1);
    }

    if(el_qty.val().replace(/[0-9]/g, "").length > 0) {
        el_qty.val(sct_qty);
    }else{
        var d_val = parseInt(el_qty.val());

        if(d_val > stock) {
            alert("재고수량 보다 많은 수량을 구매할 수 없습니다.");
            el_qty.val(stock);
        }
    }

    new_price_calculate(num);
}


// 선택옵션 추가처리
function sel_option_process(add_exec)
{
    var item_price = parseInt($("input#item_price").val());
    var id = "";
    var value, info, sel_opt, item, price, stock, run_error = false;
    var option = sep = "";
    info = $("select.it_option:last").val().split(",");

    $("select.it_option").each(function(index) {

        value = $(this).val();
        item = $(this).closest(".get_item_options").length ? $(this).closest(".get_item_options").find("label[for^=item_option]").text() : "";

        if( !item ){
            item = $(this).closest("tr").length ? $(this).closest("tr").find("th label").text() : "";
        }

        if(!value) {
            run_error = true;
            return false;
        }

        // 옵션선택정보
        sel_opt = value.split(",")[0];

        if(id == "") {
            id = sel_opt;
        } else {
            id += chr(30)+sel_opt;
            sep = " / ";
        }

        //option += sep + item + ":" + sel_opt;
        option += sep + item + sel_opt;
    });

    if(run_error) {
        alert(item+"을(를) 선택해 주십시오.");
        return false;
    }

    price = info[1];
    stock = info[2];

    // 금액 음수 체크
    if(item_price + parseInt(price) < 0) {
        alert("구매금액이 음수인 상품은 구매할 수 없습니다.");
        return false;
    }

    if(add_exec) {
        if(same_option_check(option))
            return;

        add_sel_option(0, id, option, price, stock);
    }
}

// 추가옵션 추가처리
function sel_supply_process($el, add_exec)
{
    if( $el.triggerHandler( 'shop_sel_supply_process',{add_exec:add_exec} ) !== false ){
        var val = $el.val();
        var item = $el.closest(".get_item_supply").length ? $el.closest(".get_item_supply").find("label[for^=it_supply]").text() : "";

        if( !item ){
            item = $el.closest("tr").length ? $el.closest("tr").find("th label").text() : "";
        }

        if(!val) {
            alert(item+"을(를) 선택해 주십시오.");
            return;
        }

        var info = val.split(",");

        // 재고체크
        if(parseInt(info[2]) < 1) {
            alert(info[0]+"은(는) 재고가 부족하여 구매할 수 없습니다.");
            return false;
        }

        var id = item+chr(30)+info[0];
        var option = item+":"+info[0];
        var price = info[1];
        var stock = info[2];

        // 금액 음수 체크
        if(parseInt(price) < 0) {
            alert("구매금액이 음수인 상품은 구매할 수 없습니다.");
            return false;
        }

        if(add_exec) {
            if(same_option_check(option))
                return;

            add_sel_option(1, id, option, price, stock);
        }
    }
}

// 선택된 옵션 출력
function add_sel_option(type, id, option, price, stock)
{
    var item_code = $("input[name='item_code[]']").val();
    var opt = "";
    var li_class = "sit_opt_list";
    if(type)
        li_class = "sit_spl_list";

    var opt_prc;
    if(parseInt(price) >= 0){
        //opt_prc = "(+"+number_format(String(price))+"원)";
        opt_prc = number_format(String(price))+"원";
    }else{
        //opt_prc = "("+number_format(String(price))+"원)";
        opt_prc = number_format(String(price))+"원)";
    }

    opt += "<div class='dt_pr_op "+li_class+"'>";
    opt += "<input type=\"hidden\" name=\"sio_type["+item_code+"][]\" value=\""+type+"\">";
    opt += "<input type=\"hidden\" name=\"sio_id["+item_code+"][]\" value=\""+id+"\">";
    opt += "<input type=\"hidden\" name=\"sio_value["+item_code+"][]\" value=\""+option+"\">";
    opt += "<input type=\"hidden\" class=\"sio_price\" value=\""+price+"\">";
    opt += "<input type=\"hidden\" class=\"sio_stock\" value=\""+stock+"\">";
    opt += "<ul class='dt_pr_op_tt'>";
    opt += "<li>"+option+"</li>";
    opt += "<li><button type=\"button\" class=\"sit_opt_del dt_del\"><span>X</span></button><li>";
    opt += "</ul>";

    opt += "<ul class=\"dt_pr_op_nm\">";
    opt += "<li>";
    opt += "<button type=\"button\">+</button>";
    opt += "<input type=\"text\" name=\"ct_qty["+item_code+"][]\" value=\"1\" size=\"5\" onKeyup=\"this.value=this.value.replace(/[^0-9]/g,'');\">";
    opt += "<button type=\"button\">-</button>";
    opt += "</li>";
    opt += "<li>"+opt_prc+"</li>";
    opt += "</ul>";
    opt += "</div>";

/*
    opt += "<li class=\""+li_class+"\">";
    opt += "<input type=\"hidden\" name=\"sio_type["+item_code+"][]\" value=\""+type+"\">";
    opt += "<input type=\"hidden\" name=\"sio_id["+item_code+"][]\" value=\""+id+"\">";
    opt += "<input type=\"hidden\" name=\"sio_value["+item_code+"][]\" value=\""+option+"\">";
    opt += "<input type=\"hidden\" class=\"sio_price\" value=\""+price+"\">";
    opt += "<input type=\"hidden\" class=\"sio_stock\" value=\""+stock+"\">";
    opt += "<span class=\"sit_opt_subj\">"+option+"옵션명</span>";
    opt += "<span class=\"sit_opt_prc\">"+opt_prc+"가격</span>";
    opt += "<div><input type=\"text\" name=\"ct_qty["+item_code+"][]\" value=\"1\" class=\"frm_input\" size=\"5\" onKeyup=\"this.value=this.value.replace(/[^0-9]/g,'');\">";
    opt += "<button type=\"button\" class=\"sit_qty_plus btn_frmline\">+</button>";
    opt += "<button type=\"button\" class=\"sit_qty_minus btn_frmline\">-</button>";
    opt += "<button type=\"button\" class=\"sit_opt_del btn_frmline\">삭제</button></div>";
    opt += "</li>";
*/

    if($("#sit_sel_option > ul").length < 1) {
        $("#sit_sel_option").html("<ul id=\"sit_opt_added\"></ul>");
        $("#sit_sel_option > ul").html(opt);
    } else{
        if(type) {
            if($("#sit_sel_option .sit_spl_list").length > 0) {
                $("#sit_sel_option .sit_spl_list:last").after(opt);
            } else {
                if($("#sit_sel_option .sit_opt_list").length > 0) {
                    $("#sit_sel_option .sit_opt_list:last").after(opt);
                } else {
                    $("#sit_sel_option > ul").html(opt);
                }
            }
        } else {
            if($("#sit_sel_option .sit_opt_list").length > 0) {
                $("#sit_sel_option .sit_opt_list:last").after(opt);
            } else {
                if($("#sit_sel_option .sit_spl_list").length > 0) {
                    $("#sit_sel_option .sit_spl_list:first").before(opt);
                } else {
                    $("#sit_sel_option > ul").html(opt);
                }
            }
        }
    }

    price_calculate();
//console.log(opt);
    $("#sit_sel_option").trigger("add_sit_sel_option", [opt]);
}

// 동일선택옵션있는지
function same_option_check(val)
{
    var result = false;
    $("input[name^=sio_value]").each(function() {
        if(val == $(this).val()) {
            result = true;
            return false;
        }
    });

    if(result)
        alert(val+" 은(는) 이미 추가하신 옵션상품입니다.");

    return result;
}

// 가격계산
function price_calculate()
{
    var item_price = parseInt($("input#item_price").val());

    if(isNaN(item_price))
        return;

    var $el_prc = $("input.sio_price");
    var $el_qty = $("input[name^=ct_qty]");
    var $el_type = $("input[name^=sio_type]");
    var price, type, qty, total = 0;

    $el_prc.each(function(index) {
        price = parseInt($(this).val());
        qty = parseInt($el_qty.eq(index).val());
        type = $el_type.eq(index).val();
        if(type == "0") { // 선택옵션
            total += (item_price + price) * qty;
        } else { // 추가옵션
            total += price * qty;
        }
    });

    $("#sit_tot_price").empty().html(number_format(String(total))+"원");

    $("#sit_tot_price").trigger("price_calculate", [total]);
}

//바뀐 장바구니 가격계산
function new_price_calculate(num)
{
    var item_price = parseInt($('input[id="item_price['+num+']"]').val());

    if(isNaN(item_price))
        return;

    var el_prc = $('input[id="sio_price['+num+']"]'); //옵션 추가 금액
    var el_qty = $('input[name="qty_ct_tmp['+num+']"]');  //수량
    var el_type = $('input[name="sio_type['+num+']"]');  //옵션타입:선택, 추가

    var price, type, qty, total = 0;

    total = (item_price + parseInt(el_prc.val())) * parseInt(el_qty.val());

    $("#sit_tot_price_"+num).html(number_format(String(total))+"원");
    $("#sit_tot_price_m_"+num).html(number_format(String(total))+"원");

    hap_price();
}

function hap_price(){
    var arr_cnt = $("#arr_cnt").val();
    //var arr_cnt = $("input[name^=ct_chk]:checked").length;
    var total = 0;
    var total_cust_price = 0;
    var principal = 0;
    var sc_price_total = 0;
    var hap_total = 0;
    var baesongbi = 0;
    var sale_price = 0;
    var de_send_cost = 0;    //기본 배송비
    var de_send_cost_free = 0;    //무료배송비 정책
    var chk_arr = $("input:checkbox[name^=ct_chk]");
    var check = $("input:checkbox[name^=ct_chk]:checked").length;

    for(var k = 0; k < arr_cnt; k++){
        if( chk_arr[k].checked == true ) {
            var cart_id = $('input[id="cart_id['+k+']"]').val(); //장바구니 순번
            var item_price = parseInt($('input[id="item_price['+k+']"]').val());
            var item_cust_price = parseInt($('input[id="item_cust_price['+k+']"]').val());
            var el_prc = $('input[id="sio_price['+k+']"]'); //옵션 추가 금액
            var el_qty = $('input[name="qty_ct_tmp['+k+']"]');  //수량
            var sc_price = $('input[id="item_sc_price['+k+']"]').val();  //각 상품 배송비

            ajax_cart_qty_modify(cart_id, el_qty); //수량 변경에 따른 DB 장바구니 수량 변경

            total += (item_price + parseInt(el_prc.val())) * parseInt(el_qty.val());
            sc_price_total += sc_price * el_qty.val();

            if(item_cust_price != 0) principal += item_price * parseInt(el_qty.val());  //추가 금액을 뺀 금액
            total_cust_price += (item_cust_price+300) * parseInt(el_qty.val());
        }
    }

    sale_price = total_cust_price - principal;

    if(check > 0){
        de_send_cost = $("#de_send_cost").val();    //기본 배송비
        de_send_cost_free = $("#de_send_cost_free").val();    //무료배송비 정책
    }

    //무료배송비 정책 보다 상품 금액이 크거나 같을때  무료 배송비 제외
    if(de_send_cost_free <= total){
        baesongbi = parseInt(sc_price_total);
    }else{
        baesongbi = parseInt(sc_price_total) + parseInt(de_send_cost);
    }

    hap_total = total + baesongbi;  //총 상품 금액 + 배송비 합

    $("#total_price").html(number_format(String(total))+"원");
    $("#total_cust_price").html(number_format(String(sale_price * -1))+"원");
    $("#hap_total").html(number_format(String(hap_total))+"원");
    $("#baesongbi").html(number_format(String(baesongbi))+"원");
}

// php chr() 대응
function chr(code)
{
    return String.fromCharCode(code);
}

function number_format(data)
{
    var tmp = '';
    var number = '';
    var cutlen = 3;
    var comma = ',';
    var i;

    data = data + '';

    var sign = data.match(/^[\+\-]/);
    if(sign) {
        data = data.replace(/^[\+\-]/, "");
    }

    len = data.length;
    mod = (len % cutlen);
    k = cutlen - mod;
    for (i=0; i<data.length; i++)
    {
        number = number + data.charAt(i);

        if (i < data.length - 1)
        {
            k++;
            if ((k % cutlen) == 0)
            {
                number = number + comma;
                k = 0;
            }
        }
    }

    if(sign != null)
        number = sign+number;

    return number;
}

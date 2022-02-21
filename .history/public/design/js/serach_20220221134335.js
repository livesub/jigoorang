//const searchForm = document.querySelector('#search-form');
const searchInput = document.querySelector('#search-input');
const searchList = document.querySelector('#search-list');
//const btn = document.querySelector('#serach_btn');
const SEARCH_KEY = "search";

let search = new Array();


function saveSearch() { //item을 localStorage에 저장
    typeof (Storage) !== 'undefined' && localStorage.setItem(SEARCH_KEY, JSON.stringify(search));
};

function deleteSearch(e) { //각각의 item을 삭제
    const li = e.target.parentElement;
    li.remove();
    search = search.filter((search) => search.id !== parseInt(li.id));
    saveSearch();
};



function deleteli() { //각각의 item을 삭제 (5개이상일때)
    const li = document.querySelector("li");
    li.remove();
    search = search.filter((search) => search.id !== parseInt(li.id));
    search.shift();
    //saveSearch();
};



function paintSearch(newSearch) { //화면에 뿌림
    const { id, text } = newSearch;
    const item = document.createElement("li");
    const span = document.createElement("span");
    const button = document.createElement("button");
    item.id = id;
    span.id = id;
    span.innerText = text;
    // button.innerText = 'x';
    button.classList.add("btn_list");
    button.addEventListener("click", deleteSearch);
    item.appendChild(span);
    item.appendChild(button);
    searchList.appendChild(item);
};


function handleSearchSubmit() {
    if($.trim($('input[name=search_w]').val()) == ""){
        alert("검색어를 입력해 주세요");
        $('input[name=search_w]').val("");
        $("#search-input").focus();
        return false;
    }else{
        $('input[name=search_w]').val($.trim($('input[name=search_w]').val()));
    }

    //event.preventDefault();
    const newSearchItem = searchInput.value;
    //searchInput.value = '';
    const newSearchObj = {
        id: Date.now(),
        text: newSearchItem
    };

    if (search.length > 4){
       deleteli();
       //alert("11");
       search.push(newSearchObj);
       paintSearch(newSearchObj);
       saveSearch();
    }else{
        //alert("12");
        search.push(newSearchObj);
        paintSearch(newSearchObj);
        saveSearch();
    }
};


//searchForm.addEventListener('submit', handleSearchSubmit);

const savedSearch = JSON.parse(localStorage.getItem(SEARCH_KEY));
if (savedSearch !== null) {
    search = savedSearch //전에 있던 items들을 계속 가지고 있기
    savedSearch.forEach(paintSearch);
   //console.log(search);
}



$(".search-inner ul li").click(function(){
    $('#search-input').val(localStorage.getItem("text"));
});


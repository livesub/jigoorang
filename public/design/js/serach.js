const searchForm = document.querySelector('#search-form');
const searchInput = searchForm.querySelector('input');
const searchList = document.querySelector('#search-list');
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

function paintSearch(newSearch) { //화면에 뿌림
    const { id, text } = newSearch;
    const item = document.createElement("li");
    const span = document.createElement("span");
    const button = document.createElement("button");
    item.id = id;
    span.innerText = text;
    // button.innerText = 'x';
    button.classList.add("btn_list");
    button.addEventListener("click", deleteSearch);
    item.appendChild(span);
    item.appendChild(button);
    searchList.appendChild(item);
};



function handleSearchSubmit(event) { //form 전송
    if (search.length > 4){
        // alert("5개만 가능해");
        console.log("search");
    }else{
        event.preventDefault();
        const newSearchItem = searchInput.value;
        searchInput.value = '';
        const newSearchObj = {
            id: Date.now(),
            text: newSearchItem
        };
        search.push(newSearchObj);
        paintSearch(newSearchObj);
        saveSearch();
    }

};



searchForm.addEventListener('submit', handleSearchSubmit);


const savedSearch = JSON.parse(localStorage.getItem(SEARCH_KEY));
if (savedSearch !== null) {
    Search = savedSearch //전에 있던 items들을 계속 가지고 있기
    savedSearch.forEach(paintSearch);
    console.log(Search);
}

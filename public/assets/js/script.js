let filter = document.getElementById("filter");
let tags = document.getElementById("tags");
let tagsChecks = document.querySelectorAll("#tags input");
let items = document.getElementById("items");
let searchInput = document.getElementById("search");

let searchEvent = null;
let tagsSelected = [];
let currentPage = 1;
let final = false;

function ShowItems(data){
    data.forEach(item => {
        items.innerHTML += `
        <a class="item" href="/items/${item.id}">
            <img src="${item.imagem.replace("public","storage")}"/>
            <p>${item.nome}</p>
        </a>
        `
    });
}

function ShowFirtsItems(){
    final = false
    items.innerHTML = '';
    search(searchInput.value, tagsSelected, 1).then(data => ShowItems(data));
    currentPage = 1;
}

tagsChecks.forEach(item => {
    item.addEventListener("change", e => {
        let value = parseInt(e.target.value)
        if(e.target.checked){
            tagsSelected.push(value);
        } else {
            tagsSelected = tagsSelected.filter(v => v !== value);
        }
        ShowFirtsItems();
    });
})

filter.addEventListener("click", () => {
    if(tags.classList.contains('show')){
        document.body.style = "padding-right: 0px;";
        tags.classList.remove('show');
        filter.classList.remove("clicked");
    } else {
        document.body.style = "padding-right: 300px;";
        tags.classList.add('show');
        filter.classList.add("clicked");
    }
});

searchInput.addEventListener("input", function () {
    clearTimeout(searchEvent);
    searchEvent = setTimeout(async () => {
        ShowFirtsItems();
    }, 200);
});

window.addEventListener('scroll', function() {
    if (!final && window.innerHeight + window.scrollY >= document.body.offsetHeight) {
        loadMoreItems();
    }
});


function loadMoreItems() {
    currentPage++;
    search(searchInput.value, tagsSelected, currentPage).then(data => {
        if(data.length > 0){
            ShowItems(data)
        } else {
            final = true;
        }
    });
}

search(searchInput.value, tagsSelected, 1).then(data => ShowItems(data));

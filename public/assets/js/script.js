let filter = document.getElementById("filter");
let tags = document.getElementById("tags");
let tagsChecks = document.querySelectorAll("#tags input");
let items = document.getElementById("items");
let searchInput = document.getElementById("search");

let searchEvent = null;
let tagsSelected = [];

function ShowItems(data){
    items.innerHTML = '';

    data.forEach(item => {
        items.innerHTML += `
        <div class="item">
            <img src="${item.imagem.replace("public","storage")}"/>
            <p>${item.nome}</p>
        </div>
        `
    });
}

tagsChecks.forEach(item => {
    item.addEventListener("change", e => {
        let value = parseInt(e.target.value)
        if(e.target.checked){
            tagsSelected.push(value);
        } else {
            tagsSelected = tagsSelected.filter(v => v !== value);
        }
        search(searchInput.value, tagsSelected).then(data => ShowItems(data));
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
        search(searchInput.value, tagsSelected).then(data => ShowItems(data));
    }, 200);
});

search(searchInput.value, tagsSelected).then(data => ShowItems(data));

let filter = document.getElementById("filter");
let tags = document.getElementById("tags");
let tagsChecks = document.querySelectorAll("#tags input");
let items = document.getElementById("items");
let searchInput = document.getElementById("search");

let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let searchEvent = null;
let tagsSelected = [];

function search(){
    fetch("/search", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            search: searchInput.value,
            tags: tagsSelected
         })
    })
    .then(response => response.json())
    .then(data => {
        items.innerHTML = '';

        data.forEach(item => {
            items.innerHTML += `
            <div class="item">
                <img src="${item.imagem.replace("public","storage")}"/>
                <p>${item.nome}</p>
            </div>
            `
        });
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro de conexão com o servidor');
    })
}

tagsChecks.forEach(item => {
    item.addEventListener("change", e => {
        let value = parseInt(e.target.value)
        if(e.target.checked){
            tagsSelected.push(value);
        } else {
            tagsSelected = tagsSelected.filter(v => v !== value);
        }
        search();
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
    searchEvent = setTimeout(() => {
        search();
    }, 500);
});

search();

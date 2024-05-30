const searchInput = document.getElementById('searchModal');
const modal = document.getElementById('modal');
const modalView = document.getElementById('addItem');
const items = document.getElementById('itemsModal');
const add = document.getElementById('add');
const destroy = document.getElementById('delete');
const childItems = document.getElementsByClassName('childItem');

const tagsInput = document.getElementById('tagsInput');

const id = parseInt(window.location.pathname.split('/').pop());
let exclude = [id, ...Array.from(childItems).map(e => parseInt(e.getAttribute('iditem'))).slice(0, -1)]

let searchEvent = null;
let currentPage = 1;
let final = false;

tagify = new Tagify(tagsInput);

function ShowItems(data){
    data.forEach(item => {
        items.innerHTML += `
        <div class="itemsModal" iditem="${item.id}">
            <img src="../${item.imagem.replace("public","storage")}"/>
            <p>${item.nome}</p>
        </div>
        `;

        const DOMitems = document.querySelectorAll(".itemsModal");

        DOMitems.forEach(item => {
            item.addEventListener("click", () => {
                fetch(`/items/${item.getAttribute("iditem")}/updatelocal`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        fk_item: id,
                     })
                })
                .then(response => {
                    location.reload()
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erro ao adicionar filho');
                })
            })
        });
    });
}

function ShowFirtsItems(){
    final = false;
    items.innerHTML = '';
    currentPage = 1;
    search(searchInput.value, [] , 1, exclude).then(data => ShowItems(data));
}

function loadMoreItems() {
    currentPage++;
    search(searchInput.value, [], currentPage, exclude).then(data => {
        if(data.length > 0){
            ShowItems(data)
        } else {
            final = true;
        }
    });
}

searchInput.addEventListener("input", function () {
    clearTimeout(searchEvent);
    searchEvent = setTimeout(async () => {
        ShowFirtsItems();
    }, 200);
});

add.addEventListener("click", function () {
    modal.style.display = "flex";
    ShowFirtsItems();
});

modalView.addEventListener("click", function (event) {
    event.stopPropagation();
});

modal.addEventListener("click", function () {
    modal.style.display = "none";
});

destroy.addEventListener("click", function (event) {
    if(!confirm("Certeza que você quer deletar esse item ?")){
        event.preventDefault();
    }
})

items.addEventListener('scroll', function() {
    if (!final && items.scrollHeight - items.scrollTop === items.clientHeight) {
        loadMoreItems();
    }
});

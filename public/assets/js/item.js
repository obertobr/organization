const searchInput = document.getElementById('searchModal');
const modal = document.getElementById('modal');
const modalView = document.getElementById('addItem');
const items = document.getElementById('itemsModal');
const add = document.getElementById('add');
const destroy = document.getElementById('delete');

const tagsInput = document.getElementById('tagsInput');

let searchEvent = null;

tagify = new Tagify(tagsInput);

function ShowItems(data){
    items.innerHTML = '';

    data.forEach(item => {
        items.innerHTML += `
        <div class="itemsModal" iditem="${item.id}">
            <img src="../${item.imagem.replace("public","storage")}"/>
            <p>${item.nome}</p>
        </div>
        `;

        const DOMitems = document.querySelectorAll(".itemsModal");

        DOMitems.forEach(item => {
            const pathname = window.location.pathname;
            const id = pathname.split('/').pop();
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

searchInput.addEventListener("input", function () {
    clearTimeout(searchEvent);
    searchEvent = setTimeout(async () => {
        search(searchInput.value, []).then(data => ShowItems(data));
    }, 200);
});

add.addEventListener("click", function () {
    modal.style.display = "flex";
    search(searchInput.value, []).then(data => ShowItems(data));
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

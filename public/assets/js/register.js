const uploadArea = document.getElementById('upload-area');
const fileInput = document.getElementById('file-input');
const imagePreview = document.getElementById('image-preview');
const previewImage = document.getElementById('preview-image');
const removeButton = document.getElementById('remove-button');
const uploadText = document.getElementById('upload-text');
const searchInput = document.getElementById('searchModal');
const modal = document.getElementById('modal');
const modalView = document.getElementById('addItem');
const items = document.getElementById('itemsModal');
const local = document.getElementById('local');
const localRemove = document.getElementById('localRemove');
const fk_item = document.getElementById('fk_item');
const tagsInput = document.getElementById('tagsInput');

let used = false;
let searchEvent = null;
let currentPage = 1;
let final = false;

getTags().then(response => {
    tagify = new Tagify(tagsInput, {
        whitelist: response.map(item => item.nome),
        dropdown: {
            maxItems: 7,
            classname: 'tags-look',
            position: 'text',
            enabled: 1,
        }
    })
})

function ShowItems(data){
    data.forEach(item => {
        items.innerHTML += `
        <div class="itemsModal" iditem="${item.id}">
            <img src="./${item.imagem.replace("public","storage")}"/>
            <p>${item.nome}</p>
        </div>
        `;

        const DOMitems = document.querySelectorAll(".itemsModal");

        DOMitems.forEach(item => {
            item.addEventListener("click", () => {
                const localName = document.getElementById('localName');
                const localImg = document.getElementById('localImg');


                localName.innerText = item.getElementsByTagName("p")[0].innerText;
                localImg.src = item.getElementsByTagName("img")[0].src;

                local.classList.add("selected");

                fk_item.value = item.getAttribute("iditem");
                modal.style.display = "none";
            })
        });
    });
}

function ShowFirtsItems(){
    final = false;
    items.innerHTML = '';
    currentPage = 1;
    search(searchInput.value, [] , 1).then(data => ShowItems(data));
}

function loadMoreItems() {
    currentPage++;
    search(searchInput.value, [], currentPage).then(data => {
        if(data.length > 0){
            ShowItems(data)
        } else {
            final = true;
        }
    });
}

uploadArea.addEventListener('click', () => !used && fileInput.click());

uploadArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    uploadArea.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('dragover');
});

uploadArea.addEventListener('drop', (event) => {
    event.preventDefault();
    uploadArea.classList.remove('dragover');
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        handleFiles(files);
    }
});

fileInput.addEventListener('change', () => {
    const files = fileInput.files;
    handleFiles(files);
});

removeButton.addEventListener('click', (event) => {
    event.stopPropagation();
    fileInput.value = '';
    previewImage.src = '';
    imagePreview.style.display = "none"
    removeButton.hidden = true;
    uploadText.hidden = false;
    uploadArea.classList.remove('used');
    used = false;
});

function handleFiles(files) {
    const file = files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            imagePreview.style.display = "block"
            removeButton.hidden = false;
            uploadText.hidden = true;
            uploadArea.classList.add('used');
            used = true;
        };
        reader.readAsDataURL(file);
    } else {
        alert('Please upload an image file.');
    }
}

searchInput.addEventListener("input", function () {
    clearTimeout(searchEvent);
    searchEvent = setTimeout(async () => {
        ShowFirtsItems();
    }, 200);
});

local.addEventListener("click", function () {
    modal.style.display = "flex";
    ShowFirtsItems();
});

modalView.addEventListener("click", function (event) {
    event.stopPropagation();
});

modal.addEventListener("click", function () {
    modal.style.display = "none";
});

localRemove.addEventListener("click", function (event) {
    event.stopPropagation();
    local.classList.remove("selected");
    fk_item.value = "";
});

items.addEventListener('scroll', function() {
    if (!final && items.scrollHeight - items.scrollTop === items.clientHeight) {
        loadMoreItems();
    }
});

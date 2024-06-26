window.onload = function() {
    var baseTag = document.createElement('base');
    baseTag.setAttribute('href', window.location.origin + '/');
    document.head.appendChild(baseTag);
};

let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

async function search(string, tags, page, exclude=""){
    return await fetch("/organization/search", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            search: string,
            tags: tags,
            page: page,
            exclude: exclude
         })
    })
    .then(response => response.json())
    .catch(error => {
        console.error('Error:', error);
        alert('Erro de conexão com o servidor');
    })
}

async function getTags(){
    return await fetch("/organization/tags")
    .then(response => response.json())
    .catch(error => {
        console.error('Error:', error);
        alert('Erro de conexão com o servidor');
    })
}

function adjustTextareaHeight(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

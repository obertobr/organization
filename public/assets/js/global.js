let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

async function search(string, tags){
    return await fetch("/search", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            search: string,
            tags: tags
         })
    })
    .then(response => response.json())
    .catch(error => {
        console.error('Error:', error);
        alert('Erro de conexão com o servidor');
    })
}

async function getTags(){
    return await fetch("/tags")
    .then(response => response.json())
    .catch(error => {
        console.error('Error:', error);
        alert('Erro de conexão com o servidor');
    })
}

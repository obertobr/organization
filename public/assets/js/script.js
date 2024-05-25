filter = document.getElementById("filter");
tags = document.getElementById("tags");

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

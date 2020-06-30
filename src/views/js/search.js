let inputsSearchEl = document.querySelectorAll(".input-search");

inputsSearchEl.forEach(($element, $key) => {
    $element.addEventListener('focus', () => {
        document.addEventListener('keyup', (e) => {
            if(e.keyCode == 13){
                let keyword = $element.value.trim();
                if(keyword !== "")
                    window.location = "http://localhost/phpseminario/src?page=search&q="+keyword;
            }
        })
    })
})
document.getElementById('pesquisa-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Impede o envio do formulário

    var form = this;
    var url = new URL(window.location.href);
    var pesquisa = form.elements.pesquisa.value;
    // reset pagina
    url.searchParams.set('pagina', '1');

    if (pesquisa) {
        url.searchParams.set('pesquisa', pesquisa);
    } else {
        url.searchParams.delete('pesquisa');
    }

    window.location.href = url.href;
});

function updateQuery (){
    let query = window.location.search;  // parametros url
    let parametros = new URLSearchParams(query);
    parametros.delete('ordenar');  // se ja existir delete
    parametros.append('ordenar', document.getElementById("ordenar").value); // adicionar ordenação
    document.location.href = "?" + parametros.toString(); // refresh
}
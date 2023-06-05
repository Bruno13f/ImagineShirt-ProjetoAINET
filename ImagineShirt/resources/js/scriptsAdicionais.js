function updateQuery (){
    let query = window.location.search;  // parametros url
    let parametros = new URLSearchParams(query);
    parametros.delete('ordenar');  // se ja existir delete
    parametros.append('ordenar', document.getElementById("ordenar").value); // adicionar ordenação
    document.location.href = "?" + parametros.toString(); // refresh
}
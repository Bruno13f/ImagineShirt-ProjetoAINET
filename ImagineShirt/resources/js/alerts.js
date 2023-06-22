
const deleteUserForm = document.querySelectorAll("#form_delete_photo");
if (deleteUserForm) {
    deleteUserForm.forEach(function (deleteForm) {
        deleteForm.addEventListener("submit", function (event) {

            event.preventDefault();

            Swal.fire({
            title: 'Tem a certeza?',
            text: "Irá eliminar a foto do seu perfil!",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, quero eliminar!',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    event.target.submit();
                }
            })
        });
    });
}

const deleteTShirtForm = document.querySelectorAll("#form_delete_tshirt");
if (deleteTShirtForm) {
    deleteTShirtForm.forEach(function (deleteForm) {
        deleteForm.addEventListener("submit", function (event) {

            event.preventDefault();

            Swal.fire({
            title: 'Tem a certeza?',
            text: "Irá eliminar a tshirt!",
            showCancelButton: true,
            confirmButtonColor: '#218838',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, quero eliminar!',
            cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    event.target.submit();
                }
            })
        });
    });
}
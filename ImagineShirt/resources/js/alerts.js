
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

const deleteAdminUserForms = document.querySelectorAll("[id^='form_delete_user_']");
if (deleteAdminUserForms) {
    deleteAdminUserForms.forEach(function (deleteForm) {
        deleteForm.addEventListener("submit", function (event) {

            event.preventDefault();

            Swal.fire({
            title: 'Tem a certeza?',
            text: "Irá eliminar o user!",
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

const deleteAdminCategoryForms = document.querySelectorAll("[id^='form_delete_category_']");
if (deleteAdminCategoryForms) {
    deleteAdminCategoryForms.forEach(function (deleteForm) {
        deleteForm.addEventListener("submit", function (event) {

            event.preventDefault();

            Swal.fire({
            title: 'Tem a certeza?',
            text: "Irá eliminar a categoria!",
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

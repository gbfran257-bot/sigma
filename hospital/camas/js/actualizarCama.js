const actualizarCama = (e) => {
    e.preventDefault();
    const body = new FormData(document.getElementById("form-escuela"));
    fetch("hospital/camas/files-serverside/actualizarCama.php", {
        method: "POST",
        body,
    })
        .then(response => response.json())
        .then(response => {
            if (response.error) {
                throw new Error(response.error);
            }
            $("#myModal").modal("hide");
            $("#dataTablePrincipal").DataTable().ajax.reload();
            swal({
                type: "success",
                title: "¡HECHO!",
                text: response.success,
                showConfirmButton: false,
                timer: 2000,
            });
        })
        .catch(error => console.error(error));
};

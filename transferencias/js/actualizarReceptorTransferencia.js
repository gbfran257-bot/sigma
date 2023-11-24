const actualizarReceptorTransferencia = async (folio, usuario) => {
    const body = new FormData();
    body.append("f", folio);
    body.append("u", usuario);
    return await fetch("transferencias/files-serverside/actualizar_receptor_transferencia.php", { method: "POST", body, })
        .then((response) => response.json())
        .then((response) => {
            if (response.error) {
                throw new Error(response.error);
            }
            return response.success;
        })
        .catch((error) => console.error(error));
};

const getDatosTranferencia = async (referencia) => {
    return await fetch(
        "transferencias/files-serverside/resumen_transferencias.php?referencia=" +
            referencia
    )
        .then(response => response.json())
        .catch((error) => console.error(error));
};

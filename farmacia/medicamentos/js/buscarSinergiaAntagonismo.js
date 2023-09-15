/**
 * Filtra los medicamentos en el select de sinergias
 * @param { string } complemento
 * @param { string } sinergia
 */
const buscarSinergiaAntagonismo = (complemento, valor) => {
    if (valor === "") {
        return $(`.${complemento}`).show();
    }

    // Ocultamos los elementos que no coinciden y mostramos los que si
    $(`.${complemento}`).each((index, element) =>
        element.textContent.includes(valor.toUpperCase())
            ? $(element).show()
            : $(element).hide()
    );
};

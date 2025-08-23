export const formatearElementoPorID = idElemento => {

    let elemento = document.getElementById(idElemento);

    new AutoNumeric(elemento, {
        decimalCharacter : ',',
        digitGroupSeparator : '.',
        emptyInputBehavior: 0,
        modifyValueOnWheel: false,
        decimalPlaces: 2
    });

    return elemento;

}

export const activarLoadBtn = (idBtn) => {

    const boton = document.getElementById( idBtn );

    boton.setAttribute('data-kt-indicator', 'on');
    boton.setAttribute('disabled', 'disabled');

}

export const desactivarLoadBtn = (idBtn) => {

    const boton = document.getElementById( idBtn );

    boton.removeAttribute('data-kt-indicator');
    boton.removeAttribute('disabled');

}

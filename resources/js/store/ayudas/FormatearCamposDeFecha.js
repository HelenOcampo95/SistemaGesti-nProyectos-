export const formatearCampoDeFechaPorID = (idElemento, fechasAnteriores = true) => {

    const nowDate = new Date();
    let maxLimitDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate()+60, 0, 0, 0, 0)

    $( idElemento ).daterangepicker({
        singleDatePicker: true,
        minYear: 1901,
        maxYear: parseInt(moment().format("YYYY"),12),
        maxDate: maxLimitDate,
        locale: {
            format: "YYYY/MM/DD",
            "separator": " - ",
            "applyLabel": "Seleccionar fecha",
            "cancelLabel": "Cerrar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Personalizar",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1,
        },
        autoApply: true
    });

}

export const fechaAutoSelecionableSinFechaMinima = ( idElemento ) => {

    $( idElemento ).daterangepicker({
        singleDatePicker: true,
        minYear: 1901,
        // minDate: today,
        maxYear: parseInt(moment().format("YYYY"),12),
        // maxDate: maxLimitDate,
        locale: {
            format: "YYYY/MM/DD",
            "separator": " - ",
            "applyLabel": "Seleccionar fecha",
            "cancelLabel": "Cerrar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Personalizar",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1,
        },
        autoApply: true
    });

}

export const fechaAutoSeleccionableConFechaMinimaHoy = ( idElemento ) => {

    const fechaActual = new Date();

    const yyyy = fechaActual.getFullYear();
    const mm = String(fechaActual.getMonth() + 1).padStart(2, '0');
    const dd = String(fechaActual.getDate()).padStart(2, '0');

    $( idElemento ).daterangepicker({
        singleDatePicker: true,
        // showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format("YYYY"),12),
        minDate: fechaActual,
        autoApply:true,
        locale: {
            format: "YYYY/MM/DD",
            "separator": " - ",
            "applyLabel": "Seleccionar fecha",
            "cancelLabel": "Cerrar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Personalizar",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        }
    });

}

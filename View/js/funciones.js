    //función que recibe una fecha en formato datetime y devuelve una cadena con la fecha en formato dd-mm-yyyy
    function formateaFecha(fecha) {
        var d = new Date(fecha);
        var month = '' + (d.getMonth() + 1);
        var day = '' + d.getDate();
        var year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [day, month, year].join('-');
    }
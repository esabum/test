
/*
 jQuery('#tbxFecha').datetimepicker({
 autoclose: true,
 language: "es",
 format: {
 toDisplay: function (date, format, language) {
 var d = new Date(date);
 d.setDate(d.getDate() - 7);
 return "hola mundo";//d.toISOString();
 },
 toValue: function (date, format, language) {
 var d = new Date(date);
 d.setDate(d.getDate() + 7);
 return new Date(d);
 }
 }
 });
 */
jQuery(document).on('change', '#dwnCondiVenta', function () {
    var value = jQuery(this).val();
    if (value == "02") {
        jQuery("#tbxPlazo").removeAttr("disabled");
    } else {
        jQuery("#tbxPlazo").attr("disabled", "true");
        jQuery("#tbxPlazo").val("");
    }
});
jQuery(document).on('change', '#dwnMoneda', function () {
    var value = jQuery(this).val();
    if (value == "CRC") {
        jQuery("#tbxTipoCambio").val("1.00000");
        jQuery("#tbxTipoCambio").attr("disabled", "true");
    } else {
        jQuery("#tbxTipoCambio").removeAttr("disabled");
    }

});

jQuery(document).on('click', '#btnSendEmail', function () {
    location.reload(true);
});

jQuery(document).on('click', '#btnDescargarComprobante', function () {
    openInNewTab("//"+window.location.hostname+"/files/"+jQuery("#modalImprime").data("clave")+".pdf");
    location.reload(true);
});

jQuery(document).on('click', '#btnCloseModalImp', function () {
    location.reload(true);
});

function openInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
}

$('#tblDetalleProd').SetEditable({
    columnsEd: "0,2,3,4,5",
    onEdit: function () {
        sumarTotales();


    }, //Called after edition
    onDelete: function () {
        sumarTotales();
    }
});

function sumarTotales() {
    jQuery(".totales").val("0.00000");
    var impuesto = 0;
    var desctotal = 0;
    jQuery("#tblDetalleProd .colDescuento").each(function () {
        desctotal = desctotal + parseFloat((jQuery(this).text() != "") ? jQuery(this).text() : "0.0");
    });
    jQuery("#tbxtotal_descuentos").val(convertToPounds((desctotal) ? desctotal : "0.0", 5));

    var coltotalServExcento = 0;
    var coltotalMercExenta = 0;
    jQuery("#tblDetalleProd .colTotal").each(function () {
        if (jQuery(this).hasClass("serv_prof")) {
            coltotalServExcento = coltotalServExcento + parseFloat(jQuery(this).text())
        } else {
            coltotalMercExenta = coltotalMercExenta + parseFloat(jQuery(this).text());
        }
        //coltotal = coltotal + parseInt(jQuery(this).text());
    });
    jQuery("#tbxtotal_serv_exentos").val(convertToPounds(coltotalServExcento, 5));
    jQuery("#tbxtotal_merc_exenta").val(convertToPounds(coltotalMercExenta, 5));

    jQuery("#tbxtotal_exentos").val(convertToPounds(coltotalMercExenta + coltotalServExcento, 5));
    jQuery("#tbxtotal_ventas").val(convertToPounds(coltotalMercExenta + coltotalServExcento, 5));

    jQuery("#tbxtotal_impuestos").val(convertToPounds(impuesto, 5));
    var totVentaNeta = (coltotalMercExenta + coltotalServExcento) - desctotal;
    jQuery("#tbxtotal_ventas_neta").val(convertToPounds(totVentaNeta, 5));
    jQuery("#tbxtotal_comprobante").val(convertToPounds((totVentaNeta + impuesto), 5));


}

function validaUnid(val) {
    var textBox = jQuery(val);
    var text = jQuery(textBox).val();
    //console.log(text);       
    if (!isNaN(text)) {

    } else {
        jQuery(val).val("");
    }
}

function validaPunto(elemento, evt, enteros, decimales) {

    var value = jQuery(elemento).val();
    //console.log(value);
    var pexp3 = "^\\d{1," + enteros + "}\\.\\d{0," + decimales + "}$";
    var exp3 = new RegExp(pexp3);



    var nav4 = window.Event ? true : false;
    var key = nav4 ? evt.which : evt.keyCode;
    if (exp3.test(value) && key == 46) {
        return false;
    }
    return (key <= 13 || (key >= 48 && key <= 57) || key == 46);
}

function SoloNumerosPunto(elemento, enteros, decimales) {
    //console.log(elemento);

    var value = jQuery(elemento).val();
    //console.log(value);
    var pexp1 = "^\\d{1," + enteros + "}$";
    var pexp2 = "^\\d{1," + enteros + "}\\.$";
    var pexp3 = "^\\d{1," + enteros + "}\\.\\d{0," + decimales + "}$";

    var exp1 = new RegExp(pexp1);
    var exp2 = new RegExp(pexp2);
    var exp3 = new RegExp(pexp3);
    if (!exp1.test(value) && !exp2.test(value) && !exp3.test(value)) {
        //console.log("tecla valida");
        jQuery(elemento).val(value.slice(0, -1));
    }

}

function ValidaFormatoNumero(element, enteros, decimales) {

    var value = jQuery(element).val();
    if (value == "") {
        jQuery(element).val(convertToPounds("1.", decimales));
    } else {
        var pexp1 = "^\\d{1," + enteros + "}$";
        var pexp2 = "^\\d{1," + enteros + "}\\.$";
        var pexp3 = "^\\d{1," + enteros + "}\\.\\d{0," + decimales + "}$";

        var exp1 = new RegExp(pexp1);
        var exp2 = new RegExp(pexp2);
        var exp3 = new RegExp(pexp3);

        if (exp1.test(value)) {
            jQuery(element).val(convertToPounds(value, decimales));
        }
        if (exp2.test(value)) {
            jQuery(element).val(convertToPounds(value, decimales));
        }
        if (exp3.test(value)) {
            jQuery(element).val(convertToPounds(value, decimales));
        }
    }
}

function convertToPounds(str, decimales) {
    str = (str == 0) ? "0" : str;
    var n = Number.parseFloat(str);
    if (!str || isNaN(n) || n < 0)
        return 0;
    return n.toFixed(decimales);
}

function  addNewRow() {
    var filaEdit = jQuery("#filaEditable").clone();
    //filaEdit.append(colEdicHtml);
    jQuery('#tblDetalleProd').find('tbody').append(filaEdit);
}
jQuery(document).on('click', '#btnconsultarFac', function () {
    var numFac = jQuery('#tbxNoFac').val();
    //C:\xampp\htdocs\admintool\factura\controller\consultarFactura.php
    jQuery.ajax({
        url: '/factura/controller/consultarFactura.php',
        type: 'POST',
        data: {
            numero: numFac,
            emisor_id: jQuery('#UserId').val()
        },
        success: function (data) {
            jQuery('#tbxNoFac').html(data);
            //console.log(data);
        }
    });


});
jQuery(document).on('click', '#btnSaveFactura', function () {
    var valueCondiVenta = jQuery("#dwnCondiVenta").val();
    var plazo_credito = jQuery('#tbxPlazo').val();
    if (valueCondiVenta == "02" && plazo_credito == "") {
        showNoty("warning", "Favor indicar el plazo de pago");
    } else {
        if (jQuery('#tbxtotal_comprobante').val() == "0.00000") {
            showNoty("warning", "Favor indicar la línea del producto o servicio");
        } else {
            var arrayDetalles = new Array();
            var count = 1;
            jQuery("#tblDetalleProd tbody tr").each(function () {
                if (jQuery(jQuery(this).find("td")[0]).html() != "") {
                    arrayDetalles.push(
                            {
                                cantidad: jQuery(jQuery(this).find("td")[0]).html(),
                                unidadMedida: jQuery(jQuery(jQuery(this).find("td")[1]).find("select")).val(),
                                detalle: jQuery(jQuery(this).find("td")[2]).html(),
                                precioUnitario: jQuery(jQuery(this).find("td")[3]).html(),
                                montoTotal: jQuery(jQuery(this).find("td")[7]).html(),
                                subtotal: jQuery(jQuery(this).find("td")[6]).html(),
                                montoTotalLinea: jQuery(jQuery(this).find("td")[6]).html(),
                                montoDescuento: (jQuery(jQuery(this).find("td")[4]).html() == "0.00000") ? "" : jQuery(jQuery(this).find("td")[4]).html(),
                                naturalezaDescuento: jQuery(jQuery(this).find("td")[5]).html(),
                                impuesto: {}
                            });
                    count++;
                }
                // console.log(jQuery(jQuery(this).find("td")[1]).html());
            });
            //console.log(JSON.stringify(arrayDetalles ));

            jQuery.ajax({
                url: '/factura/controller/sendFactura.php',
                type: 'POST',
                data: {
                    factura: {
                        clave: jQuery('#claveFA').val(),
                        consecutivo: jQuery('#tbxConsecutivo').val(),
                        emisor_id: jQuery('#UserId').val(),
                        dwnCliente: jQuery('#dwnCliente').val(),
                        tbxFecha: jQuery('#tbxFecha').val(),
                        condicion_venta: jQuery('#dwnCondiVenta').val(),
                        plazo_credito: jQuery('#tbxPlazo').val(),
                        medio_pago: jQuery('#dwnMedioPago').val(),
                        cod_moneda: jQuery('#dwnMoneda').val(),
                        tipo_cambio: jQuery('#tbxTipoCambio').val(),
                        total_serv_exentos: jQuery('#tbxtotal_serv_exentos').val(),
                        total_serv_gravados: jQuery('#tbxtotal_serv_gravados').val(),
                        total_merc_exenta: jQuery('#tbxtotal_merc_exenta').val(),
                        total_merc_gravada: jQuery('#tbxtotal_merc_gravada').val(),
                        total_exentos: jQuery('#tbxtotal_exentos').val(),
                        total_gravados: jQuery('#tbxtotal_gravados').val(),
                        total_ventas: jQuery('#tbxtotal_ventas').val(),
                        total_descuentos: jQuery('#tbxtotal_descuentos').val(),
                        total_ventas_neta: jQuery('#tbxtotal_ventas_neta').val(),
                        total_impuestos: jQuery('#tbxtotal_impuestos').val(),
                        total_comprobante: jQuery('#tbxtotal_comprobante').val(),
                        otros: jQuery('#tbxotros').val(),
                        detalles: JSON.stringify(arrayDetalles)
                    }
                },
                success: function (data) {
                    if (data != "0") {
                        jQuery("#modalImprime").data("clave",data);
                        jQuery("#modalImprime").modal("show");
                    } else {
                        showNoty("error","Error al enviar factura a Hacienda");
                    }
                }
            });
        }
    }
});
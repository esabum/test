var tableReceptores = null;
var userId = jQuery('#UserId').val();

var tableReceptores = jQuery('#tblReceptores').dataTable({
    ajax: {
        url: "/clientes/controller/getReceptores.php",
        type: "post",
        data:{
            user_id: userId
        }
    },
    columns: [
        {data: 'nombre'},
        {data: 'identificacion'},
        {data: 'telefono'},
        {data: 'correo'},
        {data: 'editBtn'}               
    ]/*,
    sDom: 'W<"clear">lfrtip',
    aoColumnDefs: [{
            targets: [5],
            visible: false,
            searchable: true
        }],
    oColumnFilterWidgets: {
        aiExclude: [0, 1, 2, 3, 4]
    }/*,
     "drawCallback": function (data) {
     jQuery('#tableTags_length').append(jQuery("#tableTags_wrapper").find(".widget-5"));
     jQuery('#tableTags_length').append(jQuery('#tableTags_filter'));
     }*/
});

function editReceptor(id){
    console.log(id);
}

jQuery(document).on('change', '#dwnProvinc', function () {
    jQuery('#dwnDistritos').html("<option value='0'>&nbsp;</option>");
    jQuery('#dwnCantones').html("<option value='0'>&nbsp;</option>");
    jQuery('#dwnBarrios').html("<option value='0'>&nbsp;</option>");
    var idProvincia = jQuery('#dwnProvinc').val()
    if (idProvincia != 0) {
        jQuery.ajax({
            url: '/config/certificados/controller/getCantones.php',
            type: 'POST',
            data: {
                idProvincia: idProvincia
            },
            success: function (data) {
                jQuery('#dwnCantones').html(data);
            }
        });
    }
});

jQuery(document).on('change', '#dwnCantones', function () {
    jQuery('#dwnDistritos').html("<option value='0'>&nbsp;</option>");
    jQuery('#dwnBarrios').html("<option value='0'>&nbsp;</option>");
    var idProvincia = jQuery('#dwnProvinc').val();
    var idCanton = jQuery('#dwnCantones').val();
    if (idCanton != 0) {
        jQuery.ajax({
            url: '/config/certificados/controller/getDistritos.php',
            type: 'POST',
            data: {
                idProvincia: idProvincia,
                idCanton: idCanton
            },
            success: function (data) {
                jQuery('#dwnDistritos').html(data);
            }
        });
    }
});

jQuery(document).on('change', '#dwnDistritos', function () {
    jQuery('#dwnBarrios').html("<option value='0'>&nbsp;</option>");
    var idProvincia = jQuery('#dwnProvinc').val();
    var idCanton = jQuery('#dwnCantones').val();
    var idDistrito = jQuery('#dwnDistritos').val();
    if (idDistrito != 0) {
        jQuery.ajax({
            url: '/config/certificados/controller/getBarrios.php',
            type: 'POST',
            data: {
                idProvincia: idProvincia,
                idCanton: idCanton,
                idDistrito: idDistrito
            },
            success: function (data) {
                jQuery('#dwnBarrios').html(data);
            }
        });
    }

});

jQuery(document).on('click', '#btnNewReceptor', function () {
    getFormReceptor();
});



jQuery(document).on('click', '#btnSaveReceptor', function () {
    sendReceptor();
});

function getFormReceptor() {
    jQuery.ajax({
        url: '/clientes/controller/getFormReceptor.php',
        type: 'POST',
        data: {
            UserH: 0
        },
        success: function (data) {
            jQuery('#modalForm').html(data);
            jQuery('#modalCliente').modal("show");
        }
    });
}
function sendReceptor() {

    var tbxNombre = jQuery('#tbxNombre').val();
    var tbxNomComercial = jQuery('#tbxNomComercial').val();
    var tbxRazonSocial = jQuery('#tbxRazonSocial').val();
    var tbxIdenTributaria = jQuery('#tbxIdenTributaria').val();
    var dwnTipoIden = jQuery('#dwnTipoIden').val();
    var tbxIdenExtranj = jQuery('#tbxIdenExtranj').val();
    var dwnPais = jQuery('#dwnPais').val();
    var dwnProvinc = jQuery('#dwnProvinc').val();
    var dwnCantones = jQuery('#dwnCantones').val();
    var dwnDistritos = jQuery('#dwnDistritos').val();
    var dwnBarrios = jQuery('#dwnBarrios').val();
    var tbxOtrasSenias = jQuery('#tbxOtrasSenias').val();
    var txbEmail = jQuery('#txbEmail').val();
    var tbxTelef = jQuery('#tbxTelef').val();
    var tbxFax = jQuery('#tbxFax').val();
    var userId = jQuery('#UserId').val();

    if (tbxNombre != "" && tbxNomComercial != "") {
        jQuery.ajax({
            url: '/clientes/controller/sendReceptor.php',
            type: 'POST',
            data: {
                receptor: {
                    id: 0,
                    iuser_id: userId,
                    nombre: tbxNombre,
                    nombrecomercial: tbxNomComercial,
                    razonsocial: tbxRazonSocial,
                    identificacion: tbxIdenTributaria,
                    tipoidentificacion_id: dwnTipoIden,
                    identificacionextranjero: tbxIdenExtranj,
                    codigopais: dwnPais,
                    provincia: dwnProvinc,
                    canton: dwnCantones,
                    distrito: dwnDistritos,
                    barrio: dwnBarrios,
                    otrassenias: tbxOtrasSenias,
                    correoelectronico: txbEmail,
                    telefono: tbxTelef,
                    fax: tbxFax
                }
            },
            success: function (data) {
                if (data == 1) {
                    showNoty('success', "Datos salvados correctamete");
                } else {
                    showNoty('error', "Hubo un error al salvar datos");
                }
            }
        });
    } else {
        showNoty('warning', "Favor llenar todos los campos");
    }
}





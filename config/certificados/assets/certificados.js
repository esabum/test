var ObjSubirArchivo = null;
function loadUploader() {
    ObjSubirArchivo = jQuery("#subirarchivo").uploadFile({
        url: "/config/certificados/controller/sendCertif.php",
        dragDrop: true,
        fileName: "certificado",
        maxFileCount: 1,
        showDelete: true,
        autoSubmit: false,
        showFileSize: false,
        showFileCounter: false,
        allowedTypes: "p12",
        dynamicFormData: function ()
        {
            var userId = jQuery('#dwnUsers').val();
            var claveCerti = jQuery('#tbxClaveCerti').val();
            var data = {
                UserH: userId,
                clave: claveCerti
            };
            return data;
        },
        onSuccess: function (files, data, xhr, pd) {
            showNoty('success', "Salvado correctamente");
        }
    });
}

jQuery(document).on('change', '#dwnUsers', function () {
    jQuery('#certiForm').html("");
    change_form();
});

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

jQuery(document).on('change', '#dwnTypeData', function () {
    jQuery('#certiForm').html("");
    change_form();
});

jQuery(document).on('click', '#btnSaveCert', function () {
    ObjSubirArchivo.startUpload();
});

jQuery(document).on('click', '#btnSaveUserPass', function () {
    sendUserPass();
});
jQuery(document).on('click', '#btnSaveEmisor', function () {
    sendEmisor();
});

function change_form() {
    var userId = jQuery('#dwnUsers').val();
    var dwnTypeData = jQuery('#dwnTypeData').val();
    if (userId != 0 && dwnTypeData != 0) {
        if (dwnTypeData == 1) {
            jQuery.ajax({
                url: '/config/certificados/controller/getCertiForm.php',
                type: 'POST',
                data: {
                    UserH: userId
                },
                success: function (data) {
                    jQuery('#certiForm').html(data);
                    popover();
                }
            });
        }
        if (dwnTypeData == 2) {
            jQuery.ajax({
                url: '/config/certificados/controller/getFormUserPass.php',
                type: 'POST',
                data: {
                    UserH: userId
                },
                success: function (data) {
                    jQuery('#certiForm').html(data);
                }
            });
        }
        if (dwnTypeData == 3) {
            jQuery.ajax({
                url: '/config/certificados/controller/getFormEmisor.php',
                type: 'POST',
                data: {
                    UserH: userId
                },
                success: function (data) {
                    jQuery('#certiForm').html(data);
                }
            });
        }
    }
}

function sendUserPass() {
    var userId = jQuery('#dwnUsers').val();
    var usuarioH = jQuery('#tbxUser').val();
    var passwH = jQuery('#tbxPass').val();
    var ambiente = jQuery('#dwnAmbiente').val();
    if (usuarioH != "" && passwH != "") {
        jQuery.ajax({
            url: '/config/certificados/controller/sendUserPass.php',
            type: 'POST',
            data: {
                UserH: userId,
                usuarioH: usuarioH,
                passwH: passwH,
                ambiente: ambiente
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

function sendEmisor() {

    var tbxNombre = jQuery('#tbxNombre').val();
    var tbxNomComercial = jQuery('#tbxNomComercial').val();
    var tbxSucursal = jQuery('#tbxSucursal').val();
    var tbxNumSucursal = jQuery('#tbxNumSucursal').val();
    var tbxNumCaja = jQuery('#tbxNumCaja').val();
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
    var userId = jQuery('#dwnUsers').val();
    var emisor_id = jQuery('#emisor_id').val();



    if (tbxNombre != "" && tbxNomComercial != "") {
        jQuery.ajax({
            url: '/config/certificados/controller/sendEmisor.php',
            type: 'POST',
            data: {
                emisor: {
                    emisor_id: emisor_id,
                    iuser_id : userId,
                    nombre: tbxNombre,
                    nombrecomercial: tbxNomComercial,
                    sucursal: tbxSucursal,
                    numerosucursal: tbxNumSucursal,
                    numerocaja: tbxNumCaja,
                    identificaciontributaria: tbxIdenTributaria,
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





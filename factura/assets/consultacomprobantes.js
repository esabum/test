
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
            jQuery('#resultCompro').html(data);
            //console.log(data);
        }
    });


});

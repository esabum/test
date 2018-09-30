/*User selector add-on for select2*/
/* Example:
<link href="/<?= APPBASE ?>users/assets/usergroupselect2/usergroupselect2.css" rel="stylesheet" type="text/css"/>
<script src="/<?=APPBASE?>users/assets/usergroupselect2/usergroupselect2.js" type="text/javascript"></script>

Single Select:
jQuery.ajax({
    url: '/users/controller/getUserSelect.php',
    type: 'POST',
    data: {
        selectedids: [],
        groupids: [1,3]
    },
    success: function (data) {
        jQuery('#groupmain').userGroupSelect2({
            jsonData: JSON.parse(data),
            initialsClass: '.profile',
            multiple: false,
            defaulttext: 'Unassigned',
            defaulticon: '/assets/images/avatars/user_icon.png'
        });
    }
});           

Multi Select:
jQuery.ajax({
    url: '/users/controller/getGroupSelect.php',
    type: 'POST',
    data: {
        selectedids: [7,3],
        groupids: [1,3]
    },
    success: function (data) {
        jQuery('#groupmain').userGroupSelect2({
            jsonData: JSON.parse(data),
            initialsClass: '.profile',
            multiple: true,
            defaulttext: 'Unassigned',
            defaulticon: '/assets/images/avatars/group_icon.png'
        });
    }
});           
*/

jQuery.fn.userGroupSelect2 = function () {
    var that = this;
    var options = jQuery.extend({
        jsonData: [],
        initialsClass: '',
        multiple: false,
        defaulttext: 'Unassigned',
        defaulticon: '',
        callback: function () {}
    }, arguments[0] || {});
    /*User Selector*/
    jQuery(that).select2({
        data: options.jsonData,
        formatResult: select2user_format,
        formatSelection: select2user_format,
        containerCssClass: 'user-select2',
        dropdownCssClass: 'user-select2',
        allowClear: true,
        multiple: options.multiple,
        placeholder: {
            id: '0',
            text: options.defaulttext,
            avatar: "<img src='" + options.defaulticon + "' class='img-sm img-circle m-r-10 bg-gainsboro'/>"
        },
        /*"<img src='"+ options.defaulticon +"' class='img-sm img-circle m-r-10 bg-gainsboro'/>Unassigned",*/
        escapeMarkup: function (element) {
            return select2user_format(element);
        },
        initSelection: function (element, callback) {
            if (options.multiple) {
                if (element.val() == "") {
                    var sels = []
                    jQuery(options.jsonData).each(function () {
                        if (this.selected != undefined) {
                            sels.push(this);
                        }
                    });
                    callback(sels);
                } else {
                    var sels = []
                    jQuery(options.jsonData).each(function () {
                        if (this.id == element.val()) {
                            sels.push(this);
                        }
                    });
                    callback(sels);
                }
            } else {
                jQuery(options.jsonData).each(function () {
                    if (this.selected != undefined || this.id == jQuery(element).val()) {
                        delete this.selected;
                        callback(this);
                    }
                });
            }
        },
    }).select2('val', []);
    jQuery(options.initialsClass).initial();
    jQuery(that).on('select2-loaded', function () {
        jQuery(options.initialsClass).initial();
    });
    jQuery(that).on('select2-selecting', function (e) {
        if (jQuery(this).val() == "0") {
            jQuery(this).val('').trigger('change');
        }
    });
    jQuery(that).on('select2-removed', function (e) {
        if (!jQuery(this).val().length) {
            jQuery(this).val('0').trigger('change');
        }
    });
    jQuery(that).on('change', function (e) {
        jQuery(options.initialsClass).initial();
    });
    options.callback();
};
function select2user_format(element) {
    return element.avatar + element.text;
}

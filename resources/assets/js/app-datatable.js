'use strict';

jQuery(document).ready(function () {
    $.fn.dataTable.ext.errMode = 'throw';
});

window.myappUtil.dataTableDoRowDelete = function (dataTable, options) {
    // ensure options is an object
    if (typeof (options) !== 'object' || options === null) {
        options = {};
    }

    if (confirm(myappUtil.determineOption(options['confirmMessage'], 'The record will be deleted. Are you sure?'))) {
        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            url: options.url,
            method: 'DELETE',
            success: function (response, textStatus, jqXHR) {
                // console.log(response);
                if (response['alert-class'] === 'success') {
                    myappUtil.showAlert({
                        status: 'success',
                        message: response['status'],
                        timeout: 5000
                    });
                    dataTable.ajax.reload(null, false);
                } else {
                    myappUtil.showAlert({
                        status: 'warning',
                        message: response['status']
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(errorThrown);
                console.error(textStatus);
                myappUtil.showAlert({
                    status: 'danger',
                    message: '[' + errorThrown + '] ' + textStatus
                });
            }
        });
    }
    return false;
};
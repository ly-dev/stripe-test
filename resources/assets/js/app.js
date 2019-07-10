/**
 * First we will load all of this project's JavaScript dependencies
 */

require('./bootstrap');

window.myappUtil = {};

// helper to have the lodash reference
window.myappUtil.lodash = window._;

// helper to get option setting or default setting
window.myappUtil.determineOption = function (option, defaultValue) {
    var expectedType = typeof (defaultValue),
        result = defaultValue;

    if (option && typeof (option) === expectedType) {
        result = option;
    }

    return result;
};

// helper to show alert
window.myappUtil.showAlert = function (options) {
    if (typeof (options) === 'object' || options !== null) {

        // default values
        if (!options.target) {
            options.target = {
                selector: 'h1', // element select
                position: 'before' // before, after, prepend, append
            }
        }

        if (!options.status) {
            options.status = 'warning';
        }

        var $alertHtml = jQuery(
            '<div class="alert alert-' + options.status + ' alert-dismissible fade show" role="alert">' +
            options.message +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>');

        var $target = jQuery(options.target.selector);

        if ($target) {
            // remove existing alert box
            jQuery('div.alert').remove();
            
            switch (options.target.position) {
                case 'before':
                    $target.before($alertHtml);
                    break;
                case 'after':
                    $target.after($alertHtml);
                    break;
                case 'prepend':
                    $target.prepend($alertHtml);
                    break;
                case 'append':
                    $target.append($alertHtml);
                    break;
            }
        }

        if (options.timeout > 0) {
            setTimeout(function () {
                $alertHtml.fadeOut("slow", function () {
                    jQuery(this).remove();
                });
            }, options.timeout);
        }
    }
}
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

$(document).ready(function () {
    $('#company-wrap').find('input').attr('tabindex', -1);

    $('#billingAddress\\.companyAddress').unbind('change').bind('change', function () {
        $('#company-wrap').collapse($(this).is(':checked') ? 'show' : 'hide');
    });

    $('#shippingAddress\\.copyBillingAddress').unbind('change').bind('change', function () {
        $('#shipping-wrap').collapse($(this).is(':checked') ? 'hide' : 'show');
    });

    $('#clientDetails\\.createAccount').unbind('change').bind('change', function () {
        $('#create-account').collapse($(this).is(':checked') ? 'show' : 'hide');
    });

    $('#billingAddress\\.companyAddress').change();
    $('#shippingAddress\\.copyBillingAddress').change();
    $('#clientDetails\\.createAccount').change();

    $('#password-collapse').unbind('change').bind('change', function () {
        $('#password-wrap').collapse($(this).is(':checked') ? 'show' : 'hide');
    });

    $('#contactDetails\\.firstName').bind('change', function () {
        var firstName = $(this).val();
        var target = $('#billingAddress\\.firstName');
        if (target.val() == '') {
            target.val(firstName);
        }
    });

    $('#contactDetails\\.lastName').bind('change', function () {
        var firstName = $(this).val();
        var target = $('#billingAddress\\.lastName');
        if (target.val() == '') {
            target.val(firstName);
        }
    });
});
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

var oDefaults = {
    sName: '',
    sLabel: '',
    oClasses: {
        sFieldClass: 'field-price',
        sFieldSpanClass: 'field',
        sPrefixClass: 'prefix',
        sSuffixClass: 'suffix',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sDisabledClass: 'disabled',
        sFieldRepetitionClass: 'repetition',
        sAddRepetitionClass: 'add-field-repetition',
        sRemoveRepetitionClass: 'remove-field-repetition',
        sNetPriceClass: 'net-price',
        sGrossPriceClass: 'gross-price'
    },
    oImages: {
        sAddRepetition: 'images/icons/buttons/add.png',
        sRemoveRepetition: 'images/icons/buttons/delete.png'
    },
    sFieldType: 'text',
    sDefault: '',
    aoRules: [],
    sComment: ''
};

var GFormPriceEditor = GCore.ExtendClass(GFormTextField, function () {

    var gThis = this;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        var jLabel = $('<label for="' + gThis.GetId() + '"/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }
        gThis.m_jNode.append(jLabel);
        gThis.m_jNode.append(gThis._AddField());
        $(window).bind('OnVatChange', function () {
            gThis._CalculateNetPrice();
        });
    };

    gThis.GetValue = function (sRepetition) {
        if (gThis.m_jField == undefined) {
            return '';
        }
        return gThis.m_jField.eq(1).val();
    };

    gThis.SetValue = function (mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }

        gThis.m_jField.eq(1).val(mValue).change();
    };

    gThis._AddField = function (sId) {
        var jFieldNet = $('<input type="text" id="' + gThis.GetId() + '__net"/>');
        var jFieldGross = $('<input type="text" name="' + gThis.GetName() + '" id="' + gThis.GetId() + '"/>');
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        var jNetNode = $('<span class="' + gThis._GetClass('NetPrice') + '"/>');
        var jGrossNode = $('<span class="' + gThis._GetClass('GrossPrice') + '"/>');
        if (gThis.m_oOptions.asPrefixes[0] != undefined) {
            var jPrefix = $('<span class="' + gThis._GetClass('Prefix') + '"/>');
            jPrefix.html(gThis.m_oOptions.asPrefixes[0]);
            jNetNode.append(jPrefix);
        }
        jNetNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jFieldNet));
        if (gThis.m_oOptions.sSuffix != undefined) {
            var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
            jSuffix.html(gThis.m_oOptions.sSuffix);
            jNetNode.append(jSuffix);
        }
        if (gThis.m_oOptions.asPrefixes[1] != undefined) {
            var jPrefix = $('<span class="' + gThis._GetClass('Prefix') + '"/>');
            jPrefix.html(gThis.m_oOptions.asPrefixes[1]);
            jGrossNode.append(jPrefix);
        }
        jGrossNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jFieldGross));
        if (gThis.m_oOptions.sSuffix != undefined) {
            var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
            jSuffix.html(gThis.m_oOptions.sSuffix);
            jGrossNode.append(jSuffix);
        }

        var jError = $('<span class="' + gThis._GetClass('Required') + '"/>');
        jNetNode.append(jError);

        jRepetitionNode.append(jNetNode).append(jGrossNode);
        gThis.m_jField = jRepetitionNode.find('input');
        gThis.jRepetitionNode = jRepetitionNode;
        return gThis.jRepetitionNode;
    };

    gThis.OnShow = function () {
        gThis._CalculateNetPrice(gThis.m_jField.eq(1).val());
        gThis.m_bShown = true;
        if (!gThis.m_bResized) {
            gThis.m_bResized = true;
            gThis.m_jField.each(function () {
                var iWidth = Math.floor(parseInt($(this).css('width')) / 2) - 20;
                var jParent = $(this).closest('.' + gThis._GetClass('NetPrice') + ', .' + gThis._GetClass('GrossPrice'));
                if (jParent.find('.' + gThis._GetClass('Prefix')).length) {
                    iWidth -= ($(this).offset().left - jParent.find('.' + gThis._GetClass('Prefix')).offset().left) - 1;
                }
                if (jParent.find('.' + gThis._GetClass('Suffix')).length) {
                    iWidth -= jParent.find('.' + gThis._GetClass('Suffix')).width() + 4;
                }
                $(this).css('width', iWidth);
            });
        }
    };

    gThis._CalculateGrossPrice = function (sPrice) {
        var gVat = gThis.m_gForm.GetField(gThis.m_oOptions.sVatField);
        var iVatId = parseInt(gVat.GetValue());
        var fVat = 0;
        if (gThis.m_oOptions.aoVatValues[iVatId] != undefined) {
            fVat = parseFloat(gThis.m_oOptions.aoVatValues[iVatId]);
        }
        if (sPrice == undefined) {
            var sPrice = gThis.m_jField.eq(0).val();
        }
        var fPrice = parseFloat(sPrice.replace(/,/, '.'));
        fPrice = isNaN(fPrice) ? 0 : fPrice;
        gThis.m_jField.eq(1).val((fPrice * (1 + fVat / 100)).toFixed(2));
    };

    gThis._CalculateNetPrice = function (sPrice) {
        var gVat = gThis.m_gForm.GetField(gThis.m_oOptions.sVatField);
        var iVatId = gVat.GetValue();
        var fVat = 0;
        if (gThis.m_oOptions.aoVatValues[iVatId] != undefined) {
            fVat = parseFloat(gThis.m_oOptions.aoVatValues[iVatId]);
        }
        if (sPrice == undefined) {
            var sPrice = gThis.m_jField.eq(1).val();
        }
        var fPrice = parseFloat(sPrice.replace(/,/, '.'));
        fPrice = isNaN(fPrice) ? 0 : fPrice;
        gThis.m_jField.eq(0).val((fPrice / (1 + fVat / 100)).toFixed(2));
    };

    gThis._Initialize = function () {

        var fHandler = GEventHandler(function (eEvent) {
            setTimeout(function () {
                gThis._CalculateGrossPrice($(eEvent.currentTarget).val());
            }, 5);
        });
        gThis.m_jField.eq(0).keypress(fHandler).blur(fHandler).change(gThis.ValidateField);

        fHandler = GEventHandler(function (eEvent) {
            setTimeout(function () {
                gThis._CalculateNetPrice($(eEvent.currentTarget).val());
            }, 5);
        });
        gThis.m_jField.eq(1).keypress(fHandler).blur(fHandler).change(gThis.ValidateField);
        gThis.m_gForm.GetField(gThis.m_oOptions.sVatField).m_jField.change(GEventHandler(function (eEvent) {
            gThis._CalculateNetPrice();
        }));
        gThis._CalculateNetPrice();
        gThis.m_jField.eq(1).change();
    };

    gThis.ValidateField = GEventHandler(function (eEvent) {
        var fPrice = parseFloat($(eEvent.currentTarget).val().replace(/,/, '.'));
        fPrice = isNaN(fPrice) ? 0 : fPrice;
        $(eEvent.currentTarget).val(fPrice.toFixed(2));
    });

    gThis.Reset = function () {
        gThis.m_jField.eq(1).val(gThis.m_oOptions.sDefault).change();
        gThis._CalculateNetPrice();
    };


}, oDefaults);
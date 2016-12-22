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
    asPrefixes: [],
    sSuffix: '',
    aoVatValues: [],
    oClasses: {
        sFieldClass: 'field-range-editor',
        sFieldTextClass: 'field-text',
        sFieldPriceClass: 'field-price',
        sFieldCheckboxClass: 'field-checkbox',
        sFieldSelectClass: 'field-select',
        sFieldSpanClass: 'field',
        sRangeColumnClass: 'price',
        sMinColumnClass: 'min',
        sMaxColumnClass: 'max',
        sOptionsColumnClass: 'options',
        sPrefixClass: 'prefix',
        sSuffixClass: 'suffix',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sFieldRepetitionClass: 'repetition',
        sAddRepetitionClass: 'add-field-repetition',
        sRemoveRepetitionClass: 'remove-field-repetition',
        sNetPriceClass: 'net-price',
        sGrossPriceClass: 'gross-price'
    },
    oImages: {
        sAdd: 'images/icons/buttons/add.png',
        sRemove: 'images/icons/buttons/delete.png'
    },
    sFieldType: 'text',
    sDefault: '',
    aoRules: [],
    aoOptions: [],
    sComment: '',
    iPricePrecision: 4,
    iRangePrecision: 4
};

var GFormRangeEditor = GCore.ExtendClass(GFormField, function () {

    var gThis = this;
    gThis.m_jTable;
    gThis.m_jVat;
    gThis.m_jUseVat;
    gThis.m_jVatField;
    gThis.m_jUseVatField;
    gThis.m_jRangeFields;
    gThis.m_jPriceFields;
    gThis.m_jNetPriceFields;
    gThis.m_jGrossPriceFields;
    gThis.m_aoRanges = [];

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        gThis._AddVatCheckbox();
        gThis._AddVat();
        gThis._AddTable();
    };

    gThis._AddTable = function () {
        gThis.m_jTable = $('<table cellspacing="0"/>');
        gThis.m_jNode.append(gThis.m_jTable);
    };

    gThis._WriteTable = function () {
        if (!(gThis.m_aoRanges instanceof Array) || !gThis.m_aoRanges.length) {
            gThis.m_aoRanges = [{
                min: (0).toFixed(gThis.m_oOptions.iRangePrecision),
                max: (0).toFixed(gThis.m_oOptions.iRangePrecision),
                price: (gThis.m_oOptions.aoOptions.length) ? gThis.m_oOptions.aoOptions[0].sValue : (0).toFixed(gThis.m_oOptions.iPricePrecision)
            }];
        }
        gThis.m_jTable.find('tbody').remove();
        gThis.m_jGrossPriceFields = $();
        gThis.m_jNetPriceFields = $();
        var jBody = $('<tbody/>');
        var iRanges = gThis.m_aoRanges.length;
        for (var i = 0; i < iRanges; i++) {
            var jTr = $('<tr/>');
            var jMin = $('<td class="' + gThis._GetClass('RangeColumn') + ' ' + gThis._GetClass('MinColumn') + '"/>');
            jMin.append(gThis._AddMin(i, gThis.m_aoRanges[i]));

            var jMax = $('<td class="' + gThis._GetClass('RangeColumn') + ' ' + gThis._GetClass('MaxColumn') + '"/>');
            if (i < iRanges) {
                jMax.append(gThis._AddMax(i, gThis.m_aoRanges[i]));
            }
            var jPrice = $('<td/>');
            if (gThis.m_oOptions.aoOptions.length) {
                jPrice.append(gThis._AddSelect(i, gThis.m_aoRanges[i]));
            }
            else if (gThis.m_jUseVatField.is(':checked')) {
                jPrice.append(gThis._AddPriceWithVat(i, gThis.m_aoRanges[i]));
            }
            else {
                jPrice.append(gThis._AddPrice(i, gThis.m_aoRanges[i]));
            }
            jOptions = $('<td class="' + gThis._GetClass('OptionsColumn') + '"/>');
            var jAdd = $('<a tabindex="-1" href="#"/>');
            jAdd.append('<img src="' + gThis._GetImage('Add') + '" alt="' + GForm.Language.range_editor_add_range + '" title="' + GForm.Language.range_editor_add_range + '"/>');
            jOptions.append(jAdd);
            jAdd.bind('click', {i: i}, GEventHandler(function (eEvent) {
                gThis.AddNewRange(eEvent.data.i);
                return false;
            }));
            if (iRanges > 1) {
                var jRemove = $('<a tabindex="-1" href="#"/>');
                jRemove.append('<img src="' + gThis._GetImage('Remove') + '" alt="' + GForm.Language.range_editor_remove_range + '" title="' + GForm.Language.range_editor_remove_range + '"/>');
                jOptions.append(jRemove);
                jRemove.bind('click', {i: i}, GEventHandler(function (eEvent) {
                    gThis.RemoveRange(eEvent.data.i);
                    return false;
                }));
            }
            jTr.append(jMin);
            jTr.append(jMax);
            jTr.append(jPrice);
            jTr.append(jOptions);
            jBody.append(jTr);
        }
        gThis.m_jTable.append(jBody);
        gThis.InitTable();
    };

    gThis.AddNewRange = function (iAfterWhich) {
        var fOffset = 1 / Math.pow(10, gThis.m_oOptions.iRangePrecision);
        var oRange = {
            min: (parseFloat(gThis.m_aoRanges[iAfterWhich].max) + fOffset).toFixed(gThis.m_oOptions.iRangePrecision),
            max: (9999).toFixed(gThis.m_oOptions.iRangePrecision),
            price: (gThis.m_oOptions.aoOptions.length) ? gThis.m_oOptions.aoOptions[0].sValue : (0).toFixed(gThis.m_oOptions.iPricePrecision)
        };
        if (gThis.m_aoRanges[iAfterWhich + 1] != undefined) {
            var fRange = Math.max(fOffset, parseFloat(gThis.m_aoRanges[iAfterWhich + 1].max) - parseFloat(oRange.min));
            oRange.max = (parseFloat(oRange.min) + fRange / 2).toFixed(gThis.m_oOptions.iRangePrecision);
            gThis.m_aoRanges[iAfterWhich + 1].min = (parseFloat(oRange.max) + fOffset).toFixed(gThis.m_oOptions.iRangePrecision);
        }
        var aoRanges = gThis.m_aoRanges.slice(0, iAfterWhich + 1).concat(oRange, gThis.m_aoRanges.slice(iAfterWhich + 1));
        gThis.m_aoRanges = aoRanges;
        gThis._WriteTable();
    };

    gThis.RemoveRange = function (iWhich) {
        gThis.m_aoRanges.splice(iWhich, 1);
        var fOffset = 1 / Math.pow(10, gThis.m_oOptions.iRangePrecision);
        if ((gThis.m_aoRanges[iWhich] != undefined) && (gThis.m_aoRanges[iWhich - 1] != undefined)) {
            gThis.m_aoRanges[iWhich].min = gThis.m_aoRanges[iWhich - 1].max;
            gThis.m_aoRanges[iWhich].min = (parseFloat(gThis.m_aoRanges[iWhich].min) + fOffset).toFixed(gThis.m_oOptions.iRangePrecision);
        }
        gThis._WriteTable();
    };

    gThis._AddMin = function (sId, oRange) {
        var jPrice = $('<div/>').addClass(gThis._GetClass('FieldText'));
        var jFieldNet = $('<input type="text" name="' + gThis.GetName() + '[ranges][' + sId + '][min]" id="' + gThis.GetId() + '__' + sId + '__min" value="' + oRange.min + '"/>');
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        var jPrefix = $('<span class="' + gThis._GetClass('Prefix') + '"/>');
        jPrefix.html(GForm.Language.range_editor_from);
        jRepetitionNode.append(jPrefix);
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jFieldNet));
        if (gThis.m_oOptions.sRangeSuffix != undefined) {
            var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
            jSuffix.html(gThis.m_oOptions.sRangeSuffix);
            jRepetitionNode.append(jSuffix);
        }
        jPrice.append(jRepetitionNode);
        return jPrice;
    };

    gThis._AddMax = function (sId, oRange) {
        var jPrice = $('<div/>').addClass(gThis._GetClass('FieldText'));
        var jFieldNet = $('<input type="text" name="' + gThis.GetName() + '[ranges][' + sId + '][max]" id="' + gThis.GetId() + '__' + sId + '__max" value="' + oRange.max + '"/>');
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        var jPrefix = $('<span class="' + gThis._GetClass('Prefix') + '"/>');
        jPrefix.html(GForm.Language.range_editor_to);
        jRepetitionNode.append(jPrefix);
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jFieldNet));
        if (gThis.m_oOptions.sRangeSuffix != undefined) {
            var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
            jSuffix.html(gThis.m_oOptions.sRangeSuffix);
            jRepetitionNode.append(jSuffix);
        }
        jPrice.append(jRepetitionNode);
        return jPrice;
    };

    gThis.InitTable = function () {

        gThis.m_jTable.find('tbody input').focus(GEventHandler(function (eEvent) {
            $(this).closest('.' + gThis._GetClass('FieldSpan')).addClass(gThis._GetClass('Focused'));
        })).blur(GEventHandler(function (eEvent) {
            $(this).closest('.' + gThis._GetClass('FieldSpan')).removeClass(gThis._GetClass('Focused'));
        }));
        gThis._ResizeFields();

        var fHandler = GEventHandler(function (eEvent) {
            setTimeout(function () {
                var jNet = $(eEvent.currentTarget);
                jNet.closest('td').find('.' + gThis._GetClass('GrossPrice') + ' input').val(gThis._CalculateGrossPrice(jNet.val()));
            }, 5);
        });
        gThis.m_jTable.find('tbody .' + gThis._GetClass('NetPrice') + ' input').keypress(fHandler).blur(fHandler).change(gThis.ValidatePrice).change(GEventHandler(function (eEvent) {
            var i = gThis.m_jTable.find('tbody tr').index($(this).closest('tr'));
            gThis.m_aoRanges[i].price = $(this).val();
        }));
        gThis.m_jTable.find('.' + gThis._GetClass('NetPrice') + ' input').each(function () {
            $(this).triggerHandler('blur');
        });

        fHandler = GEventHandler(function (eEvent) {
            setTimeout(function () {
                var jGross = $(eEvent.currentTarget);
                jGross.closest('td').find('.' + gThis._GetClass('NetPrice') + ' input').val(gThis._CalculateNetPrice(jGross.val()));
            }, 5);
        });
        gThis.m_jTable.find('tbody .' + gThis._GetClass('GrossPrice') + ' input').keypress(fHandler).blur(fHandler).change(gThis.ValidatePrice).change(GEventHandler(function (eEvent) {
            var i = gThis.m_jTable.find('tbody tr').index($(this).closest('tr'));
            gThis.m_aoRanges[i].price = $(this).closest('td').find('.' + gThis._GetClass('NetPrice') + ' input').val();
        }));

        fHandler = GEventHandler(function (eEvent) {
            setTimeout(function () {
                var fValue = Math.abs(parseFloat($(eEvent.currentTarget).val().replace(/,/, '.')));
                if (isNaN(fValue)) {
                    return;
                }
                $(eEvent.currentTarget).closest('tr').prev('tr').find('.' + gThis._GetClass('MaxColumn') + ' input').val((fValue - 1 / Math.pow(10, gThis.m_oOptions.iRangePrecision)).toFixed(gThis.m_oOptions.iRangePrecision)).change();
            }, 5);
        });
        gThis.m_jTable.find('tbody tr .' + gThis._GetClass('MinColumn') + ' input').keypress(fHandler).blur(fHandler).change(gThis.ValidateRange).change(GEventHandler(function (eEvent) {
            var i = gThis.m_jTable.find('tbody tr').index($(this).closest('tr'));
            gThis.m_aoRanges[i].min = $(this).val();
        }));

        fHandler = GEventHandler(function (eEvent) {
            setTimeout(function () {
                var fValue = parseFloat($(eEvent.currentTarget).val().replace(/,/, '.'));
                if (isNaN(fValue)) {
                    return;
                }
                $(eEvent.currentTarget).closest('tr').next('tr').find('.' + gThis._GetClass('MinColumn') + ' input').val((fValue + 1 / Math.pow(10, gThis.m_oOptions.iRangePrecision)).toFixed(gThis.m_oOptions.iRangePrecision)).change();
            }, 5);
        });
        gThis.m_jTable.find('tbody tr .' + gThis._GetClass('MaxColumn') + ' input').keypress(fHandler).blur(fHandler).change(gThis.ValidateRange).change(GEventHandler(function (eEvent) {
            var i = gThis.m_jTable.find('tbody tr').index($(this).closest('tr'));
            gThis.m_aoRanges[i].max = $(this).val();
        }));

        gThis.m_jTable.find('select').each(function (i) {
            $(this).bind('change', {i: i}, GEventHandler(function (eEvent) {
                gThis.m_aoRanges[i].price = $(this).find('option:selected').attr('value');
            })).GSelect();
        });

    };

    gThis._AddVat = function () {
        gThis.m_jVat = $('<div/>').addClass(gThis._GetClass('FieldSelect'));
        var jLabel = $('<label for="' + gThis.GetId() + '__vat"/>');
        jLabel.text(GForm.Language.range_editor_vat);
        gThis.m_jVat.append(jLabel);
        var jField = $('<select name="' + gThis.GetName() + '[vat]" id="' + gThis.GetId() + '__vat"/>');
        for (var i in gThis.m_oOptions.aoVatValues) {
            jField.append('<option value="' + i + '">' + gThis.m_oOptions.aoVatValues[i] + '</option>');
        }
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
        var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
        jSuffix.text('%');
        jRepetitionNode.append(jSuffix);
        gThis.m_jVat.append(jRepetitionNode);
        gThis.m_jNode.append(gThis.m_jVat);
        gThis.m_jVatField = jField;
    };

    gThis._AddVatCheckbox = function () {
        if (!gThis.m_oOptions.aoVatValues.length) {
            gThis.m_jUseVatField = $('<div/>');
            return;
        }
        gThis.m_jUseVat = $('<div/>').addClass(gThis._GetClass('FieldCheckbox'));
        var jLabel = $('<label for="' + gThis.GetId() + '__use_vat"/>');
        jLabel.text(GForm.Language.range_editor_use_vat);
        gThis.m_jUseVat.append(jLabel);
        var jField = $('<input type="checkbox" name="' + gThis.GetName() + '[use_vat]" id="' + gThis.GetId() + '__use_vat" value="1"/>');
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jField));
        gThis.m_jUseVat.append(jRepetitionNode);
        gThis.m_jNode.append(gThis.m_jUseVat);
        gThis.m_jUseVatField = jField;
    };

    gThis.GetValue = function (sRepetition) {
        return {
            use_vat: gThis.m_jUseVatField.is(':checked'),
            vat: gThis.m_jVatField.find('option:selected').attr('value'),
            ranges: gThis.m_aoRanges
        };
    };

    gThis.SetValue = function (mValue, sRepetition) {
        if (mValue != undefined) {
            if ((mValue['use_vat'] && !gThis.m_jUseVatField.is(':checked')) || (!mValue['use_vat'] && gThis.m_jUseVatField.is(':checked'))) {
                gThis.m_jUseVatField.click();
            }
            mValue['vat'] && gThis.m_jVatField.val(mValue['vat']).change();
            if ((mValue['ranges'] == undefined) || !(mValue['ranges'] instanceof Array)) {
                mValue['ranges'] = [];
            }
            gThis.m_aoRanges = mValue['ranges'];
        }

        gThis._WriteTable();
        gThis.m_jUseVatField.triggerHandler('click');
    };

    gThis._AddPriceWithVat = function (sId, oRange) {
        var jPrice = $('<div/>').addClass(gThis._GetClass('FieldPrice'));
        var jFieldNet = $('<input type="text" name="' + gThis.GetName() + '[ranges][' + sId + '][price]" id="' + gThis.GetId() + '__' + sId + '__price" value="' + oRange.price + '"/>');
        var jFieldGross = $('<input type="text" id="' + gThis.GetId() + '__' + sId + '__gross"/>');
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
        jRepetitionNode.append(jNetNode).append(jGrossNode);
        if ((gThis.m_jNetPriceFields instanceof $) && gThis.m_jNetPriceFields.length) {
            gThis.m_jNetPriceFields.add(jRepetitionNode.find('input:eq(0)'));
        }
        else {
            gThis.m_jNetPriceFields = jRepetitionNode.find('input:eq(0)');
        }
        if ((gThis.m_jGrossPriceFields instanceof $) && gThis.m_jGrossPriceFields.length) {
            gThis.m_jGrossPriceFields.add(jRepetitionNode.find('input:eq(1)'));
        }
        else {
            gThis.m_jGrossPriceFields = jRepetitionNode.find('input:eq(1)');
        }
        jPrice.append(jRepetitionNode);
        return jPrice;
    };

    gThis._AddPrice = function (sId, oRange) {
        var jPrice = $('<div/>').addClass(gThis._GetClass('FieldText'));
        var jFieldNet = $('<input type="text" name="' + gThis.GetName() + '[ranges][' + sId + '][price]" id="' + gThis.GetId() + '__' + sId + '__price" value="' + oRange.price + '"/>');
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jFieldNet));
        if (gThis.m_oOptions.sSuffix != undefined) {
            var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
            jSuffix.html(gThis.m_oOptions.sSuffix);
            jRepetitionNode.append(jSuffix);
        }
        if ((gThis.m_jNetPriceFields instanceof $) && gThis.m_jNetPriceFields.length) {
            gThis.m_jNetPriceFields.add(jRepetitionNode.find('input:eq(0)'));
        }
        else {
            gThis.m_jNetPriceFields = jRepetitionNode.find('input:eq(0)');
        }
        jPrice.append(jRepetitionNode);
        return jPrice;
    };

    gThis._AddSelect = function (sId, oRange) {
        var jPrice = $('<div/>').addClass(gThis._GetClass('FieldSelect'));
        var jFieldNet = $('<select name="' + gThis.GetName() + '[ranges][' + sId + '][price]" id="' + gThis.GetId() + '__' + sId + '__price"/>');
        for (var i = 0; i < gThis.m_oOptions.aoOptions.length; i++) {
            jFieldNet.append('<option value="' + gThis.m_oOptions.aoOptions[i].sValue + '"' + ((oRange.price == gThis.m_oOptions.aoOptions[i].sValue) ? ' selected="selected"' : '') + '>' + gThis.m_oOptions.aoOptions[i].sLabel + '</option>');
        }
        var jRepetitionNode = $('<span class="' + gThis._GetClass('FieldRepetition') + '"/>');
        jRepetitionNode.append($('<span class="' + gThis._GetClass('FieldSpan') + '"/>').append(jFieldNet));
        if (gThis.m_oOptions.sSuffix != undefined) {
            var jSuffix = $('<span class="' + gThis._GetClass('Suffix') + '"/>');
            jSuffix.html(gThis.m_oOptions.sSuffix);
            jRepetitionNode.append(jSuffix);
        }
        if ((gThis.m_jNetPriceFields instanceof $) && gThis.m_jNetPriceFields.length) {
            gThis.m_jNetPriceFields.add(jRepetitionNode.find('input:eq(0)'));
        }
        else {
            gThis.m_jNetPriceFields = jRepetitionNode.find('input:eq(0)');
        }
        jPrice.append(jRepetitionNode);
        return jPrice;
    };

    gThis.OnShow = function () {
        if (!gThis.m_bShown) {
            gThis.m_jVatField.GSelect();
        }
        gThis.m_bShown = true;
        if (!gThis.m_bResized) {
            gThis.m_bResized = true;
            gThis._ResizeFields();
        }
        gThis.m_jUseVatField.triggerHandler('click');
    };

    gThis._ResizeFields = function () {
        gThis.m_jTable.find('.' + gThis._GetClass('NetPrice') + ' input, .' + gThis._GetClass('GrossPrice') + ' input').each(function () {
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
    };

    gThis._CalculateGrossPrice = function (sPrice) {
        var iVatId = gThis.m_jVatField.find('option:selected').attr('value');
        var fVat = gThis.m_oOptions.aoVatValues[iVatId];
        var fPrice = parseFloat(sPrice.replace(/,/, '.'));
        fPrice = isNaN(fPrice) ? 0 : fPrice;
        return (fPrice * (1 + fVat / 100)).toFixed(gThis.m_oOptions.iPricePrecision);
    };

    gThis._CalculateNetPrice = function (sPrice) {
        var iVatId = gThis.m_jVatField.find('option:selected').attr('value');
        var fVat = gThis.m_oOptions.aoVatValues[iVatId];
        var fPrice = parseFloat(sPrice.replace(/,/, '.'));
        fPrice = isNaN(fPrice) ? 0 : fPrice;
        return (fPrice / (1 + fVat / 100)).toFixed(gThis.m_oOptions.iPricePrecision);
    };

    gThis._Initialize = function () {
        if (gThis.m_oOptions.aoVatValues.length) {
            gThis.m_jUseVatField.click(GEventHandler(function (eEvent) {
                gThis._WriteTable();
                if ($(this).is(':checked')) {
                    gThis.m_jVat.slideDown(100);
                    gThis.m_jTable.find('.' + gThis._GetClass('NetPrice') + ' input').each(function () {
                        $(this).triggerHandler('blur');
                    });
                }
                else {
                    gThis.m_jVat.slideUp(100);
                }
            }));
            gThis.m_jVatField.change(GEventHandler(function (eEvent) {
                gThis._WriteTable();
            }));
        }
        else {
            gThis.m_jVat.css('display', 'none');
        }
    };

    gThis.ValidatePrice = GEventHandler(function (eEvent) {
        var fPrice = parseFloat($(eEvent.currentTarget).val().replace(/,/, '.'));
        fPrice = isNaN(fPrice) ? 0 : Math.abs(fPrice);
        $(eEvent.currentTarget).val(fPrice.toFixed(gThis.m_oOptions.iPricePrecision));
    });

    gThis.ValidateRange = GEventHandler(function (eEvent) {
        var fPrice = parseFloat($(eEvent.currentTarget).val().replace(/,/, '.'));
        fPrice = isNaN(fPrice) ? 0 : Math.abs(fPrice);
        $(eEvent.currentTarget).val(fPrice.toFixed(gThis.m_oOptions.iRangePrecision));
    });

    gThis.Reset = function () {
        gThis.SetValue(gThis.m_oOptions.sDefault);
    };

}, oDefaults);
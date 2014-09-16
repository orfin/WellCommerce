/*
 * PRODUCT VARIANTS EDITOR
 */

var oDefaults = {
    sName: '',
    sLabel: '',
    oClasses: {
        sFieldClass: 'field-product-variants-editor',
        sFieldSpanClass: 'field',
        sGroupClass: 'group',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting'
    },
    oImages: {
        sDeleteIcon: 'images/icons/datagrid/delete.png',
        sSaveIcon: 'images/icons/datagrid/save.png',
        sAddIcon: 'images/icons/datagrid/add.png'
    },
    aoOptions: [],
    asDefaults: '',
    aoRules: [],
    sComment: '',
    fGetSetsForCategories: GCore.NULL,
    fGetCartesian: GCore.NULL,
    fGetAttributesForSet: GCore.NULL,
    fGetValuesForAttribute: GCore.NULL,
    fAddAttribute: GCore.NULL,
    fAddValue: GCore.NULL,
    sCategoryField: '',
    sPriceField: '',
    sVatField: '',
    sCurrency: 'PLN'
};

/**
 * GFormProductVariantsEditor
 *
 * @type {*}
 */
var GFormProductVariantsEditor = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bShown = false;

    gThis.m_fLoadProducts;
    gThis.m_fProcessProduct;
    gThis.m_jDatagrid;
    gThis.m_gDatagrid;
    gThis.m_gDataProvider;
    gThis.m_jSetSelect;
    gThis.m_jSetSelectNode;
    gThis.m_jSetEditor;
    gThis.m_jSetEditorLabel;
    gThis.m_jVariantEditor;
    gThis.m_jVariantEditorWrapper;
    gThis.m_jVariantEditorOptions;
    gThis.m_aoSets = [];
    gThis.m_aoAttributes = [];
    gThis.m_bFirstLoad = true;
    gThis.m_aoVariants = [];
    gThis.m_sEditedVariant = GCore.NULL;
    gThis.m_mDataToPopulate;

    gThis.GetValue = function (sRepetition) {
        if (gThis.m_jField == undefined) {
            return '';
        }
    };

    gThis.SetValue = function (mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
    };

    gThis._OnSelect = function (gDg, sId) {
        gThis._InitVariantEditor(sId, gDg.GetRow(sId));
    };

    gThis._OnDeselect = function (gDg, sId) {
        gThis.SaveVariant();
        gThis.m_sEditedVariant = GCore.NULL;
        gThis.m_jVariantEditor.empty();
        gThis.m_jVariantEditorOptions.find('.save').fadeOut(150);
    };

    gThis._UpdatePrice = function (sModifier, fModifierValue) {
        if (sModifier == undefined) {
            sModifier = $('#' + gThis.GetId() + '__modifier_type option:selected').text();
        }
        if (fModifierValue == undefined) {
            fModifierValue = parseFloat($('#' + gThis.GetId() + '__modifier_value').val().replace(/,/, '.'));
        }
        else {
            fModifierValue = parseFloat(('' + fModifierValue).replace(/,/, '.'));
        }
        var fBasePrice = parseFloat(gThis.m_gForm.GetField(gThis.m_oOptions.sPriceField).GetValue().replace(/,/, '.'));
        fModifierValue = isNaN(fModifierValue) ? 0 : fModifierValue;
        fBasePrice = isNaN(fBasePrice) ? 0 : fBasePrice;
        var fPrice = 0;
        switch (sModifier) {
            case '%':
                fPrice = fBasePrice * (fModifierValue / 100);
                break;
            case '+':
                fPrice = fBasePrice + fModifierValue;
                break;
            case '-':
                fPrice = fBasePrice - fModifierValue;
                break;
            case '=':
                fPrice = fModifierValue;
                break;
        }
        $('#' + gThis.GetId() + '__net_price').val(fPrice.toFixed(4)).attr("disabled", "disabled");
        var iVatId = parseInt(gThis.m_gForm.GetField(gThis.m_oOptions.sVatField).m_jNode.find('option:selected').val());
        var fVatValue = 0;
        if (gThis.m_oOptions.aoVatValues[iVatId] != undefined) {
            fVatValue = parseFloat(gThis.m_oOptions.aoVatValues[iVatId]);
        }
        fVatValue = isNaN(fVatValue) ? 0 : fVatValue;
        var fGrossPrice = fPrice * (1 + fVatValue / 100);
        $('#' + gThis.GetId() + '__gross_price').val(fGrossPrice.toFixed(4)).attr("disabled", "disabled");
    };

    gThis._UpdateModifierValue = function (fPrice) {
        var sModifier = $('#' + gThis.GetId() + '__modifier_type option:selected').text();
        if (fPrice == undefined) {
            fPrice = parseFloat($('#' + gThis.GetId() + '__net_price').val().replace(/,/, '.'));
        }
        else {
            fPrice = parseFloat(('' + fPrice).replace(/,/, '.'));
        }
        var fBasePrice = parseFloat(gThis.m_gForm.GetField(gThis.m_oOptions.sPriceField).GetValue().replace(/,/, '.'));
        fPrice = isNaN(fPrice) ? 0 : fPrice;
        fBasePrice = isNaN(fBasePrice) ? 0 : fBasePrice;
        var fModifierValue = 0;
        if (fBasePrice > 0) {
            switch (sModifier) {
                case '%':
                    fModifierValue = (fPrice / fBasePrice) * 100;
                    break;
                case '+':
                    fModifierValue = fPrice - fBasePrice;
                    break;
                case '-':
                    fModifierValue = fBasePrice - fPrice;
                    break;
                case '=':
                    fModifierValue = fPrice;
                    break;
            }
        }
        $('#' + gThis.GetId() + '__modifier_value').val(fModifierValue.toFixed(4));
    };


    gThis.Validation = GEventHandler(function (eEvent) {
        var fValue = parseFloat($(eEvent.currentTarget).val().replace(/,/, '.'));
        if (isNaN(fValue) || fValue < 0) {
            fValue = 0;
        }
        $(eEvent.currentTarget).val(fValue.toFixed(4));
    });

    gThis._InitVariantEditor = function (sId, oVariant) {
        if (oVariant == undefined) {
            oVariant = gThis._GetDefaultVariant(sId);
        }
        gThis.m_sEditedVariant = sId;
        gThis.m_jVariantEditorOptions.find('.save').fadeIn(150);
        gThis.m_jVariantEditor.empty().css('display', 'none');

        var jSpecification = $('<div class="specification"/>');

        gThis.m_jVariantEditor.append(jSpecification);

        var fBasePrice = parseFloat(gThis.m_gForm.GetField(gThis.m_oOptions.sPriceField).GetValue().replace(/,/, '.'));
        fBasePrice = isNaN(fBasePrice) ? 0 : fBasePrice;
        var jBasePrice = $('<input type="text" disabled="disabled" value="' + fBasePrice.toFixed(4) + '"/>').css('cursor', 'default');
        jSpecification.append($('<div class="field-text"/>').append('<label>' + GForm.Language.product_variants_editor_variant_editor_base_net_price + '</label>').append($('<span class="field"/>').append(jBasePrice)));

        var iVatId = parseInt(gThis.m_gForm.GetField(gThis.m_oOptions.sVatField).m_jNode.find('option:selected').val());
        var fVatValue = 0;
        if (gThis.m_oOptions.aoVatValues[iVatId] != undefined) {
            fVatValue = parseFloat(gThis.m_oOptions.aoVatValues[iVatId]);
        }
        var fGrossPrice = fBasePrice * (1 + fVatValue / 100);
        var jBaseGrossPrice = $('<input type="text" disabled="disabled" value="' + fGrossPrice.toFixed(4) + '"/>').css('cursor', 'default');
        jSpecification.append($('<div class="field-text"/>').append('<label>' + GForm.Language.product_variants_editor_variant_editor_base_gross_price + '</label>').append($('<span class="field"/>').append(jBaseGrossPrice)));

        var jModifierType = $('<select id="' + gThis.GetId() + '__modifier_type"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        for (var i = 0; i < gThis.m_oOptions.aoSuffixes.length; i++) {
            jModifierType.append('<option' + ((gThis.m_oOptions.aoSuffixes[i] == oVariant.modifier_type) ? ' selected="selected"' : '') + ' value="' + gThis.m_oOptions.aoSuffixes[i] + '">' + gThis.m_oOptions.aoSuffixes[i] + '</option>');
        }
        jSpecification.append($('<div class="field-select"/>').append('<label for="' + gThis.GetId() + '__modifier_type">' + GForm.Language.product_variants_editor_variant_editor_modifier_type + '</label>').append($('<span class="field"/>').append(jModifierType)));
        jModifierType.GSelect();
        jModifierType.change(GEventHandler(function (eEvent) {
            gThis._UpdatePrice();
        }));

        var jModifierValue = $('<input type="text" id="' + gThis.GetId() + '__modifier_value"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        jSpecification.append($('<div class="field-text"/>').append('<label for="' + gThis.GetId() + '__modifier_value">' + GForm.Language.product_variants_editor_variant_editor_modifier_value + '</label>').append($('<span class="field"/>').append(jModifierValue)));

        var fHandler = GEventHandler(function (eEvent) {
            if (eEvent.keyCode == 13) {
                eEvent.preventDefault();
                eEvent.stopImmediatePropagation();
                gThis.SaveVariant();
            }
            setTimeout(function () {
                gThis._UpdatePrice(undefined, $(eEvent.currentTarget).val());
            }, 5);
        });

        jModifierValue.val(oVariant.modifier_value).keypress(fHandler).blur(fHandler).blur(gThis.Validation);

        var jPrice = $('<input type="text" id="' + gThis.GetId() + '__net_price"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        jSpecification.append($('<div class="field-text"/>').append('<label for="' + gThis.GetId() + '__price">' + GForm.Language.product_variants_editor_variant_editor_net_price + '</label>').append($('<span class="field"/>').append(jPrice)));

        var jGrossPrice = $('<input type="text" id="' + gThis.GetId() + '__gross_price"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        jSpecification.append($('<div class="field-text"/>').append('<label for="' + gThis.GetId() + '__price">' + GForm.Language.product_variants_editor_variant_editor_gross_price + '</label>').append($('<span class="field"/>').append(jGrossPrice)));

        fHandler = GEventHandler(function (eEvent) {
            if (eEvent.keyCode == 13) {
                eEvent.preventDefault();
                eEvent.stopImmediatePropagation();
                gThis.SaveVariant();
            }
            setTimeout(function () {
                var fNetPrice = parseFloat($(eEvent.currentTarget).val().replace(/,/, '.'));
                fNetPrice = isNaN(fNetPrice) ? 0 : fNetPrice;
                var iVatId = parseInt(gThis.m_gForm.GetField(gThis.m_oOptions.sVatField).m_jNode.find('option:selected').val());
                var fVatValue = 0;
                if (gThis.m_oOptions.aoVatValues[iVatId] != undefined) {
                    fVatValue = parseFloat(gThis.m_oOptions.aoVatValues[iVatId]);
                }
                fVatValue = isNaN(fVatValue) ? 0 : fVatValue;
                var fGrossPrice = fNetPrice * (1 + fVatValue / 100);
                jGrossPrice.val(fGrossPrice.toFixed(4));
                gThis._UpdateModifierValue(fNetPrice);
            }, 5);
        });
        jPrice.keypress(fHandler).blur(fHandler).blur(gThis.Validation);

        fHandler = GEventHandler(function (eEvent) {
            if (eEvent.keyCode == 13) {
                eEvent.preventDefault();
                eEvent.stopImmediatePropagation();
                gThis.SaveVariant();
            }
            setTimeout(function () {
                var fGrossPrice = parseFloat($(eEvent.currentTarget).val().replace(/,/, '.'));
                fGrossPrice = isNaN(fGrossPrice) ? 0 : fGrossPrice;
                var iVatId = parseInt(gThis.m_gForm.GetField(gThis.m_oOptions.sVatField).m_jNode.find('option:selected').val());
                var fVatValue = 0;
                if (gThis.m_oOptions.aoVatValues[iVatId] != undefined) {
                    fVatValue = parseFloat(gThis.m_oOptions.aoVatValues[iVatId]);
                }
                fVatValue = isNaN(fVatValue) ? 0 : fVatValue;
                var fNetPrice = fGrossPrice / (1 + fVatValue / 100);
                jPrice.val(fNetPrice.toFixed(4));
                gThis._UpdateModifierValue(fNetPrice);
            }, 5);
        });

        jGrossPrice.keypress(fHandler).blur(fHandler).blur(gThis.Validation);

        var jStock = $('<input type="text" id="' + gThis.GetId() + '__stock"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        jSpecification.append($('<div class="field-text"/>').append('<label for="' + gThis.GetId() + '__stock">' + GForm.Language.product_variants_editor_variant_editor_stock + '</label>').append($('<span class="field"/>').append(jStock)));
        jStock.val(oVariant.stock);

        jStock.keypress(function (eEvent) {
            if (eEvent.keyCode == 13) {
                eEvent.preventDefault();
                eEvent.stopImmediatePropagation();
                gThis.SaveVariant();
            }
        });

        var jSymbol = $('<input type="text" id="' + gThis.GetId() + '__symbol"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });

        jSpecification.append($('<div class="field-text"/>').append('<label for="' + gThis.GetId() + '__symbol">Symbol</label>').append($('<span class="field"/>').append(jSymbol)));
        jSymbol.val(oVariant.symbol);

        jSymbol.keypress(function (eEvent) {
            if (eEvent.keyCode == 13) {
                eEvent.preventDefault();
                eEvent.stopImmediatePropagation();
                gThis.SaveVariant();
            }
        });

        var jDeletable = $('<input type="hidden" id="' + gThis.GetId() + '__deletable"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        jSpecification.append(jDeletable);
        jDeletable.val(oVariant.deletable);

        var jStatusType = $('<select id="' + gThis.GetId() + '__status"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        jStatusType.append('<option' + ((1 == oVariant.status) ? ' selected="selected"' : '') + ' value="' + 1 + '">Aktywny</option>');
        jStatusType.append('<option' + ((0 == oVariant.status) ? ' selected="selected"' : '') + ' value="' + 0 + '">Nieaktywny</option>');
        jSpecification.append($('<div class="field-select"/>').append('<label for="' + gThis.GetId() + '__status">Status</label>').append($('<span class="field"/>').append(jStatusType)));
        jStatusType.GSelect();

        var jAvailability = $('<select id="' + gThis.GetId() + '__availability"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        for (var i in gThis.m_oOptions.aoAvailability) {
            jAvailability.append('<option' + ((i == oVariant.availability) ? ' selected="selected"' : '') + ' value="' + i + '">' + gThis.m_oOptions.aoAvailability[i] + '</option>');
        }
        jSpecification.append($('<div class="field-select"/>').append('<label for="' + gThis.GetId() + '__status">Dostępność</label>').append($('<span class="field"/>').append(jAvailability)));
        jAvailability.GSelect();

        var jWeight = $('<input type="text" id="' + gThis.GetId() + '__weight"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        jSpecification.append($('<div class="field-text"/>').append('<label for="' + gThis.GetId() + '__weight">Waga</label>').append($('<span class="field"/>').append(jWeight)));
        jWeight.val(oVariant.weight);

        jWeight.keypress(function (eEvent) {
            if (eEvent.keyCode == 13) {
                eEvent.preventDefault();
                eEvent.stopImmediatePropagation();
                gThis.SaveVariant();
            }
        });

        var jPhoto = $('<div class="attribute-photos" />');
        jPhoto.append('<h3>Choose photo</h3><input type="hidden" id="' + gThis.GetId() + '__photo" value="' + oVariant.photo + '" />');
        for (var i = 0; i < gThis.m_oOptions.aoPhotos.length; i++) {
            jPhoto.append('<img' + ((gThis.m_oOptions.aoPhotos[i].id == oVariant.photo) ? ' class="selected"' : '') + ' id="' + gThis.m_oOptions.aoPhotos[i].id + '" src="' + gThis.m_oOptions.aoPhotos[i].thumb + '" />');
        }
        jSpecification.append(jPhoto);

        jPhoto.find('img').click(function () {
            if ($(this).hasClass('selected')) {
                jPhoto.find('img').removeClass('selected');
                var photoid = 0;
            } else {
                jPhoto.find('img').removeClass('selected');
                $(this).addClass('selected');
                var photoid = $(this).attr('id');
            }
            $('#' + gThis.GetId() + '__photo').val(photoid);
        });

        var asExistingAttributes = [];
        var jAttributes = $('<ul class="attributes"/>');
        for (var i in oVariant) {
            if (i.substr(0, 10) != 'attribute_') {
                continue;
            }
            asExistingAttributes.push(i.substr(10));
            jAttributes.append(gThis.AddEditorAttribute(i.substr(10), oVariant[i]));
        }

        var jNew = gThis._GetNewAttributeSelector(asExistingAttributes);
        if (jNew != GCore.NULL) {
            jAttributes.append(jNew);
        }

        gThis.m_jVariantEditor.append(jAttributes);

        gThis.m_jVariantEditor.slideDown(200);
        gThis._UpdatePrice();
    };

    gThis._GetNewAttributeSelector = function (asExistingAttributes) {
        var jLi = $('<li class="field-select new"/>');
        var jSelect = $('<select id="' + gThis.GetId() + '__attribute_new"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });

        jSelect.append('<option value="">' + GForm.Language.product_variants_editor_choose_attribute + '</option>');
        var j = 0;
        for (var i = 0; i < gThis.m_aoAttributes.length; i++) {
            if ($.inArray(gThis.m_aoAttributes[i].id, asExistingAttributes) != -1) {
                continue;
            }
            jSelect.append('<option value="' + gThis.m_aoAttributes[i].id + '">' + gThis.m_aoAttributes[i].name + '</option>');
            j++;
        }
        if (j == 0) {
            return GCore.NULL;
        }
        jLi.append($('<span class="field"/>').append(jSelect));
        jSelect.GSelect();
        jSelect.change(function () {
            var sAttributeId = $(this).find('option:selected').attr('value');
            var sAttributeName = $(this).find('option:selected').text();
            if (sAttributeId == '') {
                return;
            }
            $(this).closest('ul').append(gThis.AddEditorAttribute(sAttributeId));
            var asExistingAttributes = gThis._MakeExistingAttributesList($(this));
            var jNew = gThis._GetNewAttributeSelector(asExistingAttributes);
            if (jNew != GCore.NULL) {
                $(this).closest('ul').append(jNew);
            }
            $(this).closest('li').remove();
        });
        return jLi;
    };

    gThis._MakeExistingAttributesList = function (jContext) {
        var asExistingAttributes = [];
        var jSelects = jContext.closest('ul').find('li select[name^="attribute_"]');
        for (var i = 0; i < jSelects.length; i++) {
            asExistingAttributes.push(jSelects.eq(i).attr('name').substr(10));
        }
        return asExistingAttributes;
    };

    gThis.AddEditorAttribute = function (sAttributeId, sValue) {
        var sAttributeName = '';
        for (var i in gThis.m_aoAttributes) {
            if (gThis.m_aoAttributes[i].id == sAttributeId) {
                sAttributeName = gThis.m_aoAttributes[i].name;
                aoValues = gThis.m_aoAttributes[i].values;
            }
        }
        var jLi = $('<li class="field-select"/>');
        var jSelect = $('<select id="' + gThis.GetId() + '__attribute_' + sAttributeId + '" name="attribute_' + sAttributeId + '"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });

        for (var i = 0; i < aoValues.length; i++) {
            jSelect.append('<option' + ((aoValues[i].name == sValue) ? ' selected="selected"' : '') + ' value="' + aoValues[i].id + '">' + aoValues[i].name + '</option>');
        }
        jLi.append('<label for="' + gThis.GetId() + '__attribute_' + sAttributeId + '">' + sAttributeName + '</label>');
        jLi.append($('<span class="field"/>').append(jSelect));
        jSelect.GSelect();

        var jDelete = $('<a href="#" class="delete"/>');
        jDelete.click(function () {
            var jUl = $(this).closest('ul');
            jUl.children('.new').remove();
            $(this).closest('li').remove();
            var asExistingAttributes = gThis._MakeExistingAttributesList(jUl);
            var jNew = gThis._GetNewAttributeSelector(asExistingAttributes);
            if (jNew != GCore.NULL) {
                jUl.append(jNew);
            }
            return false;
        });
        jLi.append(jDelete.append('<img src="' + gThis._GetImage('DeleteIcon') + '" alt=""/>'));

        return jLi;
    };


    gThis.AddVariant = function (oVariant) {
        if (oVariant == undefined) {
            var sId = 'new-' + gThis.m_sRepetitionCounter++;
            gThis.m_gDataProvider.AddRow(gThis._GetDefaultVariant(sId));
        }

        return sId;
    };

    gThis.SaveVariant = function () {
        if (gThis.m_sEditedVariant == GCore.NULL) {
            return;
        }

        var modifierField = $('#' + gThis.GetId() + '__modifier_type option:selected');

        var oRow = {
            idvariant: gThis.m_sEditedVariant,
            modifier_type: modifierField.text(),
            modifier_type_id: modifierField.attr('value'),
            modifier_value: $('#' + gThis.GetId() + '__modifier_value').val(),
            photo: $('#' + gThis.GetId() + '__photo').val(),
            availability: $('#' + gThis.GetId() + '__availability').val(),
            stock: $('#' + gThis.GetId() + '__stock').val().replace(/,/, '.'),
            symbol: $('#' + gThis.GetId() + '__symbol').val(),
            status: $('#' + gThis.GetId() + '__status').val(),
            weight: $('#' + gThis.GetId() + '__weight').val().replace(/,/, '.'),
        };

        var jSelects = gThis.m_jVariantEditor.find('.attributes li select[name^="attribute_"]');
        for (var i = 0; i < jSelects.length; i++) {
            var sAttributeId = jSelects.eq(i).attr('name').substr(10);
            var sValueId = jSelects.eq(i).find('option:selected').attr('value');
            var sValueName = jSelects.eq(i).find('option:selected').text();
            oRow['attribute_' + sAttributeId] = sValueName;
            oRow['attributeid_' + sAttributeId] = sValueId;
        }
        gThis.m_gDataProvider.UpdateRow(gThis.m_sEditedVariant, oRow);
        gThis.m_gDatagrid.LoadData();
    };

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));

        gThis.m_jField = $('<div/>');

        gThis._PrepareSetSelect();
        gThis._PrepareSetEditor();

        gThis.m_jDatagrid = $('<div/>');
        gThis.m_jNode.append(gThis.m_jDatagrid);
        gThis.m_jNode.append(gThis.m_jField);

    };

    gThis._PrepareVariantEditor = function () {
        gThis.m_jVariantEditor = $('<div class="variant-editor"/>');
        gThis.m_jVariantEditorWrapper = $('<div class="variant"/>');
        gThis.m_jVariantEditorWrapper.css('display', 'none');
        gThis.m_jVariantEditorWrapper.append(gThis.m_jVariantEditor);
        gThis.m_jVariantEditorOptions = $('<ul class="options"/>');
        gThis.m_jVariantEditorWrapper.append(gThis.m_jVariantEditorOptions);
        var jAdd = $('<a class="add button" href="#"/>');
        jAdd.append('<span><img src="' + gThis._GetImage('AddIcon') + '" alt=""/>' + GForm.Language.product_variants_editor_add_variant + '</span>');
        var jSave = $('<a class="save button" href="#"/>');
        jSave.append('<span><img src="' + gThis._GetImage('SaveIcon') + '" alt=""/>' + GForm.Language.product_variants_editor_save_variant + '</span>');
        var jGenerate = $('<a class="add button" href="#"/>');
        jGenerate.append('<span><img src="' + gThis._GetImage('AddIcon') + '" alt=""/>Generuj automatycznie</span>');
        if (gThis.m_oOptions.bAllowGenerate == 1) {
            gThis.m_jVariantEditorOptions.append($('<li/>').append(jGenerate));
        }
        gThis.m_jVariantEditorOptions.append($('<li/>').append(jAdd));
        gThis.m_jVariantEditorOptions.append($('<li/>').append(jSave));
        gThis.m_jNode.append(gThis.m_jVariantEditorWrapper);

        jAdd.click(GEventHandler(function (eEvent) {
            var sId = gThis.AddVariant();
            gThis.m_gDatagrid.m_asSelected = [sId];
            gThis.SaveVariant();
            gThis._InitVariantEditor(sId);
            return false;
        }));

        jSave.click(GEventHandler(function (eEvent) {
            gThis.SaveVariant();
            return false;
        })).css('display', 'none');

        jGenerate.click(GEventHandler(function () {
            var aoAttributes = [];
            $(".generate:checked").each(function () {
                aoAttributes.push(this.value);
            });
            if (aoAttributes.length) {
                if (gThis.m_aoVariants.length > 0) {
                    var title = 'Automatyczne wygenerowanie wariantów';
                    var msg = 'Wybranie tej opcji usunie wszystkie dotychczasowe dotychczasowe warianty i wygeneruje kombinacje na nowo. Czy jesteś pewien ?';
                    var params = {};
                    var func = function (p) {
                        gThis.m_gDataProvider.ChangeData();
                        gThis.m_gDatagrid.LoadData();
                        gThis._GenerateCartesian(aoAttributes);
                    };
                    new GF_Alert(title, msg, func, true, params);
                } else {
                    gThis._GenerateCartesian(aoAttributes);
                }
            } else {
                GError('Nie wybrano cech', 'Aby wygenerować automatycznie warianty musisz wybrać cechy zaznaczając checkbox obok ich nazwy.');
            }
            return false;
        }));
    };

    gThis._GenerateCartesian = function (aoAttributes) {
        var sSetId = $('#variants_pane__variants__set').find('option:selected').val();
        gThis.m_oOptions.fGetCartesian({
            setid: sSetId,
            ids: aoAttributes
        }, GCallback(gThis._OnVariantsGenerated));
    };

    gThis._OnVariantsGenerated = GEventHandler(function (eEvent) {

        $.each(eEvent.variants, function (k, key) {
            var sId = 'new-' + gThis.m_sRepetitionCounter++;
            var oRow = {
                idvariant: sId,
                modifier_type: '%',
                modifier_type_id: 1,
                modifier_value: 100,
                stock: 0,
                photo: 0,
                availability: 0,
                symbol: '',
                status: 1,
                deletable: 1,
                weight: 0
            };
            $.each(key, function (a, attribute) {
                oRow['attribute_' + attribute.sAttributeId] = attribute.sValueName;
                oRow['attributeid_' + attribute.sAttributeId] = attribute.sValueId;
            });
            gThis.m_gDataProvider.AddRow(oRow);
            gThis.m_gDatagrid.m_asSelected = [sId];
        });
        gThis.m_gDatagrid.LoadData();
        gThis.Update();
    });

    gThis._PrepareSetSelect = function () {
        jSetSelectField = $('<div class="field-select"/>');
        jSetSelectField.append('<label for="' + gThis.GetId() + '__set">' + GForm.Language.product_variants_editor_set_for_this_product + ' <small>' + GForm.Language.product_variants_editor_set_for_this_product_suffix + '</small></label>');
        gThis.m_jSetSelectNode = $('<span class="repetition"/>');
        jSetSelectField.append(gThis.m_jSetSelectNode);
        gThis._CreateSetSelectNode([]);
        gThis.m_jNode.append(jSetSelectField);
    };

    gThis._CreateSetSelectNode = function (aoOptions) {
        gThis.m_jSetSelect = $('<select id="' + gThis.GetId() + '__set" name="' + gThis.GetName() + '[set]"/>');
        gThis.m_jSetSelectNode.empty().append($('<span class="field"/>').append(gThis.m_jSetSelect));
        for (var i = 0; i < aoOptions.length; i++) {
            gThis.m_jSetSelect.append('<option' + ((aoOptions[i].id == gThis.m_oOptions.sSet) ? ' selected="selected"' : '') + ' value="' + aoOptions[i].id + '"' + (aoOptions[i].current_category ? ' class="strong"' : '') + '>' + aoOptions[i].name + '</option>');
        }
    };

    gThis.LoadSets = function () {
        gThis.m_jSetEditorLabel.css('display', 'none');
        gThis.m_jSetEditor.add(gThis.m_jDatagrid).add(gThis.m_jVariantEditorWrapper).animate({
            opacity: 0
        }, 250);
        var jWaiting = $('<span class="' + gThis._GetClass('Waiting') + '"/>');
        gThis.m_jSetSelect.closest('.' + gThis._GetClass('FieldSpan')).parent().find('.' + gThis._GetClass('Waiting')).remove();
        gThis.m_jSetSelect.closest('.' + gThis._GetClass('FieldSpan')).parent().append(jWaiting);
        jWaiting.css('display', 'none').fadeIn(250);
        var jCategories = $(gThis.m_gForm).find('input[name*="[' + gThis.m_oOptions.sCategoryField + '][]"]');
        var asCategories = [];
        for (var i = 0; i < jCategories.length; i++) {
            asCategories.push(jCategories.eq(i).val());
        }

        GF_Ajax_Request(Routing.generate(gThis.m_oOptions.sGetGroupsRoute), {
            'categories': asCategories
        }, gThis.OnSetsLoaded);
    };

    gThis.OnSetsLoaded = GEventHandler(function (eEvent) {
        gThis.m_aoSets = eEvent.sets;
        gThis.ReplaceSetSelect();
        gThis.m_jSetEditorLabel.fadeIn(250);
    });

    gThis.ReplaceSetSelect = function () {
        gThis._CreateSetSelectNode(gThis.m_aoSets);
        gThis.m_jSetSelect.GSelect();
        gThis.m_jSetSelect.closest('.' + gThis._GetClass('FieldSpan')).parent().find('.' + gThis._GetClass('Waiting')).fadeOut(250, function () {
            $(this).remove();
        });
        gThis.m_jSetSelect.change(GEventHandler(function () {
            gThis.LoadAttributes();
        })).change();
    };

    gThis._PrepareSetEditor = function () {
        gThis.m_jSetEditor = $('<ul class="set-editor"/>');
        gThis.m_jSetEditor.css('display', 'none');
        gThis.m_jSetEditorLabel = $('<h3/>');
        gThis.m_jSetEditorLabel.append('<span>' + GForm.Language.product_variants_editor_availble_attributes + '</span>');
        gThis.m_jSetEditorLabel.css('display', 'none');
        gThis.m_jNode.append(gThis.m_jSetEditorLabel);
        gThis.m_jNode.append(gThis.m_jSetEditor);
    };

    gThis.ReplaceSetEditor = function () {
        gThis.m_jSetEditor.empty();
        for (var i = 0; i < gThis.m_aoAttributes.length; i++) {
            var jAttribute = $('<li/>');
            jAttribute.append('<h4>' + gThis.m_aoAttributes[i].name + '</h4>');
            var jUl = $('<ul/>');
            for (var j = 0; j < gThis.m_aoAttributes[i].values.length; j++) {
                var oValue = gThis.m_aoAttributes[i].values[j];
                var jValue = $('<li><input type="checkbox" class="generate" value="' + oValue.id + '" /> ' + oValue.name + '</li>');
                jUl.append(jValue);
            }
            var jSaveValue = $('<a class="save" href="#"/>').append('<img src="' + gThis._GetImage('SaveIcon') + '" alt="' + GForm.Language.product_variants_editor_save_value + '" title="' + GForm.Language.product_variants_editor_save_value + '"/>');
            var jValueField = $('<input class="value" type="text"/>').focus(function () {
                $(this).closest('.field').addClass('focus');
            }).blur(function () {
                $(this).closest('.field').removeClass('focus');
            });
            jValueField.bind('keydown', function (eEvent) {
                if (eEvent.keyCode == 13) {
                    eEvent.stopImmediatePropagation();
                    eEvent.preventDefault();
                    $(this).closest('li').find('.save').trigger('click');
                }
            });
            jValueField.get(0).sAttributeId = gThis.m_aoAttributes[i].id;
            var jValueFieldWrapper = $('<span class="field-text"/>').append($('<span class="field">').append(jValueField)).hide();
            var jAddValue = $('<a class="add" href="#"/>').append('<img src="' + gThis._GetImage('AddIcon') + '" alt="' + GForm.Language.product_variants_editor_add_value + '" title="' + GForm.Language.product_variants_editor_add_value + '"/>');
            jAddValue.click(function () {
                $(this).closest('li').find('.add').hide();
                $(this).closest('li').find('.field-text').show();
                $(this).closest('li').find('.save').show();
                $(this).closest('li').find('.value').focus();
                return false;
            });
            jSaveValue.click(function () {
                var sValue = $(this).closest('li').find('.value').val();
                if ((sValue != undefined) && sValue.length) {
                    gThis.AddValue(sValue, $(this).closest('li').find('.value').get(0).sAttributeId, gThis.m_jSetSelect.find('option:selected').attr('value'));
                }
                $(this).closest('li').find('.value').val('');
                $(this).closest('li').find('.field-text').hide();
                $(this).closest('li').find('.save').hide();
                $(this).closest('li').find('.add').show();
                $(this).closest('li').find('.add').focus();
                return false;
            }).hide();
            jUl.append($('<li class="new"/>').append(jAddValue).append(jValueFieldWrapper).append(jSaveValue));
            jAttribute.append(jUl);
            gThis.m_jSetEditor.append(jAttribute);
        }
        var jSaveAttribute = $('<a class="save" href="#"/>').append('<img src="' + gThis._GetImage('SaveIcon') + '" alt="' + GForm.Language.product_variants_editor_save_attribute + '" title="' + GForm.Language.product_variants_editor_save_attribute + '"/>');
        var jAttributeField = $('<input class="attribute" type="text"/>').focus(function () {
            $(this).closest('.field').addClass('focus');
        }).blur(function () {
            $(this).closest('.field').removeClass('focus');
        });
        jAttributeField.bind('keydown', function (eEvent) {
            if (eEvent.keyCode == 13) {
                eEvent.stopImmediatePropagation();
                eEvent.preventDefault();
                $(this).closest('h4').find('.save').trigger('click');
            }
        });
        var jAttributeFieldWrapper = $('<span class="field-text"/>').append($('<span class="field">').append(jAttributeField)).hide();
        var jAddAttribute = $('<a class="add" href="#"/>').append('<img src="' + gThis._GetImage('AddIcon') + '" alt="' + GForm.Language.product_variants_editor_add_attribute + '" title="' + GForm.Language.product_variants_editor_add_attribute + '"/>');
        jAddAttribute.click(function () {
            $(this).closest('h4').find('.add').hide();
            $(this).closest('h4').find('.field-text').show();
            $(this).closest('h4').find('.save').show();
            $(this).closest('h4').find('.attribute').focus();
            return false;
        });
        jSaveAttribute.click(function () {
            var sAttribute = $(this).closest('h4').find('.attribute').val();
            if ((sAttribute != undefined) && sAttribute.length) {
                gThis.AddAttribute(sAttribute, gThis.m_jSetSelect.find('option:selected').attr('value'));
            }
            $(this).closest('h4').find('.attribute').val('');
            $(this).closest('h4').find('.field-text').hide();
            $(this).closest('h4').find('.save').hide();
            $(this).closest('h4').find('.add').show();
            $(this).closest('h4').find('.add').focus();
            return false;
        }).hide();
        gThis.m_jSetEditor.append($('<li/>').append($('<h4/>').append(jAddAttribute).append(jAttributeFieldWrapper).append(jSaveAttribute)));
    };

    gThis.AddAttribute = function (sAttribute, sSet) {
        gThis.m_jSetEditor.animate({opacity: .5}, 250);
        gThis.m_jDatagrid.animate({opacity: .5}, 250);
        gThis.m_jVariantEditorWrapper.animate({opacity: .5}, 250);
        (!gThis.m_jSetEditorLabel.find('.' + gThis._GetClass('Waiting')).length) && gThis.m_jSetEditorLabel.append($('<span class="' + gThis._GetClass('Waiting') + '"/>').css('display', 'none').fadeIn(150));
        GF_Ajax_Request(Routing.generate(gThis.m_oOptions.sAddAttributeRoute), {
            name: sAttribute,
            set: sSet
        }, gThis.OnAttributeAdded);
    };

    gThis.OnAttributeAdded = GEventHandler(function (eEvent) {
        gThis.LoadAttributes();
    });

    gThis.AddValue = function (sValue, sAttribute, sSet) {
        gThis.m_jSetEditor.animate({opacity: .5}, 250);
        gThis.m_jDatagrid.animate({opacity: .5}, 250);
        gThis.m_jVariantEditorWrapper.animate({opacity: .5}, 250);
        (!gThis.m_jSetEditorLabel.find('.' + gThis._GetClass('Waiting')).length) && gThis.m_jSetEditorLabel.append($('<span class="' + gThis._GetClass('Waiting') + '"/>').css('display', 'none').fadeIn(150));
        GF_Ajax_Request(Routing.generate(gThis.m_oOptions.sAddAttributeValueRoute), {
            name: sValue,
            attribute: sAttribute,
            set: sSet
        }, gThis.OnValueAdded);
    };

    gThis.OnValueAdded = GEventHandler(function () {
        gThis.LoadAttributes();
    });

    gThis.LoadAttributes = function () {
        gThis.m_jSetEditor.animate({opacity: .5}, 250);
        gThis.m_jDatagrid.animate({opacity: .5}, 250);
        gThis.m_jVariantEditorWrapper.animate({opacity: .5}, 250);
        (!gThis.m_jSetEditorLabel.find('.' + gThis._GetClass('Waiting')).length) && gThis.m_jSetEditorLabel.append($('<span class="' + gThis._GetClass('Waiting') + '"/>').css('display', 'none').fadeIn(150));
        var sSetId = gThis.m_jSetSelect.find('option:selected').attr('value');
        GF_Ajax_Request(Routing.generate(gThis.m_oOptions.sGetAttributesRoute), {
            id: sSetId
        }, gThis.OnAttributesLoaded);
    };

    gThis.OnAttributesLoaded = new GEventHandler(function (eEvent) {
        gThis.m_aoAttributes = eEvent.attributes;
        if (gThis.m_mDataToPopulate != undefined) {
            gThis.Populate(gThis.m_mDataToPopulate);
            delete gThis.m_mDataToPopulate;
        }
        gThis.ReplaceSetEditor();
        gThis._InitDatagrid();
        gThis.m_jSetEditorLabel.find('.' + gThis._GetClass('Waiting')).fadeOut(150, function () {
            $(this).remove();
        });
        gThis.m_jSetEditor.slideDown(250);
        gThis.m_jVariantEditorWrapper.slideDown(250);
        gThis.m_jSetEditor.animate({opacity: 1}, 250);
        gThis.m_jDatagrid.animate({opacity: 1}, 250);
        gThis.m_jVariantEditorWrapper.animate({opacity: 1}, 250);
    });

    gThis.OnReset = function () {
        gThis.m_bFirstLoad = true;
    };

    gThis.Populate = function (mValue) {
        if (mValue instanceof Object) {
            if (!gThis.m_aoAttributes.length) {
                gThis.m_mDataToPopulate = mValue;
            }
            var aoData = [];
            for (var i in mValue) {
                var sSuffixSymbol = '%';
                for (var j in gThis.m_oOptions.aoSuffixes) {
                    if (gThis.m_oOptions.aoSuffixes[j].id == mValue[i].suffix) {
                        sSuffixSymbol = gThis.m_oOptions.aoSuffixes[j].symbol;
                    }
                }
                var oVariant = {
                    idvariant: mValue[i].idvariant,
                    modifier_type_id: mValue[i].suffix,
                    modifier_type: sSuffixSymbol,
                    modifier_value: mValue[i].modifier,
                    stock: mValue[i].stock,
                    availability: mValue[i].availability,
                    photo: mValue[i].photo,
                    symbol: mValue[i].symbol,
                    status: mValue[i].status,
                    deletable: mValue[i].deletable,
                    weight: mValue[i].weight,
                };
                if (mValue[i]['attributes'] != undefined) {
                    for (var j in mValue[i]['attributes']) {
                        oVariant['attributeid_' + j] = mValue[i]['attributes'][j];
                        for (var k in gThis.m_aoAttributes) {
                            if (gThis.m_aoAttributes[k].id == j) {
                                for (var l in gThis.m_aoAttributes[k]['values']) {
                                    if (gThis.m_aoAttributes[k]['values'][l].id == mValue[i]['attributes'][j]) {
                                        oVariant['attribute_' + j] = gThis.m_aoAttributes[k]['values'][l].name;
                                    }
                                }
                            }
                        }
                    }
                }
                aoData.push(oVariant);
            }
            gThis.m_aoVariants = aoData.slice(0);
            gThis.Update();
        }
        if (!(gThis.m_gDataProvider instanceof GF_Datagrid_Data_Provider)) {
            return;
        }
        gThis.Update();
    };

    gThis.OnShow = function () {
        if (!gThis.m_bShown) {
            gThis._PrepareVariantEditor();
            gThis.Populate(gThis.m_oOptions.asDefaults);
            gThis.m_jSetSelect.GSelect();
            gThis.m_bShown = true;
        }
        else {
            if (gThis.m_gDataProvider instanceof GF_Datagrid_Data_Provider) {
                gThis.m_gDataProvider._ProcessAllRows();
                gThis.m_gDatagrid.LoadData();
            }
        }
        gThis.LoadSets();
    };

    gThis._InitColumns = function (aoAttributeColumns) {

        if (aoAttributeColumns == undefined) {
            aoAttributeColumns = [];
        }

        var column_id = new GF_Datagrid_Column({
            id: 'idvariant',
            caption: GForm.Language.product_variants_editor_id,
            appearance: {
                width: 40,
                visible: false
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var column_deletable = new GF_Datagrid_Column({
            id: 'deletable',
            caption: GForm.Language.product_variants_editor_id,
            appearance: {
                width: 40,
                visible: false
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var column_stock = new GF_Datagrid_Column({
            id: 'stock',
            caption: GForm.Language.product_variants_editor_stock,
            appearance: {
                width: 50
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var column_symbol = new GF_Datagrid_Column({
            id: 'symbol',
            caption: 'Symbol',
            appearance: {
                width: 170
            },
            filter: {
                type: GF_Datagrid.FILTER_INPUT
            }
        });

        var column_status = new GF_Datagrid_Column({
            id: 'status',
            caption: 'Status',
            appearance: {
                width: 40
            },
            filter: {
                type: GF_Datagrid.FILTER_SELECT,
                options: [
                    {id: '', caption: ''},
                    {id: '1', caption: 'Aktywny'},
                    {id: '0', caption: 'Nieaktywny'}
                ],
            }
        });

        var column_weight = new GF_Datagrid_Column({
            id: 'weight',
            caption: 'Waga',
            appearance: {
                width: 60
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var column_modifier = new GF_Datagrid_Column({
            id: 'modifier',
            caption: GForm.Language.product_variants_editor_modifier,
            appearance: {
                width: 70
            }
        });

        var column_price = new GF_Datagrid_Column({
            id: 'price',
            caption: GForm.Language.product_variants_editor_price,
            appearance: {
                width: 70
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var aoColumns = [column_id];
        aoColumns = aoColumns.concat(aoAttributeColumns, [
            column_stock,
            column_symbol,
            column_status,
            column_weight,
            column_modifier,
            column_price,
            column_deletable
        ]);

        return aoColumns;

    };

    gThis.DeleteVariant = function (iDg, mId) {

        if (!(mId instanceof Array)) {
            mId = [mId];
        }
        for (var i = 0; i < mId.length; i++) {
            var oRow = gThis.m_gDataProvider.GetRow(mId);
            if (oRow.deletable == 1) {
                if (mId == gThis.m_sEditedVariant) {
                    gThis.m_sEditedVariant = GCore.NULL;
                    gThis.m_jVariantEditor.empty();
                    gThis.m_jVariantEditorOptions.find('.save').fadeOut(150);
                }
                gThis.m_gDataProvider.DeleteRow(mId[i]);
            } else {
                GError('Nie można skasować wariantu', 'Wybrany wariant występuje w zamówieniach. Możesz go tylko wyłączyć aby nie był wyświetlany w sklepie.');
            }
        }
        gThis.m_gDatagrid.LoadData();
    };

    gThis._GetDefaultVariant = function (sId) {
        var sSuffixId = '';
        for (var i in gThis.m_oOptions.aoSuffixes) {
            if (gThis.m_oOptions.aoSuffixes[i].symbol == '%') {
                sSuffixId = gThis.m_oOptions.aoSuffixes[i].id;
            }
        }
        return {
            idvariant: sId,
            modifier_type: '%',
            modifier_type_id: sSuffixId,
            modifier_value: '100.00',
            stock: '0',
            symbol: '',
            status: 1,
            deletable: 1,
            weight: 0
        }
    };

    gThis.AddVariant = function (oVariant) {
        if (oVariant == undefined) {
            var sId = 'new-' + gThis.m_sRepetitionCounter++;
            gThis.m_gDataProvider.AddRow(gThis._GetDefaultVariant(sId));
        }
        else {
            var sId = oVariant.idvariant;
            gThis.m_gDataProvider.AddRow(oVariant);
        }
        gThis.m_gDatagrid.LoadData();
        return sId;
    };

    gThis.Update = function () {
        gThis.m_jField.empty();
        if (gThis.m_gDataProvider instanceof GF_Datagrid_Data_Provider) {
            gThis.m_aoVariants = gThis.m_gDataProvider.GetData();
        }
        for (var i = 0; i < gThis.m_aoVariants.length; i++) {
            var oVariant = gThis.m_aoVariants[i];
            gThis.m_jField.append('<input value="' + oVariant['modifier_type_id'] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][suffix]" type="hidden"/>');
            gThis.m_jField.append('<input value="' + oVariant['modifier_value'] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][modifier]" type="hidden"/>');
            gThis.m_jField.append('<input value="' + oVariant['stock'] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][stock]" type="hidden"/>');
            gThis.m_jField.append('<input value="' + oVariant['symbol'] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][symbol]" type="hidden"/>');
            gThis.m_jField.append('<input value="' + oVariant['status'] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][status]" type="hidden"/>');
            gThis.m_jField.append('<input value="' + oVariant['deletable'] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][deletable]" type="hidden"/>');
            gThis.m_jField.append('<input value="' + oVariant['weight'] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][weight]" type="hidden"/>');
            gThis.m_jField.append('<input value="' + oVariant['availability'] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][availability]" type="hidden"/>');
            gThis.m_jField.append('<input value="' + oVariant['photo'] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][photo]" type="hidden"/>');
            for (var j in oVariant) {
                if (j.substr(0, 12) != 'attributeid_') {
                    continue;
                }
                gThis.m_jField.append('<input value="' + oVariant[j] + '" name="' + gThis.GetName() + '[' + oVariant.idvariant + '][attributes][' + j.substr(12) + ']" type="hidden"/>');
            }
        }
    };

    gThis._PrepareColumnsFromAttributes = function () {
        var aoColumns = [];
        for (var i = 0; i < gThis.m_aoAttributes.length; i++) {
            var oAttribute = gThis.m_aoAttributes[i];
            var aoValues = [];
            for (var j = 0; j < oAttribute['values'].length; j++) {
                aoValues.push({
                    id: oAttribute['values'][j]['name'],
                    caption: oAttribute['values'][j]['name']
                });
            }
            aoColumns.push(new GF_Datagrid_Column({
                id: 'attribute_' + oAttribute['id'],
                caption: oAttribute['name'],
                appearance: {
                    visible: i < 4
                },
                filter: {
                    type: GF_Datagrid.FILTER_SELECT,
                    options: [
                        {id: '', caption: ''}
                    ].concat(aoValues)
                }
            }));
        }
        return aoColumns;
    };

    gThis.PreProcessVariants = function (oRow) {
        var sBasePrice = $(gThis.m_gForm).find('input[name*="[' + gThis.m_oOptions.sPriceField + ']"]').val();
        var iBasePrice = 0;
        if (!isNaN(parseFloat(sBasePrice)) && (parseFloat(sBasePrice) >= 0)) {
            iBasePrice = parseInt('' + (parseFloat(sBasePrice) * 100));
        }
        oRow.base_price = (iBasePrice / 100).toFixed(4);
        var iPrice = iBasePrice;
        oRow.modifier_value = (!isNaN(parseFloat(oRow.modifier_value))) ? parseFloat(oRow.modifier_value).toFixed(4) : '0.00';
        switch (oRow.modifier_type) {
            case '=':
                if (!isNaN(parseFloat(oRow.modifier_value)) && (parseFloat(oRow.modifier_value) >= 0)) {
                    iPrice = parseInt('' + (parseFloat(oRow.modifier_value) * 100));
                    oRow.modifier = '=' + parseFloat(oRow.modifier_value).toFixed(4);
                }
                break;
            case '%':
                if (!isNaN(parseFloat(oRow.modifier_value))) {
                    iPrice = parseInt('' + (iPrice * (parseFloat(oRow.modifier_value) / 100)));
                    oRow.modifier = parseFloat(oRow.modifier_value).toFixed(4) + '%';
                }
                break;
            case '+':
                if (!isNaN(parseFloat(oRow.modifier_value))) {
                    iPrice += parseInt('' + (parseFloat(oRow.modifier_value) * 100));
                    oRow.modifier = '+' + parseFloat(oRow.modifier_value).toFixed(4);
                }
                break;
            case '-':
                if (!isNaN(parseFloat(oRow.modifier_value))) {
                    iPrice -= parseInt('' + (parseFloat(oRow.modifier_value) * 100));
                    oRow.modifier = '-' + parseFloat(oRow.modifier_value).toFixed(4);
                }
                break;
        }
        var iDifference = iPrice - iBasePrice;
        oRow.price = (iPrice / 100).toFixed(4);
        return oRow;
    };

    gThis.ProcessVariant = function (oRow) {
        oRow.status = (oRow.status == 1) ? 'Aktywny' : 'Nieaktywny';
        return oRow;
    };

    gThis._InitDatagrid = function () {

        gThis.m_jDatagrid.empty().attr('class', '');

        gThis.m_gDataProvider = new GF_Datagrid_Data_Provider({
            key: 'idvariant',
            preProcess: gThis.PreProcessVariants,
            event_handlers: {
                change: GEventHandler(function (rows) {
                    gThis.Update();
                })
            }
        }, gThis.m_aoVariants);

        var aoAttributeColumns = gThis._PrepareColumnsFromAttributes();

        var aoColumns = gThis._InitColumns(aoAttributeColumns);

        var oOptions = {
            id: gThis.GetId() + '_variants',
            mechanics: {
                rows_per_page: 150,
                key: 'idvariant',
                only_one_selected: true,
                persistent: false
            },
            event_handlers: {
                load: GEventHandler(function (oRequest, sResponseHandler) {
                    gThis.m_gDataProvider.Load(oRequest, sResponseHandler);
                }),
                process: gThis.ProcessVariant,
                delete_row: gThis.DeleteVariant,
                delete_group: gThis.DeleteVariant,
                select: gThis._OnSelect,
                deselect: gThis._OnDeselect
            },
            columns: aoColumns,
            row_actions: [
                GF_Datagrid.ACTION_DELETE
            ],
            group_actions: [
                GF_Datagrid.ACTION_DELETE_GROUP
            ]
        };
        gThis.m_gDatagrid = new GF_Datagrid(gThis.m_jDatagrid, oOptions);

        gThis.Update();

    };

}, oDefaults);
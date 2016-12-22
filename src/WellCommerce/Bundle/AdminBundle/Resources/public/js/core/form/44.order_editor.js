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
        sFieldClass: 'field-order-editor',
        sFieldSpanClass: 'field',
        sGroupClass: 'group',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sFieldRepetitionClass: 'repetition',
        sHiddenClass: 'hidden',
        sButtonClass: 'button',
        sTriggerClass: 'trigger'
    },
    oImages: {
        sAddIcon: 'images/icons/buttons/add.png',
        sDeselectIcon: 'images/icons/datagrid/delete.png'
    },
    aoOptions: [],
    sDefault: '',
    aoRules: [],
    sComment: '',
    sLoadProductsRoute: GCore.NULL,
    bAdvancedEditor: false
};

var GFormOrderEditor = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bShown = false;

    gThis.m_sLoadProductsRoute;
    gThis.m_fProcessProduct;
    gThis.m_jDatagrid;
    gThis.m_jSelectedDatagrid;
    gThis.m_jTrigger;
    gThis.m_jTriggerButton;
    gThis.m_gDatagrid;
    gThis.m_gSelectedDatagrid;
    gThis.m_gDataProvider;
    gThis.m_bFirstLoad = true;
    gThis.m_oRequest = {};
    gThis.m_iCounter = 0;

    gThis.GetValue = function (sRepetition) {
        if (gThis.m_jField == undefined) {
            return '';
        }
        var aValues = [];
        var jValues = gThis.m_jField.find('input');
        for (var i = 0; i < jValues.length / 4; i++) {
            aValues.push({
                id: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[id]"]:eq(' + i + ')').val(),
                product_id: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[product_id]"]:eq(' + i + ')').val(),
                quantity: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[quantity]"]:eq(' + i + ')').val(),
                gross_amount: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[gross_amount]"]:eq(' + i + ')').val(),
                variant: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[variant]"]:eq(' + i + ')').val(),
                trackstock: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[trackstock]"]:eq(' + i + ')').val(),
                stock: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[stock]"]:eq(' + i + ')').val(),
                weight: gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '[weight]"]:eq(' + i + ')').val(),
            });
        }

        return aValues;
    };

    gThis.SetValue = function (mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        for (var i in mValue) {
            if (mValue[i]['id'] == undefined) {
                continue;
            }
            gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][id]" value="' + mValue[i]['id'] + '"/>');
            gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][product_id]" value="' + mValue[i]['product_id'] + '"/>');
            gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][quantity]" value="' + mValue[i]['quantity'] + '"/>');
            gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][previousquantity]" value="' + mValue[i]['previousquantity'] + '"/>');
            gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][trackstock]" value="' + mValue[i]['trackstock'] + '"/>');
            gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][stock]" value="' + mValue[i]['stock'] + '"/>');
            gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][gross_amount]" value="' + mValue[i]['gross_amount'] + '"/>');
            gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][variant]" value="' + mValue[i]['variant'] + '"/>');
            gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i]['id'] + '][weight]" value="' + mValue[i]['weight'] + '"/>');
        }
    };

    gThis._OnSelect = function (gDg, sId) {
        if (gThis.m_bRepeatable) {
            var oSelectedRow = GCore.Duplicate(gDg.GetRow(sId));
            gThis._AddRow(oSelectedRow);
            gDg.ClearSelection();
            gThis.m_gSelectedDatagrid.LoadData();
        }
    };

    gThis._AddRow = function (oSelectedRow) {
        GAlert.DestroyAll();
        GMessage('Dodano wybrany produkt do zamówienia.');
        oSelectedRow = $.extend({
            product_id: oSelectedRow.id,
            product_name: oSelectedRow.name,
            tax_rate: oSelectedRow.tax,
            quantity: 1,
            variant: '',
            gross_amount: oSelectedRow.grossAmount
        }, oSelectedRow);
        oSelectedRow.id = 'new-' + (gThis.m_iCounter++);
        gThis.m_gDataProvider.AddRow(oSelectedRow);
        return oSelectedRow;
    };

    gThis._OnDeselect = function (gDg, sId) {
    };

    gThis._OnChange = function (eEvent) {
        if (gThis.m_bRepeatable) {
            gThis.m_jField.empty();
        }
        var asIds = [];
        for (var i in eEvent.rows) {
            if (eEvent.rows[i].id != undefined) {
                asIds.push(eEvent.rows[i]);
            }
        }
        gThis.SetValue(asIds);
    };

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        gThis.m_jDatagridWrapper = $('<div class="existing-products"/>');
        if (gThis.m_bRepeatable) {
            gThis.m_jField = $('<div/>');
            gThis.m_jDatagrid = $('<div/>');
            gThis.m_jDatagridWrapper.append(gThis.m_jDatagrid);
            gThis.m_jSelectedDatagrid = $('<div class="selected-products"/>');
            gThis.m_jNode.append(gThis.m_jDatagridWrapper);
            gThis.m_jNode.append(gThis.m_jSelectedDatagrid);
        }
        else {
            gThis.m_jField = $('<input type="hidden" name="' + gThis.GetName() + '"/>');
            gThis.m_jDatagrid = $('<div/>');
            gThis.m_jNode.append(gThis.m_jDatagridWrapper);
        }
        gThis.m_jNode.append(gThis.m_jField);
        gThis.m_jDatagridWrapper.addClass(gThis._GetClass('Hidden'));
        gThis.m_jTrigger = $('<p class="' + gThis._GetClass('Trigger') + '"/>');
        gThis.m_jTriggerButton = $('<a href="#" class="' + gThis._GetClass('Button') + '" />');
        gThis.m_jTriggerButton.append('<span><img src="' + gThis._GetImage('AddIcon') + '" alt=""/>' + Translator.trans('order.button.add_product', {}, 'wellcommerce'), +'</span>');

        gThis.m_jTriggerButton.click(GEventHandler(function (eEvent) {
            var jImg = gThis.m_jTrigger.find('a span img');
            if (gThis.m_jDatagridWrapper.hasClass(gThis._GetClass('Hidden'))) {
                gThis.m_jDatagridWrapper.css('display', 'none').removeClass(gThis._GetClass('Hidden'));
            }
            if (!gThis.m_jDatagridWrapper.get(0).bHidden) {
                gThis.m_jDatagridWrapper.get(0).bHidden = true;
                gThis.m_jTrigger.find('a span').empty().append(jImg).append(Translator.trans('order.button.close_product_selector', {}, 'wellcommerce'));
            }
            else {
                gThis.m_jDatagridWrapper.get(0).bHidden = false;
                gThis.m_jTrigger.find('a span').empty().append(jImg).append(Translator.trans('order.button.add_product', {}, 'wellcommerce'));
            }
            gThis.m_jDatagridWrapper.slideToggle(250);
            return false;
        }));
        gThis.m_jTrigger.append(gThis.m_jTriggerButton);
        gThis.m_jNode.append(gThis.m_jTrigger);
    };

    gThis.OnReset = function () {
        gThis.m_bFirstLoad = true;
    };

    gThis.Populate = function (mValue) {
        if (!gThis.m_gDatagrid) {
            return;
        }
        gThis.m_jField.empty();
        gThis.m_oOptions.asDefaults = GCore.Duplicate(mValue);
        gThis.SetValue(mValue);
        gThis.m_gSelectedDatagrid.LoadData();
    };

    gThis.OnShow = function () {
        if (!gThis.m_bShown) {
            gThis._InitDatagrid();
            if (gThis.m_bRepeatable) {
                gThis._InitSelectedDatagrid();
                gThis.Populate(gThis.m_oOptions.asDefaults);
            }
            else {
                gThis.Populate(gThis.m_oOptions.sDefault);
            }
            gThis.m_bShown = true;
        }
    };

    gThis._ProcessProduct = function (oProduct) {
        return oProduct;
    };

    gThis._ProcessSelectedProduct = function (oProduct) {
        oProduct = gThis.m_fProcessProduct(oProduct);
        if (oProduct.thumb != '') {
            oProduct.product_name = '<a title="" href="' + oProduct.thumb + '" class="show-thumb"><img src="' + GCore.DESIGN_PATH + 'images/icons/datagrid/details.png" style="vertical-align: middle;" /></a> ' + oProduct.product_name + '<br /><small>' + oProduct.ean + '</small>';
        } else {
            oProduct.product_name = '<img style="opacity: 0.2;vertical-align: middle;" src="' + GCore.DESIGN_PATH + 'images/icons/datagrid/details.png" style="vertical-align: middle;" /> ' + oProduct.product_name + '<br /><small>' + oProduct.ean + '</small>';
        }

        return oProduct;
    };

    gThis._InitColumns = function () {

        var column_id = new GF_Datagrid_Column({
            id: 'id',
            caption: GMessage('common.label.id'),
            appearance: {
                width: 40,
                visible: false
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var column_name = new GF_Datagrid_Column({
            id: 'name',
            caption: GMessage('common.label.name'),
            appearance: {
                align: GF_Datagrid.ALIGN_LEFT,
                width: GF_Datagrid.WIDTH_AUTO,
            },
            filter: {
                type: GF_Datagrid.FILTER_INPUT
            }
        });

        var column_price = new GF_Datagrid_Column({
            id: 'grossAmount',
            caption: GMessage('common.label.gross_price'),
            appearance: {
                width: 90
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var column_tax_rate = new GF_Datagrid_Column({
            id: 'tax',
            caption: GMessage('common.label.tax_rate'),
            appearance: {
                width: 90,
                visible: false
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var column_weight = new GF_Datagrid_Column({
            id: 'weight',
            caption: GMessage('common.label.dimension.weight'),
            appearance: {
                width: 70
            },
            filter: {
                type: GF_Datagrid.FILTER_BETWEEN
            }
        });

        var column_producer = new GF_Datagrid_Column({
            id: 'producer',
            caption: GMessage('common.label.producer'),
            appearance: {
                width: 150
            },
            filter: {
                type: GF_Datagrid.FILTER_INPUT
            }
        });

        var column_category = new GF_Datagrid_Column({
            id: 'category',
            caption: GMessage('common.label.categories'),
            appearance: {
                width: 200,
                align: GF_Datagrid.ALIGN_LEFT
            },
            filter: {
                type: GF_Datagrid.FILTER_INPUT
            }
        });

        return [
            column_id,
            column_name,
            column_category,
            column_producer,
            column_price,
            column_tax_rate,
            column_weight,
        ];

    };

    gThis._InitAdvancedColumns = function () {

        var column_id = new GF_Datagrid_Column({
            id: 'id',
            caption: GMessage('order.label.id'),
            appearance: {
                width: 40,
                visible: false
            }
        });

        var column_product_id = new GF_Datagrid_Column({
            id: 'product_id',
            caption: GMessage('order.label.product_id'),
            appearance: {
                width: 40,
                visible: false
            }
        });

        var column_product_name = new GF_Datagrid_Column({
            id: 'product_name',
            caption: GMessage('order.label.product_name'),
            appearance: {
                align: GF_Datagrid.ALIGN_LEFT
            }
        });

        var column_variant = new GF_Datagrid_Column({
            id: 'variant',
            caption: GMessage('order.label.variant'),
            appearance: {
                width: 140,
                visible: false
            }
        });

        var column_gross_amount = new GF_Datagrid_Column({
            id: 'gross_amount',
            caption: GMessage('order.label.gross_amount'),
            editable: true,
            appearance: {
                width: 70,
                align: GF_Datagrid.ALIGN_CENTER
            }
        });

        var column_weight = new GF_Datagrid_Column({
            id: 'weight',
            caption: GMessage('order.label.weight'),
            editable: true,
            appearance: {
                width: 70,
                align: GF_Datagrid.ALIGN_CENTER
            }
        });

        var column_quantity = new GF_Datagrid_Column({
            id: 'quantity',
            caption: GMessage('order.label.quantity'),
            editable: true,
            appearance: {
                width: 50
            }
        });

        var column_stock = new GF_Datagrid_Column({
            id: 'stock',
            caption: GMessage('order.label.stock'),
            appearance: {
                width: 80
            }
        });

        var column_tax_value = new GF_Datagrid_Column({
            id: 'tax_value',
            caption: GMessage('order.label.tax_value'),
            appearance: {
                width: 50,
                align: GF_Datagrid.ALIGN_CENTER
            }
        });

        var column_tax_rate = new GF_Datagrid_Column({
            id: 'tax_rate',
            caption: GMessage('order.label.tax_rate'),
            appearance: {
                width: 70,
                align: GF_Datagrid.ALIGN_CENTER
            }
        });

        var column_gross_total = new GF_Datagrid_Column({
            id: 'gross_total',
            caption: GMessage('order.label.gross_total'),
            appearance: {
                width: 70,
                align: GF_Datagrid.ALIGN_CENTER
            }
        });

        var column_variant_options = new GF_Datagrid_Column({
            id: 'variant_options',
            caption: GMessage('order.label.variant_options'),
            appearance: {
                width: 70
            }
        });

        return [
            column_id,
            column_product_id,
            column_product_name,
            column_variant,
            column_variant_options,
            column_gross_amount,
            column_weight,
            column_quantity,
            column_stock,
            column_tax_rate,
            column_tax_value,
            column_gross_total
        ];

    };

    gThis._InitDatagrid = function () {
        gThis.m_fProcessProduct = gThis._ProcessProduct;
        gThis.m_sLoadProductsRoute = gThis.m_oOptions.sLoadProductsRoute;
        var aoColumns = gThis._InitColumns();

        var oOptions = {
            id: gThis.GetId(),
            appearance: {
                column_select: false
            },
            mechanics: {
                rows_per_page: 15,
                key: 'id',
                only_one_selected: !gThis.m_bRepeatable,
                no_column_modification: true,
                persistent: false
            },
            event_handlers: {
                load: function (oRequest) {
                    gThis.m_gDatagrid.MakeRequest(Routing.generate(gThis.m_sLoadProductsRoute), oRequest, GF_Datagrid.ProcessIncomingData);
                },
                process: gThis.m_fProcessProduct,
                select: gThis._OnSelect,
                deselect: gThis._OnDeselect
            },
            columns: aoColumns
        };

        gThis.m_gDatagrid = new GF_Datagrid(gThis.m_jDatagrid, oOptions);

    };

    gThis._Deselect = function (iDg, mId) {
        if (!(mId instanceof Array)) {
            mId = [mId];
        }
        for (var i = 0; i < mId.length; i++) {
            gThis.m_gDataProvider.DeleteRow(mId[i]);
        }
        gThis.m_gSelectedDatagrid.ClearSelection();
        gThis.m_gSelectedDatagrid.LoadData();
    };

    gThis._CalculateRow = function (oRow) {
        oRow.weight = isNaN(parseFloat(oRow.weight)) ? 0 : parseFloat(oRow.weight);
        oRow.quantity = isNaN(parseFloat(oRow.quantity)) ? 0 : parseFloat(oRow.quantity);
        oRow.gross_amount = String(oRow.gross_amount).replace(/,/, '.');
        oRow.gross_amount = isNaN(parseFloat(oRow.gross_amount)) ? 0 : parseFloat(oRow.gross_amount);
        oRow.gross_amount = oRow.gross_amount.toFixed(2);
        oRow.net_amount = parseFloat(oRow.gross_amount) / (1 + (parseFloat(oRow.tax_rate) / 100)).toFixed(2);
        oRow.net_amount = oRow.net_amount.toFixed(2);
        oRow.gross_total = oRow.gross_amount * oRow.quantity;
        oRow.gross_total = oRow.gross_total.toFixed(2);
        oRow.tax_rate = isNaN(parseFloat(oRow.tax_rate)) ? 0 : parseFloat(oRow.tax_rate);
        oRow.net_total = oRow.net_amount * oRow.quantity;
        oRow.tax_value = oRow.gross_total - oRow.net_total;
        oRow.tax_rate = oRow.tax_rate.toFixed(2) + '%';
        oRow.tax_value = oRow.tax_value.toFixed(2);
        return oRow;
    };

    gThis._CalculateTotal = function (aoRows) {
        var tax_value = 0;
        var gross_total = 0;
        var weight = 0;
        for (var i in aoRows) {
            tax_value += parseFloat(aoRows[i].tax_value);
            gross_total += parseFloat(aoRows[i].gross_total);
            weight += parseFloat(aoRows[i].weight * aoRows[i].quantity);
        }
        return {
            product_name: Translator.trans('order.label.gross_total', {}, 'wellcommerce'),
            gross_total: gross_total.toFixed(2),
            tax_value: tax_value.toFixed(2),
            weight: weight.toFixed(2),
        };
    };

    gThis._OnRowChange = GEventHandler(function (eEvent) {
        if ((eEvent.modified_row.variant != eEvent.previous_row.variant) && (eEvent.modified_row.variant != '')) {
            eval('var aoVariants = ' + eEvent.modified_row.variant__options + ';');
            for (var i in aoVariants) {
                if (aoVariants[i].id == eEvent.modified_row.variant) {
                    eEvent.modified_row.sellprice = aoVariants[i].options.price;
                    eEvent.modified_row.weight = aoVariants[i].options.weight;
                    eEvent.modified_row.stock = aoVariants[i].options.stock;
                    eEvent.modified_row.thumb = aoVariants[i].options.thumb;
                    eEvent.modified_row.ean = aoVariants[i].options.ean;
                }
            }
        }
    });

    gThis._InitSelectedDatagrid = function () {

        gThis.m_gDataProvider = new GF_Datagrid_Data_Provider({
            key: 'id',
            preProcess: gThis._CalculateRow,
            additional_rows: [
                new GF_Datagrid_Row({
                    id: 'total',
                    className: 'total',
                    source: gThis._CalculateTotal,
                    caption: Translator.trans('order.label.gross_total', {}, 'wellcommerce')
                })
            ],
            event_handlers: {
                change: gThis._OnChange,
                row_change: gThis._OnRowChange
            }
        }, []);

        var aoColumns = gThis._InitAdvancedColumns();

        var gActionDeselect = new GF_Action({
            img: gThis._GetImage('DeselectIcon'),
            caption: GForm.Language.product_select_deselect,
            action: gThis._Deselect
        });

        var oOptions = {
            id: gThis.GetId() + '_selected',
            appearance: {
                column_select: false,
                footer: false,
                filter: false
            },
            mechanics: {
                rows_per_page: 99999,
                key: 'id',
                no_column_modification: true,
                persistent: false
            },
            event_handlers: {
                load: function (oRequest, sResponseHandler) {
                    if (gThis.m_bFirstLoad) {
                        gThis.m_bFirstLoad = false;
                        gThis._LoadSelected(oRequest, sResponseHandler);
                    }
                    else {
                        gThis.m_gDataProvider.Load(oRequest, sResponseHandler);
                    }
                },
                update_row: function (sId, oRow) {
                    gThis.m_gDataProvider.UpdateRow(sId, oRow);
                    gThis.m_gSelectedDatagrid.LoadData();
                },
                process: gThis._ProcessSelectedProduct,
                loaded: gThis.m_oOptions.fOnChange
            },
            columns: aoColumns,
            row_actions: [
                gActionDeselect
            ],
            context_actions: [
                gActionDeselect
            ],
            group_actions: [
                gActionDeselect
            ]
        };

        gThis.m_gSelectedDatagrid = new GF_Datagrid(gThis.m_jSelectedDatagrid, oOptions);

    };

    gThis.AddProducts = function (mIds) {
        if (!(mIds instanceof Array)) {
            if (mIds == undefined) {
                return;
            }
            mIds = [mIds];
        }

        var oRequest = GCore.Duplicate(gThis.m_oRequest, true);

        oRequest.where = [{
            column: 'id',
            value: mIds,
            operator: 'IN'
        }];

        gThis.m_fLoadProducts(oRequest, GCallback(function (eEvent) {
            for (var j in eEvent.rows) {
                gThis._AddRow(eEvent.rows[j]);
            }
            gThis.m_gSelectedDatagrid.LoadData();
        }));
    };

    gThis._LoadSelected = function (oRequest, sResponseHandler) {
        gThis.m_oRequest = oRequest;
        var asDefaults = [];
        for (var i in gThis.m_oOptions.asDefaults) {
            asDefaults.push(gThis.m_oOptions.asDefaults[i].product_id);
        }
        oRequest.where = [{
            column: 'id',
            value: asDefaults,
            operator: 'IN'
        }];

        GF_Ajax_Request(Routing.generate(gThis.m_oOptions.sLoadProductsRoute), oRequest, function (eEvent) {
            var aoRows = [];
            for (var i in gThis.m_oOptions.asDefaults) {
                var sId = gThis.m_oOptions.asDefaults[i].product_id;
                for (var j in eEvent.rows) {
                    if (eEvent.rows[j].id == sId) {
                        aoRows.push($.extend(true, {id: i}, eEvent.rows[j], gThis.m_oOptions.asDefaults[i]));
                        break;
                    }
                }
            }

            gThis.m_gDataProvider.ChangeData(aoRows);
            gThis.m_gSelectedDatagrid.LoadData();
        });
    };

}, oDefaults);
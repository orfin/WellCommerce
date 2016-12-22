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
        sFieldClass: 'field-datagrid-select',
        sFieldSpanClass: 'field',
        sGroupClass: 'group',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sFieldRepetitionClass: 'repetition'
    },
    oImages: {
        sDeselectIcon: 'images/icons/datagrid/delete.png'
    },
    aoOptions: [],
    sDefault: '',
    aoRules: [],
    sComment: '',
    fLoadRecords: GCore.NULL,
    bAdvancedEditor: false
};

var GFormDatagridSelect = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bShown = false;

    gThis.m_fLoadRecords;
    gThis.m_fProcessRecords;
    gThis.m_jDatagrid;
    gThis.m_jSelectedDatagrid;
    gThis.m_gDatagrid;
    gThis.m_gSelectedDatagrid;
    gThis.m_gDataProvider;
    gThis.m_bFirstLoad = true;

    gThis.GetValue = function (sRepetition) {
        if (gThis.m_jField == undefined) {
            return '';
        }
        if (gThis.m_bRepeatable) {
            if (sRepetition != undefined) {
                return gThis.m_jField.find('input[name="' + gThis.GetName(sRepetition) + '"]').val();
            }
            var aValues = [];
            var jValues = gThis.m_jField.find('input');
            for (var i = 0; i < jValues.length; i++) {
                aValues.push(jValues.eq(i).val());
            }
            return aValues;
        }
        else {
            return gThis.m_jField.val();
        }
    };

    gThis.SetValue = function (mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        if (gThis.m_bRepeatable) {
            for (var i in mValue) {
                gThis.m_jField.append('<input type="hidden" name="' + gThis.GetName(i) + '" value="' + mValue[i] + '"/>');
            }
        }
        else {
            gThis.m_jField.val(mValue).change();
        }
    };

    gThis._OnSelect = function (gDg, sId) {
        if (gThis.m_bRepeatable) {
            var oSelectedRow = gDg.GetRow(sId);
            gThis.m_gDataProvider.AddRow(oSelectedRow);
            gThis.m_gSelectedDatagrid.LoadData();
        }
        else {
            gThis.SetValue(sId);
        }
    };

    gThis._OnDeselect = function (gDg, sId) {
        if (gThis.m_bRepeatable) {
            gThis.m_gDataProvider.DeleteRow(sId);
            gThis.m_gSelectedDatagrid.LoadData();
        }
        else {
            gThis.SetValue('');
        }
    };

    gThis._OnChange = function (eEvent) {
        if (gThis.m_bRepeatable) {
            gThis.m_jField.empty();
        }
        var aoData = [];
        for (var i in eEvent.rows) {
            aoData.push(eEvent.rows[i][gThis.m_oOptions.sKey]);
        }
        gThis.SetValue(aoData);
    };

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        var jLabel = $('<label/>');
        jLabel.text(gThis.m_oOptions.sLabel);
        if ((gThis.m_oOptions.sComment != undefined) && (gThis.m_oOptions.sComment.length)) {
            jLabel.append(' <small>' + gThis.m_oOptions.sComment + '</small>');
        }
        gThis.m_jNode.append(jLabel);
        if (gThis.m_bRepeatable) {
            gThis.m_jField = $('<div/>');
            gThis.m_jDatagrid = $('<div/>');
            jLabel = $('<label/>');
            jLabel.text(GForm.Language.datagrid_select_selected + ':');
            gThis.m_jSelectedDatagrid = $('<div/>');
            gThis.m_jNode.append(gThis.m_jDatagrid);
            gThis.m_jNode.append(jLabel);
            gThis.m_jNode.append(gThis.m_jSelectedDatagrid);
        }
        else {
            gThis.m_jField = $('<input type="hidden" name="' + gThis.GetName() + '"/>');
            gThis.m_jDatagrid = $('<div/>');
            gThis.m_jNode.append(gThis.m_jDatagrid);
        }
        gThis.m_jNode.append(gThis.m_jField);
    };

    gThis.OnReset = function () {
        gThis.m_bFirstLoad = true;
    };

    gThis.Populate = function (mValue) {
        if (!gThis.m_gDatagrid) {
            return;
        }
        if (gThis.m_bRepeatable) {
            gThis.m_jField.empty();
            gThis.m_oOptions.asDefaults = GCore.Duplicate(mValue);
        }
        else {
            gThis.m_oOptions.sDefault = mValue;
        }
        gThis._UpdateDatagridSelection(mValue);
        gThis.SetValue(mValue);
        if (gThis.m_bRepeatable) {
            gThis.m_gSelectedDatagrid.LoadData();
        }
    };

    gThis._UpdateDatagridSelection = function (mValue) {
        if (!(mValue instanceof Array)) {
            if ((mValue == undefined) || !mValue.length) {
                mValue = [];
            }
            else {
                mValue = [mValue];
            }
        }
        gThis.m_gDatagrid.m_asSelected = [];
        for (var i = 0; i < mValue.length; i++) {
            gThis.m_gDatagrid.m_asSelected[i] = mValue[i];
        }
        if (gThis.m_bShown) {
            gThis.m_gDatagrid.LoadData();
        }
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

    gThis._ProcessRecord = function (oRecord) {
        return oRecord;
    };

    gThis._ProcessSelectedRecord = function (oRecord) {
        oRecord = gThis.m_fProcessRecords(oRecord);
        return oRecord;
    };

    gThis._InitOptions = function (aoOptions) {
        var agOptions = [];
        for (var i in aoOptions) {
            agOptions.push(new GF_Datagrid_Column(aoOptions[i]));
        }
        return agOptions;
    };

    gThis._InitDatagrid = function () {

        gThis.m_fProcessRecords = gThis._ProcessRecord;
        gThis.m_fLoadRecords = gThis.m_oOptions.fLoadRecords;

        var aoColumns = gThis._InitOptions(gThis.m_oOptions.aoColumns);

        var oOptions = {
            id: gThis.GetId(),
            mechanics: {
                rows_per_page: 15,
                key: gThis.m_oOptions.sKey,
                only_one_selected: !gThis.m_bRepeatable,
                persistent: false
            },
            event_handlers: {
                load: gThis.m_fLoadRecords,
                process: gThis.m_fProcessRecords,
                select: gThis._OnSelect,
                deselect: gThis._OnDeselect//,
                //selection_changed: gThis._OnChange
            },
            columns: aoColumns
        };

        try {
            gThis.m_gDatagrid = new GF_Datagrid(gThis.m_jDatagrid, oOptions);
        }
        catch (xException) {
            GException.Handle(xException);
        }

    };

    gThis._Deselect = function (iDg, mId) {
        if (!(mId instanceof Array)) {
            mId = [mId];
        }
        for (var i = 0; i < mId.length; i++) {
            gThis.m_gDatagrid.DeselectRow(mId[i]);
        }
        gThis.m_gSelectedDatagrid.ClearSelection();
        gThis.m_gDatagrid.LoadData();
    };

    gThis._InitSelectedDatagrid = function () {

        gThis.m_gDataProvider = new GF_Datagrid_Data_Provider({
            key: gThis.m_oOptions.sKey,
            event_handlers: {
                change: gThis._OnChange
            }
        }, []);

        if (gThis.m_oOptions.aoSelectedColumns == undefined) {
            var aoColumns = gThis._InitOptions(gThis.m_oOptions.aoColumns);
        }
        else {
            var aoColumns = gThis._InitOptions(gThis.m_oOptions.aoSelectedColumns);
        }

        var gActionDeselect = new GF_Action({
            img: gThis._GetImage('DeselectIcon'),
            caption: GForm.Language.datagrid_select_deselect,
            action: gThis._Deselect
        });

        var oOptions = {
            id: gThis.GetId() + '_selected',
            mechanics: {
                rows_per_page: 500,
                key: gThis.m_oOptions.sKey,
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
                },
                process: gThis._ProcessSelectedRecord
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

        try {
            gThis.m_gSelectedDatagrid = new GF_Datagrid(gThis.m_jSelectedDatagrid, oOptions);
        }
        catch (xException) {
            GException.Handle(xException);
        }

    };

    gThis._LoadSelected = function (oRequest, sResponseHandler) {
        oRequest.where = [{
            column: gThis.m_oOptions.sKey,
            value: gThis.m_oOptions.asDefaults,
            operator: 'IN'
        }];
        gThis.m_fLoadRecords(oRequest, GCallback(function (eEvent) {
            gThis.m_gDataProvider.ChangeData(eEvent.rows);
            gThis.m_gSelectedDatagrid.LoadData();
        }));
    };

}, oDefaults);
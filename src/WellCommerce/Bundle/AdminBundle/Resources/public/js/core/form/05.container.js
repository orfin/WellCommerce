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
    oClasses: {
        sRepetitionClass: 'GFormRepetition',
        sAddButtonClass: 'add-repetition',
        sDeleteButtonClass: 'delete-repetition'
    },
    aoFields: [],
    agFields: []
};

/**
 * GFormContainer
 *
 * @type {*}
 */
var GFormContainer = GCore.ExtendClass(GFormNode, function () {

    var gThis = this;

    gThis.m_oContainerRepetitions = {};
    gThis.m_iRepetitionIndex = 0;
    gThis.m_agFields = [];
    gThis.m_iChildIndex = 0;

    gThis._Constructor = function () {
        gThis.m_bRepeatable = false;
        if ((gThis.m_oOptions.oRepeat != undefined) && (gThis.m_oOptions.oRepeat.iMax != undefined) && (gThis.m_oOptions.oRepeat.iMax > 1)) {
            gThis.m_bRepeatable = true;
        }
        if (!gThis.m_bRepeatable) {
            gThis._ConstructChildren();
        }
    };

    gThis._ConstructChildren = function () {

        for (var i = 0; i < gThis.m_oOptions.aoFields.length; i++) {
            var oField = gThis.m_oOptions.aoFields[i];
            var gChild = new oField.fType(oField);
            if (gChild._Constructor != undefined) {
                gChild._Constructor();
            }
            gThis.m_oOptions.agFields.push(gChild);
            gThis.m_agFields[gThis.m_iChildIndex++] = gChild;
        }
    };

    gThis.RenderChildren = function () {
        var jChildrenCollection = $('<div/>');
        for (var i = 0; i < gThis.m_oOptions.agFields.length; i++) {
            gThis._PrepareChild(gThis.m_oOptions.agFields[i]);
            jChildrenCollection.append(gThis.m_oOptions.agFields[i].Render());
        }
        return jChildrenCollection.children();
    };

    gThis._PrepareChild = function (gChild) {
        gChild.m_gForm = gThis.m_gForm;
        gChild.m_gParent = gThis;
        if (gChild.m_oOptions.sName != undefined) {
            gThis.m_gForm.m_ogFields[gChild.m_oOptions.sName] = gChild;
        }
        if (gThis.m_gParent == GCore.NULL) {
            gChild.m_sNamePrefix = '';
        }
        if (gThis.m_gForm == gThis.m_gParent) {
            gChild.m_sNamePrefix = gThis.m_oOptions.sName;
        }
        else {
            gChild.m_sNamePrefix = gThis.GetName();
        }
    };

    gThis.OnInit = function () {
        gThis._Initialize();
        gThis._InitializeEvents();
        for (var i = 0; i < gThis.m_iChildIndex; i++) {
            if (gThis.m_agFields[i] == undefined) {
                continue;
            }
            gThis.m_agFields[i].OnInit();
        }
        gThis._InitializeDependencies();
        gThis._InitializeRules();
    };

    gThis.OnShow = function () {
        for (var i = 0; i < gThis.m_iChildIndex; i++) {
            if (gThis.m_agFields[i] == undefined) {
                continue;
            }
            gThis.m_agFields[i].OnShow();
        }
    };

    gThis.OnRemove = function () {
        for (var i = 0; i < gThis.m_iChildIndex; i++) {
            if (gThis.m_agFields[i] == undefined) {
                continue;
            }
            gThis.m_agFields[i].OnRemove();
        }
    };

    gThis.OnHide = function () {
        for (var i = 0; i < gThis.m_iChildIndex; i++) {
            if (gThis.m_agFields[i] == undefined) {
                continue;
            }
            gThis.m_agFields[i].OnHide();
        }
    };

    gThis.OnReset = function () {
        for (var i = 0; i < gThis.m_iChildIndex; i++) {
            if (gThis.m_agFields[i] == undefined) {
                continue;
            }
            gThis.m_agFields[i].OnReset();
        }

    };

    gThis.Reset = function () {
        for (var i = 0; i < gThis.m_iChildIndex; i++) {
            if (gThis.m_agFields[i] == undefined) {
                continue;
            }
            gThis.m_agFields[i].Reset();
        }
    };

    gThis.Validate = function (bNoRequests) {
        var bResult = true;
        for (var i = 0; i < gThis.m_iChildIndex; i++) {
            if (gThis.m_agFields[i] == undefined) {
                continue;
            }
            if (!gThis.m_agFields[i].Validate(bNoRequests)) {
                bResult = false;
            }
        }
        return bResult;
    };

    gThis.AddRepetition = function (i) {
        if (i == undefined) {
            i = 'new-' + gThis.m_iRepetitionIndex++;
        }

        var oOptions = GCore.Duplicate(gThis.m_oOptions, true);
        oOptions.sName = i;
        oOptions.agFields = [];
        oOptions.oRepeat = {};
        var gRepetition = new GFormRepetition(oOptions);
        gRepetition._Constructor();
        gThis._PrepareChild(gRepetition);
        gThis.m_jNode.append(gRepetition.Render());
        gRepetition.OnInit();
        gRepetition.m_jNode.find('.' + gThis._GetClass('DeleteButton')).attr('rel', i).click(function () {
            gThis.RemoveRepetition($(this).attr('rel'));
            return false;
        });
        gRepetition.m_jNode.find('input').focus();
        gThis.m_oContainerRepetitions[i] = gRepetition;
        gThis.m_agFields[gThis.m_iChildIndex++] = gRepetition;
        if (GCore.ObjectLength(gThis.m_oContainerRepetitions) <= gThis.m_oOptions.oRepeat.iMin) {
            gThis.m_jNode.find('.' + gThis._GetClass('Repetition') + ' > .' + gThis._GetClass('DeleteButton')).css('display', 'none');
        }
        else {
            gThis.m_jNode.find('.' + gThis._GetClass('Repetition') + ' > .' + gThis._GetClass('DeleteButton')).css('display', 'block');
        }
        gRepetition.OnShow();
    };

    gThis.RemoveRepetition = function (i) {
        gRepetition = gThis.m_oContainerRepetitions[i];
        if (gRepetition == undefined) {
            return;
        }
        gRepetition.OnRemove();
        if (gRepetition.m_jNode != undefined) {
            gRepetition.m_jNode.remove();
        }
        for (var j in gThis.m_agFields) {
            if (gThis.m_oContainerRepetitions[i] == gThis.m_agFields[j]) {
                delete gThis.m_agFields[j];
            }
        }
        delete gThis.m_oContainerRepetitions[i];
        if (GCore.ObjectLength(gThis.m_oContainerRepetitions) <= gThis.m_oOptions.oRepeat.iMin) {
            gThis.m_jNode.find('.' + gThis._GetClass('Repetition') + ' > .' + gThis._GetClass('DeleteButton')).css('display', 'none');
        }
        if (GCore.ObjectLength(gThis.m_oContainerRepetitions) < gThis.m_oOptions.oRepeat.iMax) {
            gThis.m_jAdd.css('display', 'block');
        }
    };

    gThis.Populate = function (mData) {

        if (gThis.m_bRepeatable) {
            gThis.AddRepetition();
        }
        if (mData == undefined) {
            return;
        }
        var i;
        if (gThis.m_bRepeatable) {
            if (!GCore.ObjectLength(mData)) {
                return;
            }
            var aKeys = [];
            for (i in mData) {
                aKeys.push(i);
            }
//			aKeys.sort();
            if (!gThis.m_gForm.m_bPopulatedWithDefaults) {
                for (var k in gThis.m_oContainerRepetitions) {
                    gThis.RemoveRepetition(k);
                }
                gThis.m_jNode.find('.' + gThis._GetClass('Repetition')).remove();
            }
            for (i = 0; i < aKeys.length; i++) {
                var j = aKeys[i];
                if (gThis.m_oContainerRepetitions[j] == undefined) {
                    gThis.AddRepetition(j);
                }
                gThis.m_oContainerRepetitions[j].Populate(mData[j]);
            }
        }
        else {
            for (i = 0; i < gThis.m_oOptions.agFields.length; i++) {
                if ((gThis.m_oOptions.agFields[i].m_oOptions.sName != undefined)) {
                    gThis.m_oOptions.agFields[i].Populate(mData[gThis.m_oOptions.agFields[i].m_oOptions.sName]);
                }
            }
        }
    };

    gThis.PopulateErrors = function (mData) {
        if (mData == undefined) {
            return;
        }

        var i;
        if (gThis.m_bRepeatable) {
            for (i in mData) {
                if (gThis.m_oContainerRepetitions[i] != undefined) {
                    gThis.m_oContainerRepetitions[i].PopulateErrors(mData[i]);
                }
            }
        }
        else {
            for (i = 0; i < gThis.m_oOptions.agFields.length; i++) {
                if ((gThis.m_oOptions.agFields[i].m_oOptions.sName != undefined)) {

                    gThis.m_oOptions.agFields[i].PopulateErrors(mData[gThis.m_oOptions.agFields[i].m_oOptions.sName]);
                }
            }
        }
    };

    gThis.Focus = function () {
        if (gThis.m_bRepeatable) {
            var aKeys = [];
            for (i in gThis.m_oContainerRepetitions) {
                aKeys.push(i);
            }
            aKeys.sort();
            for (i = 0; i < aKeys.length; i++) {
                var j = aKeys[i];
                if (gThis.m_oContainerRepetitions[j].Focus()) {
                    return true;
                }
            }
        }
        else {
            for (var i = 0; i < gThis.m_oOptions.agFields.length; i++) {
                if (gThis.m_oOptions.agFields[i].Focus()) {
                    return true;
                }
            }
        }
        return false;
    };

    gThis._Initialize = function () {
        if (gThis.m_bRepeatable && !gThis.m_agFields.length) {
            for (var i = 0; i < gThis.m_oOptions.oRepeat.iMin; i++) {
                gThis.AddRepetition();
            }
        }
    };

}, oDefaults);
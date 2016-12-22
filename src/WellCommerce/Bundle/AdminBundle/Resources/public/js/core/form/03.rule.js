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

var GFormRule = function () {
};

GFormRule.Check = function (oRule, gField, bNoRequest, iRepetition) {
    if (bNoRequest == undefined) {
        bNoRequest = false;
    }
    var mValue = gField.GetValue(iRepetition);
    switch (oRule.sType) {

        case 'required':
            if (gField._GetField(iRepetition).find('option:selected').val() != undefined) {
                if (gField._GetField(iRepetition).find('option:selected').val() == 0) {
                    return gField.ValidationResult(false, oRule.sErrorMessage, iRepetition);
                }
            }
            else if (mValue == '') {
                return gField.ValidationResult(false, oRule.sErrorMessage, iRepetition);
            }
            return gField.ValidationResult(true, oRule.sErrorMessage, iRepetition);

        case 'format':
            if (mValue != '') {
                var rRE = new RegExp(oRule.sFormat.substr(1, oRule.sFormat.length - 2));
                return gField.ValidationResult(rRE.test(mValue), oRule.sErrorMessage, iRepetition);
            }
            return gField.ValidationResult(true);

        case 'email':
            if (mValue != '') {
                return gField.ValidationResult(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.(?:[A-Z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)$/i.test(mValue), oRule.sErrorMessage, iRepetition);
            }
            return gField.ValidationResult(true);

        case 'vat':
            var sValue = mValue.replace(/-/, '');
            sValue = sValue.replace(/-/, '');
            sValue = sValue.replace(/-/, '');

            if (sValue.length != 10) {
                return gField.ValidationResult(false, oRule.sErrorMessage, iRepetition);
            }

            aoSteps = new Array(6, 5, 7, 2, 3, 4, 5, 6, 7);
            iSum = 0;

            for (i = 0; i < 9; i++) {

                iSum += aoSteps[i] * sValue.charAt(i);

            }

            iModulo = iSum % 11;

            if (iModulo == 10) {
                iControl = 0;
            } else {
                iControl = iModulo;
            }

            if (iControl == sValue.charAt(9)) {
                return gField.ValidationResult(true, oRule.sErrorMessage, iRepetition);
            }

        case 'compare':
            var jFieldToCompare = $('[id$="' + oRule.sFieldToCompare + '"]');
            if (!jFieldToCompare.length) {
                return gField.ValidationResult(false, oRule.sErrorMessage, iRepetition);
            }
            return gField.ValidationResult(mValue == jFieldToCompare.closest('.GFormNode').get(0).gNode.GetValue(), oRule.sErrorMessage, iRepetition);

        case 'dateto':
            var jFieldToCompare = $('[id$="' + oRule.sFieldToCompare + '"]');
            if (!jFieldToCompare.length) {
                return gField.ValidationResult(false, oRule.sErrorMessage, iRepetition);
            }
            return gField.ValidationResult(mValue >= jFieldToCompare.closest('.GFormNode').get(0).gNode.GetValue(), oRule.sErrorMessage, iRepetition);

        case 'unique':
            if (!bNoRequest) {
                gField.StartWaiting();
                oRule.fCheckFunction({
                    value: mValue
                }, GCallback(GFormRule.ValidationResponse, {
                    gField: gField,
                    sErrorMessage: oRule.sErrorMessage,
                    iRepetition: iRepetition
                }));
            }
            return gField.ValidationResult(true);

        case 'languageunique':
            if (!bNoRequest) {
                gField.StartWaiting();
                oRule.fCheckFunction({
                    value: mValue,
                    language: gField.m_gParent.m_oOptions.sName
                }, GCallback(GFormRule.ValidationResponse, {
                    gField: gField,
                    sErrorMessage: oRule.sErrorMessage,
                    iRepetition: iRepetition
                }));
            }
            return gField.ValidationResult(true);

        case 'custom':
            var oParams = {};
            for (var sI in oRule.oParams) {
                if (sI.substr(0, 7) == '_field_') {
                    oParams[sI.substr(7)] = gField.m_gForm.GetField(oRule.oParams[sI]).GetValue();
                }
                else {
                    oParams[sI] = oRule.oParams[sI];
                }
            }
            if (!bNoRequest) {
                gField.StartWaiting();
                oRule.fCheckFunction({
                    value: mValue,
                    params: oParams
                }, GCallback(GFormRule.ValidationResponse, {
                    gField: gField,
                    sErrorMessage: oRule.sErrorMessage,
                    iRepetition: iRepetition
                }));
            }
            return gField.ValidationResult(true);

    }
    return gField.ValidationResult(false);
};

GFormRule.ValidationResponse = function (oData) {
    oData.gField.StopWaiting();
    oData.gField.ValidationResult(oData.unique, oData.sErrorMessage, oData.iRepetition);
};
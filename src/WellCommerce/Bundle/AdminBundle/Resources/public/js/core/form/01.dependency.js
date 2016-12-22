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

var GFormDependency = function (sType, sFieldSource, mCondition, mArgument) {

    var gThis = this;

    gThis.m_iId;
    gThis.m_sType = sType;
    gThis.m_gForm;
    gThis.m_sFieldSource = sFieldSource;
    gThis.m_sFieldTarget;
    gThis.m_mArgument = mArgument;
    if (mCondition instanceof GFormCondition) {
        gThis.m_gCondition = mCondition;
    }
    else if (mCondition instanceof Function) {
        gThis.m_fSource = mCondition;
    }

    gThis.Constructor = function (gForm, sFieldTarget) {
        gThis.m_iId = GFormDependency.s_iNextId++;
        gThis.m_gForm = gForm;
        gThis.m_sFieldTarget = sFieldTarget;
        gThis._InitializeEvents();
    };

    gThis._InitializeEvents = function () {
        var gFieldTarget = gThis.m_gForm.GetField(gThis.m_sFieldTarget);
        var fHandler;
        switch (gThis.m_sType) {
            case GFormDependency.HIDE:
                fHandler = gThis.EvaluateHide;
                break;
            case GFormDependency.SHOW:
                fHandler = gThis.EvaluateShow;
                break;
            case GFormDependency.IGNORE:
                fHandler = gThis.EvaluateIgnore;
                break;
            case GFormDependency.SUGGEST:
                fHandler = gThis.EvaluateSuggest;
                break;
            case GFormDependency.INVOKE_CUSTOM_FUNCTION:
                fHandler = gThis.EvaluateInvoke;
                break;
            case GFormDependency.EXCHANGE_OPTIONS:
                fHandler = gThis.EvaluateExchangeOptions;
                break;
            default:
                return;
        }
        var bAlreadyInitialised = false;
        if (!gFieldTarget.m_oInitializedDependencies[gThis.m_iId]) {
            var gField = gThis.m_gForm.GetFieldForForm(gThis.m_sFieldSource);
            gField.BindChangeHandler(fHandler, {
                gNode: gField
            });
            gField.m_afDependencyTriggers.push(fHandler);
            gFieldTarget.m_oInitializedDependencies[gThis.m_iId] = true;
            bAlreadyInitialised = true;
        }
        if (!bAlreadyInitialised || (gThis.m_sType != GFormDependency.EXCHANGE_OPTIONS)) {
            fHandler.apply(gThis.m_gForm.GetFieldForForm(gThis.m_sFieldSource).m_jField);
        }
    };

    gThis.EvaluateShow = function (eEvent) {
        var gCurrentField, gDependentField;
        if (eEvent == undefined) {
            eEvent = {data: {gNode: $(this).closest('.GFormNode').get(0).gNode}};
        }
        gCurrentField = eEvent.data.gNode;
        gDependentField = gThis._FindFieldInCurrentRepetition(gCurrentField, gThis.m_gForm.GetFieldForForm(gThis.m_sFieldTarget));
        if ((gCurrentField.m_gParent instanceof GFormRepeatableFieldset) && (gCurrentField.m_gParent == gDependentField.m_gParent)) {
            gDependentField = gDependentField;
        }
        if (gThis.Evaluate(gCurrentField.GetValue())) {
            gDependentField.Show();
        }
        else {
            gDependentField.Hide();
        }
    };

    gThis.EvaluateHide = function (eEvent) {
        var gCurrentField, gDependentField;
        if (eEvent == undefined) {
            eEvent = {data: {gNode: $(this).closest('.GFormNode').get(0).gNode}};
        }
        gCurrentField = eEvent.data.gNode;
        gDependentField = gThis._FindFieldInCurrentRepetition(gCurrentField, gThis.m_gForm.GetFieldForForm(gThis.m_sFieldTarget));
        if (gThis.Evaluate(gCurrentField.GetValue())) {
            gDependentField.Hide();
        }
        else {
            gDependentField.Show();
        }
    };

    gThis._FindFieldInCurrentRepetition = function (gCurrentField, gDependentField) {
        if ((gCurrentField.m_gParent instanceof GFormRepetition) && (gCurrentField.m_gParent.m_gParent == gDependentField.m_gParent.m_gParent)) {
            for (var i in gCurrentField.m_gParent.m_agFields) {
                var gField = gCurrentField.m_gParent.m_agFields[i];
                if (gField.m_oOptions.sName == gThis.m_sFieldTarget) {
                    return gField;
                }
            }
        }
        return gDependentField;
    };

    gThis.EvaluateIgnore = function (eEvent) {
        var gCurrentField, gDependentField;
        if (eEvent == undefined) {
            eEvent = {data: {gNode: $(this).closest('.GFormNode').get(0).gNode}};
        }
        gCurrentField = eEvent.data.gNode;
        gDependentField = gThis._FindFieldInCurrentRepetition(gCurrentField, gThis.m_gForm.GetFieldForForm(gThis.m_sFieldTarget));
        if (gThis.Evaluate(gCurrentField.GetValue())) {
            gDependentField.Ignore();
        }
        else {
            gDependentField.Unignore();
        }
    };

    gThis.EvaluateInvoke = function (eEvent) {
        if (eEvent == undefined) {
            eEvent = {
                data: {
                    gNode: $(this).closest('.GFormNode').get(0).gNode,
                    mArgument: gThis.m_mArgument
                }
            };
        }
        gThis.m_fSource({
            sValue: eEvent.data.gNode.GetValue(),
            gForm: gThis.m_gForm,
            sFieldTarget: gThis.m_sFieldTarget,
            mArgument: gThis.m_mArgument
        });
    };

    gThis.EvaluateSuggest = function (eEvent) {
        var gCurrentField, gDependentField;
        if (eEvent == undefined) {
            eEvent = {data: {gNode: $(this).closest('.GFormNode').get(0).gNode}};
        }
        gCurrentField = eEvent.data.gNode;
        gDependentField = gThis._FindFieldInCurrentRepetition(gCurrentField, gThis.m_gForm.GetFieldForForm(gThis.m_sFieldTarget));
        gThis.m_fSource({
            value: eEvent.data.gNode.GetValue()
        }, GCallback(function (oData) {
            gDependentField.SetValue(oData.suggestion);
        }, {
            gForm: gThis.m_gForm,
            sFieldTarget: gThis.m_sFieldTarget
        }));
    };

    gThis.EvaluateExchangeOptions = function (eEvent) {
        if (eEvent == undefined) {
            eEvent = {
                data: {
                    gNode: $(this).closest('.GFormNode').get(0).gNode,
                    mArgument: gThis.m_mArgument
                }
            };
        }
        gThis.m_fSource({
            value: eEvent.data.gNode.GetValue()
        }, GCallback(function (oData) {
            oData.gForm.GetField(oData.sFieldTarget).ExchangeOptions(oData.options);
        }, {
            gForm: gThis.m_gForm,
            sFieldTarget: gThis.m_sFieldTarget
        }));
    };

    gThis.Evaluate = function (mValue) {
        return gThis.m_gCondition.Evaluate(mValue);
    };

};

GFormDependency.HIDE = 'hide';
GFormDependency.SHOW = 'show';
GFormDependency.IGNORE = 'ignore';
GFormDependency.SUGGEST = 'suggest';
GFormDependency.INVOKE_CUSTOM_FUNCTION = 'invoke';
GFormDependency.EXCHANGE_OPTIONS = 'exchangeOptions';
GFormDependency.s_iNextId = 0;
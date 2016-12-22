var GAlert = function (sTitle, sMessage, oParams) {
    if (sMessage == undefined) {
        sMessage = '';
    }
    var iAlertId = GAlert.Register();
    if (GAlert.sp_dHandler != undefined) {
        GAlert.sp_dHandler.Alert(sTitle, sMessage, oParams, iAlertId);
    }
    else {
        alert(sTitle + '\n' + sMessage);
    }
    return iAlertId;
};

var GWarning = function (sTitle, sMessage, oParams) {
    if (oParams == undefined) {
        oParams = {};
    }
    oParams.iType = GAlert.TYPE_WARNING;
    return GAlert(sTitle, sMessage, oParams);
};

var GError = function (sTitle, sMessage, oParams) {
    if (oParams == undefined) {
        oParams = {};
    }
    oParams.iType = GAlert.TYPE_ERROR;
    return GAlert(sTitle, sMessage, oParams);
};

var GMessage = function (sTitle, sMessage, oParams) {
    if (oParams == undefined) {
        oParams = {};
    }
    oParams.iType = GAlert.TYPE_MESSAGE;
    return GAlert(sTitle, sMessage, oParams);
};

var GNotification = function (sMessage, oParams) {
    if (oParams == undefined) {
        oParams = {};
    }

    oParams.life = 2500;
    oParams.corners = 0;
    oParams.sticky = false;
    oParams.position = 'bottom-right';

    return $.jGrowl(sMessage, oParams);
};

var GPrompt = function (sTitle, fOnConfirm, oParams) {
    if (oParams == undefined) {
        oParams = {};
    }
    var sMessage = '<span class="field-text"><input type="text" class="prompt-value" value="' + ((oParams.sDefault == undefined) ? '' : oParams.sDefault) + '"/></span>';
    oParams = $.extend(true, {
        bAutoExpand: true,
        bNotRetractable: true,
        aoPossibilities: [
            {
                mLink: GEventHandler(function (eEvent) {
                    var sValue = $(this).closest('.message').find('input.prompt-value').val();
                    fOnConfirm.apply(this, [sValue]);
                }),
                sCaption: GMessageBar.Language.add
            },
            {
                mLink: GAlert.DestroyThis,
                sCaption: GMessageBar.Language.cancel
            }
        ]
    }, oParams);
    oParams.iType = GAlert.TYPE_PROMPT;
    return GAlert(sTitle, sMessage, oParams);
};

GAlert.Destroy = function (iAlertId) {
    if (GAlert.sp_dHandler != undefined) {
        GAlert.sp_dHandler.Destroy(iAlertId);
    }
};

GAlert.DestroyThis = function (eEvent) {
    GAlert.Destroy($(this));
};

GAlert.DestroyAll = function () {
    if (GAlert.sp_dHandler != undefined) {
        GAlert.sp_dHandler.DestroyAll();
    }
};

GAlert.Register = function () {
    return GAlert.s_iCounter++;
};

GAlert.sp_dHandler;
GAlert.s_iCounter = 0;

GAlert.TYPE_WARNING = 0;
GAlert.TYPE_ERROR = 1;
GAlert.TYPE_MESSAGE = 2;
GAlert.TYPE_PROMPT = 3;
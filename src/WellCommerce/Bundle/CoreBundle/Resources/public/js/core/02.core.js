/*
 * CORE
 */

var oDefaults = {
    iCookieLifetime: 30,
    sDesignPath: '',
    iActiveView: null,
    aoViews:'',
    iActiveLanguage:1,
    aoLanguages:'',
    aoVatValues:'',
    sCurrentController: '',
    sCurrentAction: '',
};

GCore = function(oParams) {
    GCore.p_oParams = oParams;
    GCore.DESIGN_PATH = GCore.p_oParams.sDesignPath;
    GCore.iActiveView = GCore.p_oParams.iActiveView;
    GCore.aoViews = GCore.p_oParams.aoViews;
    GCore.iActiveLanguage = GCore.p_oParams.iActiveLanguage;
    GCore.aoLanguages = GCore.p_oParams.aoLanguages;
    GCore.aoVatValues = GCore.p_oParams.aoVatValues;
    GCore.sCurrentController = GCore.p_oParams.sCurrentController;
    GCore.sAdminUrl = GCore.p_oParams.sUrl;
    GCore.sCurrentAction = GCore.p_oParams.sCurrentAction;
    GXajaxInterface.Initialize();
    GCore.StartWaiting();
};


GCore.NULL = 'null';

GCore.s_afOnLoad = [];

GCore.GetArgumentsArray = function(oArguments) {
    var amArguments = [];
    for (var i = 0; i < oArguments.length; i++) {
        amArguments[i] = oArguments[i];
    }
    return amArguments;
};

GCore.Duplicate = function(oA, bDeep) {
    var oB = $.extend((bDeep == true), {}, oA);
    return oB;
};

GCore.OnLoad = function(fTarget) {
    GCore.s_afOnLoad.push(fTarget);
};

GCore.Init = function() {
    for (var i = 0; i < GCore.s_afOnLoad.length; i++) {
        GCore.s_afOnLoad[i]();
    }
    $('#content').css('visibility', 'visible').children('.preloader').remove();
    GCore.StopWaiting();
};

GCore.ExtendClass = function(fBase, fChild, oDefaults) {
    var fExtended = function() {
        var aBaseArguments = [];
        for (var i = 0; i < arguments.length; i++) {
            aBaseArguments.push(arguments[i]);
        }
        var result = fBase.apply(this, aBaseArguments);
        if (result === false) {
            return result;
        }
        fChild.apply(this, arguments);
        this.m_oOptions = $.extend(true, GCore.Duplicate(oDefaults, true), arguments[0]);
        return this;
    };
    for(var i in fBase.prototype) {
        fExtended.prototype[i] = fBase.prototype[i];
    }
    return fExtended;
};

GCore.ObjectLength = function(oObject) {
    var iLength = 0;
    for (var i in oObject) {
        iLength++;
    }
    return iLength;
};

GCore.FilterObject = function(oSource, fTest) {
    var oResult = {};
    for (var i in oSource) {
        if (fTest(oSource[i])) {
            oResult[i] = GCore.Duplicate(oSource[i], true);
        }
    }
    return oResult;
};

GCore.GetIterationArray = function(oSource, fCompare) {
    var oSource = $.extend(true, {}, oSource);
    var aSource = [];
    for (var i in oSource) {
        aSource.push($.extend(true, {$$key: i}, oSource[i]));
    }
    aSource.sort(fCompare);
    var asIterationArray = [];
    for (var i = 0; i < aSource.length; i++) {
        asIterationArray.push(aSource[i]['$$key']);
    }
    return asIterationArray;
};

GCore.StartWaiting = function() {
    $('body').css({
        cursor: 'wait'
    });
};

GCore.StopWaiting = function() {
    $('body').css({
        cursor: 'auto'
    });
};
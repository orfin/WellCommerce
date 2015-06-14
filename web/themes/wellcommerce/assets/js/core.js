var oDefaults = {
    iCookieLifetime: 30,
    sDesignPath:     '',
    sController:     'main',
    sCartRedirect:   ''
};

/**
 * GCore
 *
 * @param oParams
 * @constructor
 */
GCore = function (oParams) {
    GCore.p_oParams = oParams;
    GCore.COOKIE_LIFETIME = GCore.p_oParams.iCookieLifetime;
};

GCore.NULL = 'null';
GCore.s_afOnLoad = [];
GCore.GetArgumentsArray = function (oArguments) {
    var amArguments = [];
    for (var i = 0; i < oArguments.length; i++) {
        amArguments[i] = oArguments[i];
    }
    return amArguments;
};

GCore.Duplicate = function (oA, bDeep) {
    var oB = $.extend((bDeep == true), {}, oA);
    return oB;
};

GCore.OnLoad = function (fTarget) {
    GCore.s_afOnLoad.push(fTarget);
};

GCore.Init = function () {
    for (var i = 0; i < GCore.s_afOnLoad.length; i++) {
        GCore.s_afOnLoad[i]();
    }
};

GCore.ExtendClass = function (fBase, fChild, oDefaults) {
    var fExtended = function () {
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
    for (var i in fBase.prototype) {
        fExtended.prototype[i] = fBase.prototype[i];
    }
    return fExtended;
};

GCore.ObjectLength = function (oObject) {
    var iLength = 0;
    for (var i in oObject) {
        if (isNaN(i)) {
            continue;
        }
        iLength++;
    }
    return iLength;
};

GCore.StartWaiting = function () {
    $('body').css({
        cursor: 'wait'
    });
};

GCore.StopWaiting = function () {
    $('body').css({
        cursor: 'auto'
    });
};

GCore.AjaxRequest = function (sUrl, oRequest, fCallBack) {
    return $.ajax({
        type:     "POST",
        url:      sUrl,
        data:     oRequest,
        success:  fCallBack,
        dataType: 'json'
    });
};

/**
 * GCookie
 *
 * @param name
 * @param value
 * @param options
 * @returns {*}
 * @constructor
 */
GCookie = function (name, value, options) {
    if (typeof value != 'undefined') {
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString();
        }
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else {
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

/**
 * GException
 *
 * @param sMessage
 * @constructor
 */
var GException = function (sMessage) {
    this.m_sMessage = sMessage;
    this.toString = function () {
        return this.m_sMessage;
    };
};

GException.Handle = function (xException) {
    new GAlert(GException.Language['exception_has_occured'], xException);
    throw xException; // for debugging
};

GException.Language = {
    exception_has_occured: 'Wystąpił błąd!'
};

/**
 * GPlugin
 *
 * @param sPluginName
 * @param oDefaults
 * @param fPlugin
 * @constructor
 */
var GPlugin = function (sPluginName, oDefaults, fPlugin) {

    (function ($) {

        var oExtension = {};
        oExtension[sPluginName] = function (oOptions) {
            if ($(this).hasClass(sPluginName)) {
                return;
            }
            oOptions = $.extend(GCore.Duplicate(oDefaults), oOptions);
            return this.each(function () {
                this.m_oOptions = oOptions;
                this.m_iId = GPlugin.s_iCounter++;
                GPlugin.s_oInstances[this.m_iId] = this;
                this.m_oParams = {};
                this._GetClass = function (sClassName) {
                    var sClass = this.m_oOptions.oClasses['s' + sClassName + 'Class'];
                    if (sClass == undefined) {
                        return '';
                    }
                    else {
                        return sClass;
                    }
                };
                this._GetImage = function (sImageName) {
                    var sImage = this.m_oOptions.oImages['s' + sImageName];
                    if (sImage == undefined) {
                        return '';
                    }
                    else {
                        return GCore.DESIGN_PATH + sImage;
                    }
                };
                try {
                    if ($(this).attr('class') != undefined) {
                        var asParams = $(this).attr('class').match(/G\:\w+\=\S+/g);
                        if (asParams != undefined) {
                            for (var i = 0; i < asParams.length; i++) {
                                var asParamData = asParams[i].match(/G:(\w+)\=(\S+)/);
                                this.m_oParams[asParamData[1]] = asParamData[2];
                            }
                        }
                    }
                    $(this).addClass(sPluginName);
                    fPlugin.apply(this, [this.m_oOptions]);
                }
                catch (xException) {
                    throw xException;
                    GException.Handle(xException);
                }
            });
        };
        $.fn.extend(oExtension);
        fPlugin.GetInstance = GPlugin.GetInstance;

    })(jQuery);

};

GPlugin.s_iCounter = 0;
GPlugin.s_oInstances = {};

GPlugin.GetInstance = function (iId) {
    if (GPlugin.s_oInstances[iId] != undefined) {
        return GPlugin.s_oInstances[iId];
    }
    throw new GException('Requested instance (' + iId + ') not found.');
};

GAjaxRequest = function (sUrl, oRequest, fCallBack) {
    return $.ajax({
        type:     "POST",
        url:      sUrl,
        data:     oRequest,
        success:  fCallBack,
        dataType: 'json'
    });
};

var oCartDefaults = {
    sChangeQuantityRoute: 'front.cart.edit',
    sDeleteRoute: 'front.cart.delete',
    sDeleteButtonClass: 'btn-remove',
    sQuantitySpinnerClass: 'quantity-spinner'
};

var GCart = function(oOptions) {

    var gThis = this;

    gThis._Constructor = function() {
        gThis.m_gForm = $("form", gThis);
        gThis.InitializeEvents();
    };

    gThis.InitializeEvents = function(){
        $("input[type='radio']", gThis.m_gForm).bind('change', gThis.SubmitForm);
        $('.' + gThis.m_oOptions.sDeleteButtonClass, gThis).bind('click', gThis.DeleteItem);
        $('.' + gThis.m_oOptions.sQuantitySpinnerClass, gThis).bind('change', gThis.ChangeItemQuantity);
    };

    gThis.DeleteItem = function(){
        var oRequest = {
            id: $(this).data('id')
        };

        GAjaxRequest(Routing.generate(gThis.m_oOptions.sDeleteRoute), oRequest, gThis.ProcessResponse);

        return false;
    };

    gThis.ProcessResponse = function(oResponse){
        if(oResponse.success){
            return gThis.ReloadCart();
        }else{
            alert(oResponse.message);
        }
    };

    gThis.ChangeItemQuantity = function(){
        var oRequest = {
            id: $(this).data('id'),
            qty: $(this).val()
        };

        GAjaxRequest(Routing.generate(gThis.m_oOptions.sChangeQuantityRoute), oRequest, gThis.ProcessResponse);

        return false;
    };

    gThis.ReloadCart = function(){
        return window.location.reload(false);
    };

    gThis.SubmitForm = function(){
        return gThis.m_gForm.submit();
    };

    gThis._Constructor();

};

new GPlugin('GCart', oCartDefaults, GCart);
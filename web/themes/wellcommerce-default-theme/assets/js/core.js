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
    sChangeQuantityRoute: 'front.order_cart.edit',
    sDeleteRoute: 'front.order_cart.delete'
};

var GCart = function(oOptions) {

    var gThis = this;

    gThis._Constructor = function() {
        gThis.m_gForm = $("form", gThis);
        gThis.InitializeEvents();
    };

    gThis.InitializeEvents = function(){
        $("input[type='radio']", gThis.m_gForm).bind('change', gThis.SubmitForm);
        $('.' + gThis.m_oOptions.sQuantitySpinnerClass, gThis).bind('change', gThis.ChangeItemQuantity);
    };

    gThis.ProcessResponse = function(oResponse){
        if(oResponse.success){
            return gThis.ReloadCart();
        }else{
            alert(oResponse.message);
        }
    };

    gThis.ChangeItemQuantity = function(){
        var routeParams = {
            id: $(this).data('id'),
            quantity: $(this).val()
        };

        GAjaxRequest(Routing.generate(gThis.m_oOptions.sChangeQuantityRoute, routeParams), {}, gThis.ProcessResponse);

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

/**
 * GProductAddCartForm
 */
var oProductCartAddFormDefaults = {
    sAddProductRoute: 'front.order_cart.add'
};

var GProductAddCartForm = function(oOptions) {

    var gThis = this;

    gThis._Constructor = function() {
        gThis.m_gForm = $("form", gThis);
        gThis.m_gForm.submit(gThis.OnFormSubmit);
        var variantsTotal = Object.keys(gThis.m_oOptions.aoVariants).length;
        if(variantsTotal > 0){
            $(gThis).find(gThis.m_oOptions.sAttributesSelectClass).change(function(){
                gThis.UpdateAttributes();
            });
            gThis.UpdateAttributes();
        }
    };

    gThis.UpdateAttributes = function(){
        var attributes = [];
        $(gThis).find(gThis.m_oOptions.sAttributesSelectClass).find('option:selected').each(function() {
            attributes.push($(this).data('attribute') + ':' + this.value);
        });
        attributes.sort(function(a,b){return a - b});
        var checkedVariant = attributes.join(',');

        if(gThis.m_oOptions.aoVariants[checkedVariant] != undefined){
            var variant = gThis.m_oOptions.aoVariants[checkedVariant];
            console.log(variant);
            gThis.m_oOptions.oVariant.val(variant.id);
            gThis.m_oOptions.oPrice.text(variant.finalPriceGross);
            gThis.m_gForm.find('button[type="submit"]').show();
        }else{
            gThis.m_oOptions.oVariant.val(0);
            gThis.m_gForm.find('button[type="submit"]').hide();
        }
    };

    gThis.OnFormSubmit = function(e){
        e.stopImmediatePropagation();
        var routeParams = {
            id: gThis.m_oOptions.oProduct.val(),
            variant: gThis.m_oOptions.oVariant.val(),
            quantity: gThis.m_oOptions.oQuantity.val()
        };

        GAjaxRequest(Routing.generate(gThis.m_oOptions.sAddProductRoute, routeParams), {}, gThis.ProcessResponse);

        return false;
    };

    gThis.ProcessResponse = function(oResponse){
        gThis.m_oOptions.oBasketModal.html(oResponse.basketModalContent).modal('show');
        if(oResponse.attributes != undefined) {
            gThis.m_oOptions.oBasketModal.GProductAttributes({
                aoAttributes: $.parseJSON(oResponse.attributes)
            });
        }
        if(oResponse.cartPreviewContent != undefined) {
            gThis.m_oOptions.oCartPreview.html(oResponse.cartPreviewContent);
        }
    };

    gThis._Constructor();
};

new GPlugin('GProductAddCartForm', oProductCartAddFormDefaults, GProductAddCartForm);

/**
 * GProductAddCartButton
 */
var GProductAddCartButton = function(oOptions) {

    var gThis = this;

    gThis._Constructor = function() {
        $(gThis).click(gThis.OnClick);
    };

    gThis.OnClick = function(eEvent){
        eEvent.stopImmediatePropagation();
        GAjaxRequest($(gThis).attr('href'), {}, gThis.ProcessResponse);

        return false;
    };

    gThis.ProcessResponse = function(oResponse){
        var variants = {};
        if(oResponse.templateData.variants != undefined) {
            variants = $.parseJSON(oResponse.templateData.variants)
        }
        gThis.m_oOptions.oBasketModal.html(oResponse.basketModalContent).modal('show');
        gThis.m_oOptions.oBasketModal.on('shown.bs.modal', function (e) {
            var oForm = $(this).find(gThis.m_oOptions.sAddProductFormClass);
            if(oForm.length){
                oForm.GProductAddCartForm({
                    sAddProductRoute: gThis.m_oOptions.sAddProductRoute,
                    oProduct: $(gThis.m_oOptions.sProductSelector, gThis.m_oOptions.oBasketModal),
                    oVariant: $(gThis.m_oOptions.sVariantSelector, gThis.m_oOptions.oBasketModal),
                    oQuantity: $(gThis.m_oOptions.sQuantitySelector, gThis.m_oOptions.oBasketModal),
                    oPrice: $(gThis.m_oOptions.sPriceSelector, gThis.m_oOptions.oBasketModal),
                    oBasketModal: gThis.m_oOptions.oBasketModal,
                    oCartPreview: gThis.m_oOptions.oCartPreview,
                    sAttributesSelectClass: gThis.m_oOptions.sAttributesSelectClass,
                    aoVariants: variants
                });
            }
        });

        if(oResponse.cartPreviewContent != undefined) {
            gThis.m_oOptions.oCartPreview.html(oResponse.cartPreviewContent);
        }
    };

    gThis._Constructor();
};

new GPlugin('GProductAddCartButton', {}, GProductAddCartButton);

var oCouponDefaults = {
    sAddCouponRoute:      'front.coupon.add',
    sRemoveCouponRoute:   'front.coupon.delete',
    sCodeInputIdentifier: 'coupon_code',
    sAddButtonIdentifier: 'use_coupon',
    sRemoveButtonIdentifier: 'use_coupon'
};

var GCoupon = function(oOptions) {

    var gThis = this;

    gThis._Constructor = function() {
        gThis.InitializeEvents();
    };

    gThis.InitializeEvents = function(){
        $('#' + gThis.m_oOptions.sAddButtonIdentifier, gThis).bind('click', gThis.AddCoupon);
        $('#' + gThis.m_oOptions.sRemoveButtonIdentifier, gThis).bind('click', gThis.RemoveCoupon);
    };

    gThis.ProcessResponse = function(oResponse){
        if(oResponse.success){
            return gThis.ReloadCart();
        }else{
            alert(oResponse.message);
        }
    };

    gThis.AddCoupon = function(){
        var oRequestParams = {
            code: $('#' + gThis.m_oOptions.sCodeInputIdentifier, gThis).val()
        };

        GAjaxRequest(Routing.generate(gThis.m_oOptions.sAddCouponRoute), oRequestParams, function(oResponse){
            if(oResponse.success){
                return window.location.reload(false);
            }else{
                alert(oResponse.message);
            }
        });

        return false;
    };

    gThis.RemoveCoupon = function(){
        GAjaxRequest(Routing.generate(gThis.m_oOptions.sRemoveCouponRoute), {}, function(oResponse){
            if(oResponse.success){
                return window.location.reload(false);
            }else{
                alert(oResponse.message);
            }
        });

        return false;
    };

    gThis._Constructor();

};

new GPlugin('GCoupon', oCouponDefaults, GCoupon);

var oLayeredNavigationDefaults = {
    sFilterRoute:      'front.product_layered.filter',
    sCurrentRoute:      '',
    sCurrentRouteParams: {},
    sCurrentQueryParams: {},
};

var GLayeredNavigation = function(oOptions) {

    var gThis = this;

    gThis._Constructor = function() {
        gThis.InitializeEvents();
    };

    gThis.InitializeEvents = function(){
        $(gThis).bind('submit', gThis.OnSubmit);
    };

    gThis.OnSubmit = function(){
        var oRequest = {
            form: $(gThis).serialize(),
            route: gThis.m_oOptions.sCurrentRoute,
            route_params: gThis.m_oOptions.sCurrentRouteParams,
            query_params: gThis.m_oOptions.sCurrentQueryParams,
        };

        GAjaxRequest(Routing.generate(gThis.m_oOptions.sFilterRoute), oRequest, function(oResponse){
            if(oResponse.success){
                return window.location.href = oResponse.redirectUrl;
            }else{
                alert(oResponse.message);
            }
        });

        return false;
    };

    gThis._Constructor();
};

new GPlugin('GLayeredNavigation', oLayeredNavigationDefaults, GLayeredNavigation);

var oSearchDefaultParams = {
    sProductSearchRoute:      'front.search.index',
    sProductLiveSearchRoute:  'front.search.quick',
    sPhraseInputSelector:     'form#search #phrase',
    sSearchResultsSelector:   'div#search-results',
    oAddCartButtonSettings:   {}
};

var GSearch = function(oOptions) {

    var gThis = this;

    gThis._Constructor = function() {
        gThis.InitializeEvents();
    };

    gThis.InitializeEvents = function(){
        $(gThis).bind('submit', gThis.OnSubmit);

        var options = {
            callback: gThis.OnLiveSearch,
            wait: 250,
            highlight: false,
            captureLength: 3
        };

        $(gThis.m_oOptions.sPhraseInputSelector, gThis).typeWatch(options);
    };

    gThis.OnLiveSearch = function(sPhrase){
        if(sPhrase.length > 2){
            var oRouteParams = {
                phrase: sPhrase
            };

            var url = Routing.generate(gThis.m_oOptions.sProductLiveSearchRoute, oRouteParams, true);
            GAjaxRequest(url, {}, function(oResponse){
                if(oResponse.liveSearchContent != undefined) {
                    $(gThis.m_oOptions.sSearchResultsSelector).html(oResponse.liveSearchContent);
                    $(gThis.m_oOptions.sSearchResultsSelector).find('.add-cart').GProductAddCartButton(gThis.m_oOptions.oAddCartButtonSettings);
                }
            });
        }else{
            $(gThis.m_oOptions.sSearchResultsSelector).html('');
        }
    };

    gThis.OnSubmit = function(eEvent){
        eEvent.stopImmediatePropagation();

        var oRouteParams = {
            phrase: $(gThis.m_oOptions.sPhraseInputSelector, gThis).val()
        };

        var url = Routing.generate(gThis.m_oOptions.sProductSearchRoute, oRouteParams, true);

        window.location.href = Routing.generate(gThis.m_oOptions.sProductSearchRoute, oRouteParams, true);

        return false;
    };

    gThis._Constructor();
};

new GPlugin('GSearch', oSearchDefaultParams, GSearch);

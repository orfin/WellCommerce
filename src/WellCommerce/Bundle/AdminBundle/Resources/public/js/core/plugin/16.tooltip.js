var oDefaults = {
    bClickToHide: false,
    iPositionX: 0,
    iPositionY: 0,
    iOffsetX: -27,
    iOffsetY: -34,
    jContent: $('<div/>'),
    bAutoShow: false,
    oClasses: {
        sTooltipClass: 'tooltip',
        sNEClass: 'tooltip-ne',
        sSEClass: 'tooltip-se',
        sSWClass: 'tooltip-sw',
        sSClass: 'tooltip-s',
        sEClass: 'tooltip-e',
        sWClass: 'tooltip-w',
        sNWClass: 'tooltip-nw'
    }
};

var GTooltip = function () {

    var gThis = this;

    gThis.m_iHeight = 0;

    this._Constructor = function () {
        GTooltip.s_oTooltips[gThis.m_iId] = gThis;
        gThis._PrepareTooltip();
    };

    gThis._PrepareTooltip = function () {
        $(gThis).append(gThis.m_oOptions.jContent).css({
            position: 'absolute',
            left: 0,
            bottom: 0,
            zIndex: 1000,
            display: 'none'
        });
        $(gThis).append('<span class="' + gThis._GetClass('W') + '"/>');
        $(gThis).append('<span class="' + gThis._GetClass('NW') + '"/>');
        $(gThis).append('<span class="' + gThis._GetClass('NE') + '"/>');
        $(gThis).append('<span class="' + gThis._GetClass('SE') + '"/>');
        $(gThis).append('<span class="' + gThis._GetClass('SW') + '"/>');
        $(gThis).append('<span class="' + gThis._GetClass('S') + '"/>');
        $(gThis).append('<span class="' + gThis._GetClass('E') + '"/>');
        if (gThis.m_oOptions.bAutoShow) {
            gThis._ShowTooltip(gThis.m_oOptions.iPositionX, gThis.m_oOptions.iPositionY);
        }
    };

    gThis._ShowTooltip = function (iX, iY) {
        $('.GTooltip').not($(gThis)).each(function () {
            this._HideTooltip();
        });
        $(gThis).stop(true, true).css({
            left: iX + gThis.m_oOptions.iOffsetX,
            bottom: $('body').height() - (iY + gThis.m_oOptions.iOffsetY - gThis.m_iHeight)
        }).fadeIn(150);
    };

    gThis._HideTooltip = function () {
        $(gThis).stop(true, true).fadeOut(50, function () {
            $(this).remove();
        });
    };

    gThis._Constructor();

};

GTooltip.Create = function (oOptions) {
    var jTooltip = $('<div/>');
    $('body').append(jTooltip);
    jTooltip.GTooltip(oOptions);
    return jTooltip.get(0).m_iId;
};

GTooltip.ShowThumbForThis = GEventHandler(function (eEvent) {
    eEvent.stopImmediatePropagation();
    eEvent.preventDefault();
    var jTooltip = $('<div/>');
    jTooltip.append('<img src="' + $(this).attr('href') + '" alt=""/>');
    this.m_iTooltipId = GTooltip.Create({
        bClickToHide: true,
        iPositionX: eEvent.pageX,
        iPositionY: eEvent.pageY,
        jContent: jTooltip,
        bAutoShow: true
    });
    return false;
});

GTooltip.HideThumbForThis = GEventHandler(function (eEvent) {
    eEvent.stopImmediatePropagation();
    eEvent.preventDefault();
    if (GTooltip.s_oTooltips[this.m_iTooltipId] != undefined) {
        GTooltip.s_oTooltips[this.m_iTooltipId]._HideTooltip();
        delete GTooltip.s_oTooltips[this.m_iTooltipId];
    }
    return false;
});

GTooltip.ShowInfoForThis = GEventHandler(function (eEvent) {
    eEvent.stopImmediatePropagation();
    eEvent.preventDefault();
    var jTooltip = $('<div/>');
    jTooltip.append('<span>' + $(this).attr('title') + '</span>');
    this.m_iTooltipId = GTooltip.Create({
        bClickToHide: true,
        iPositionX: eEvent.pageX,
        iPositionY: eEvent.pageY,
        jContent: jTooltip,
        bAutoShow: true
    });
    return false;
});

GTooltip.HideInfoForThis = GEventHandler(function (eEvent) {
    eEvent.stopImmediatePropagation();
    eEvent.preventDefault();
    if (GTooltip.s_oTooltips[this.m_iTooltipId] != undefined) {
        GTooltip.s_oTooltips[this.m_iTooltipId]._HideTooltip();
        delete GTooltip.s_oTooltips[this.m_iTooltipId];
    }
    return false;
});

GTooltip.s_oTooltips = {};

new GPlugin('GTooltip', oDefaults, GTooltip);
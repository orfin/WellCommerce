var oDefaults = {
    oClasses: {},
    sBackground: '#fff',
    fOpacity: .75,
    iZIndex: 1001
};

var GLoading = function () {

    var gThis = this;

    gThis.m_jOverlay;
    gThis.m_jIcon;

    gThis._Constructor = function () {
        gThis.m_jOverlay = $('<div class="GLoading"/>').css({
            display: 'block',
            position: 'absolute',
            left: $(gThis).offset().left,
            top: $(gThis).offset().top,
            width: $(gThis).width(),
            height: $(gThis).height(),
            zIndex: gThis.m_oOptions.iZIndex,
            opacity: 0,
            background: gThis.m_oOptions.sBackground
        });
        gThis.m_jIcon = $('<div class="GLoading_icon"/>').css({
            display: 'block',
            position: 'absolute',
            left: $(gThis).offset().left,
            top: $(gThis).offset().top,
            width: $(gThis).width(),
            height: $(gThis).height(),
            zIndex: gThis.m_oOptions.iZIndex,
            opacity: 0
        });
        $('body').append(gThis.m_jOverlay).append(gThis.m_jIcon);
        gThis.m_jOverlay.animate({
            duration: 500,
            opacity: gThis.m_oOptions.fOpacity
        });
        gThis.m_jIcon.animate({
            duration: 500,
            opacity: 1
        });
        $(gThis).resize(GEventHandler(function (eEvent) {
            gThis.m_jOverlay.css({
                width: $(gThis).width(),
                height: $(gThis).height()
            });
            gThis.m_jIcon.css({
                width: $(gThis).width(),
                height: $(gThis).height()
            });
        }));
    };

    gThis.StopLoading = function () {
        gThis.m_jOverlay.stop(true, true).animate({
            duration: 500,
            opacity: 0
        }, function () {
            $(this).remove();
        });
        gThis.m_jIcon.stop(true, true).animate({
            duration: 500,
            opacity: 0
        }, function () {
            $(this).remove();
        });
        $(gThis).removeClass('GLoading');
    };

    gThis._Constructor();

};

GLoading.Stop = function (jNode) {
    return jNode.get(0).StopLoading();
};

GLoading.RemoveAll = function () {
    $('.GLoading, GLoading_icon').remove();
};

new GPlugin('GLoading', oDefaults, GLoading);
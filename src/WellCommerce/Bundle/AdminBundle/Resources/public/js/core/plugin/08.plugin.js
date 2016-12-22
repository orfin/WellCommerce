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
    return false;
};
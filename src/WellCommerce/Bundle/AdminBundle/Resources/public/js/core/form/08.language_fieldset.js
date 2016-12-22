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
    sLabel: '',
    oClasses: {
        sRepetitionClass: 'GFormRepetition',
        sAddButtonClass: 'add-repetition',
        sDeleteButtonClass: 'delete-repetition'
    },
    oImages: {
        sDelete: 'images/buttons/small-delete.png',
        sAdd: 'images/buttons/small-add.png'
    },
    aoFields: [],
    aoLanguages: [],
    agFields: [],
    oRepeat: {
        iMin: 1,
        iMax: 1
    },
    sClass: ''
};

var GFormLanguageFieldset = GCore.ExtendClass(GFormLanguageContainer, function () {

    var gThis = this;

    gThis.m_jAdd;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<fieldset/>');
        gThis.m_jNode.addClass(gThis.m_oOptions.sClass);
        gThis.m_jNode.attr('id', gThis.m_oOptions.sName);
        gThis.m_jNode.addClass('repeatable');

    };

    gThis._InitializeEvents = function () {
        gThis.m_jNode.bind('GFormShow', function () {
            gThis.m_gForm.m_bFocused = false;
            gThis.OnShow();
        });
        return false;
    };

    gThis.OnShow = function () {

        var aKeys = [];
        for (i in gThis.m_oContainerRepetitions) {
            aKeys.push(i);
        }
        aKeys.sort();
        for (i = 0; i < aKeys.length; i++) {
            var j = aKeys[i];
            gThis.m_oContainerRepetitions[j].OnShow();
            if (!gThis.m_gForm.m_bFocused) {
                gThis.m_gForm.m_bFocused = gThis.m_oContainerRepetitions[j].Focus();
            }
        }

        return gThis.m_gForm.m_bFocused;
    };

}, oDefaults);
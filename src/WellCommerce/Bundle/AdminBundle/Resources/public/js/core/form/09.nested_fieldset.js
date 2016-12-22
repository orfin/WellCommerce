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
    agFields: [],
    oRepeat: {
        iMin: 1,
        iMax: 1
    },
    sClass: ''
};

var GFormNestedFieldset = GCore.ExtendClass(GFormContainer, function () {

    var gThis = this;

    gThis.m_jAdd;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<fieldset/>');
        gThis.m_jNode.addClass(gThis.m_oOptions.sClass);
        gThis.m_jNode.attr('id', gThis.m_oOptions.sName);
        gThis.m_jNode.append('<legend><span>' + gThis.m_oOptions.sLabel + '</span></legend>');
        if (!gThis.m_bRepeatable) {
            gThis.m_jNode.append(gThis.RenderChildren());
        }
        else {
            gThis.m_jNode.addClass('repeatable');
            gThis.m_jAdd = $('<a href="#" class="' + gThis._GetClass('AddButton') + '"/>');
            gThis.m_jAdd.append('<img src="' + gThis._GetImage('Add') + '" alt="' + GForm.Language.add_repetition + '" title="' + GForm.Language.add_repetition + '"/>');
            gThis.m_jNode.append(gThis.m_jAdd);
            if (GCore.ObjectLength(gThis.m_oContainerRepetitions) >= gThis.m_oOptions.oRepeat.iMax) {
                gThis.m_jAdd.css('display', 'none');
            }
        }
    };

    gThis._InitializeEvents = function () {
        gThis.m_jNode.bind('GFormShow', function () {
            gThis.m_gForm.m_bFocused = false;
            gThis.OnShow();
        });
        if (gThis.m_bRepeatable) {
            gThis.m_jAdd.click(function () {
                gThis.AddRepetition();
                if (GCore.ObjectLength(gThis.m_oContainerRepetitions) >= gThis.m_oOptions.oRepeat.iMax) {
                    gThis.m_jAdd.css('display', 'none');
                }
                if (GCore.ObjectLength(gThis.m_oContainerRepetitions) > gThis.m_oOptions.oRepeat.iMin) {
                    gThis.m_jNode.find('.' + gThis._GetClass('Repetition') + ' > .' + gThis._GetClass('DeleteButton')).css('display', 'block');
                }
                return false;
            });
        }
    };

    gThis.OnShow = function () {
        if (gThis.m_bRepeatable) {
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
        }
        else {

            for (var i = 0; i < gThis.m_oOptions.agFields.length; i++) {
                gThis.m_oOptions.agFields[i].OnShow();
                if (!gThis.m_gForm.m_bFocused) {
                    gThis.m_gForm.m_bFocused = gThis.m_oOptions.agFields[i].Focus();
                }
            }
        }

        gThis.m_jNode.find('input,select').bind('change', GEventHandler(function (eEvent) {
            var jPanel = $(eEvent.currentTarget).closest('.ui-tabs-panel');
            $('a[href="#' + jPanel.attr('id') + '"]').addClass('changed');
        }));

        return gThis.m_gForm.m_bFocused;
    };

}, oDefaults);
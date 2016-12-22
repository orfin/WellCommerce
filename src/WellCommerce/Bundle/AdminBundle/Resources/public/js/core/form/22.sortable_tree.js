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
        sFieldClass: 'field-tree',
        sFieldSpanClass: 'field',
        sPrefixClass: 'prefix',
        sSuffixClass: 'suffix',
        sFocusedClass: 'focus',
        sInvalidClass: 'invalid',
        sRequiredClass: 'required',
        sWaitingClass: 'waiting',
        sItemNameClass: 'item-name',
        sExpanderClass: 'expander',
        sExpandedClass: 'expanded',
        sActiveClass: 'active',
        sButtonClass: 'button',
        sExpandAllClass: 'expand-all',
        sRetractAllClass: 'retract-all'
    },
    oImages: {
        sAdd: 'images/icons/buttons/add.png',
        sDuplicate: 'images/icons/buttons/duplicate.png',
        sDelete: 'images/icons/buttons/delete.png',
        sSave: 'images/icons/buttons/save.png',
        sRestore: 'images/icons/buttons/clean.png',
        sWaiting: 'images/icons/loading/indicator.gif'
    },
    aoOptions: [],
    sDefault: '',
    aoRules: [],
    sComment: '',
    bSortable: false,
    iTotal: 0,
    iRestrict: 0,
    bSelectable: true,
    bChoosable: false,
    bClickable: false,
    bDeletable: false,
    bRetractable: true,
    oItems: {},
    fOnClick: GCore.NULL,
    fOnDuplicate: GCore.NULL,
    fOnSaveOrder: GCore.NULL,
    fOnAdd: GCore.NULL,
    fOnAfterAdd: GCore.NULL,
    fOnDelete: GCore.NULL,
    fOnAfterDelete: GCore.NULL,
    sOnAfterDeleteId: 0,
    sActive: '',
    sAddItemPrompt: '',
    bPreventDuplicates: true,
    bPreventDuplicatesOnAllLevels: false
};

var GFormTree = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bShown = false;
    gThis.m_jTree;
    gThis.m_jOptions;
    gThis.m_oItems;
    gThis.m_jExpandAll;
    gThis.m_jRetractAll;
    gThis.m_jFieldWrapper;
    gThis.m_jItemPlaceholder;
    gThis.m_jItemDragged;
    gThis.m_oItems = {};
    gThis.m_jUnmodified;

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        gThis.m_jField = $('<input type="hidden"/>');
        gThis.m_jNode.append(gThis.m_jField);
        gThis.m_jFieldWrapper = $('<div/>');
        gThis.m_jNode.append(gThis.m_jFieldWrapper);
        gThis.m_jNode.append('<label>' + gThis.m_oOptions.sLabel + '</label>');
        gThis.m_jExpandAll = $('<a href="#"/>').text(GForm.Language.tree_expand_all);
        gThis.m_jRetractAll = $('<a href="#"/>').text(GForm.Language.tree_retract_all).css('visibility', 'hidden');
        if (gThis.m_oOptions.bRetractable) {
            gThis.m_jNode.append($('<p class="' + gThis._GetClass('RetractAll') + '"/>').append(gThis.m_jRetractAll));
        }
        gThis.m_jTree = $('<ul/>');
        if (gThis.m_oOptions.iTotal > 0) {
            gThis.m_jNode.append($('<div class="tree-wrapper"/>').append(gThis.m_jTree));
        }
        gThis.Update();
        gThis._PrepareOptions();
        window.setTimeout(gThis.ResetExpansion, 500);
        gThis.m_jUnmodified = $('<input type="hidden" name="' + gThis.GetName() + '[unmodified]" value="1"/>');
        if (!gThis.m_oOptions.bChoosable) {
            gThis.m_jNode.append(gThis.m_jUnmodified);
        }
    };


    gThis.OnRetractAll = function () {
        gThis.m_jTree.find('li:has(li)').removeClass(gThis._GetClass('Expanded'));
        return false;
    };

    gThis._PrepareOptions = function () {
        var jA;
        gThis.m_jOptions = $('<div class="options"/>');

        if (gThis.m_oOptions.bAddable && (gThis.m_oOptions.fOnAdd instanceof Function)) {

            jA = $('<a id="add-category" class="' + gThis._GetClass('Button') + '" href="#"/>');
            jA.append('<span><img src="' + gThis._GetImage('Add') + '" alt=""/>' + gThis.m_oOptions.sAddLabel + '</span>');
            jA.click(function (eEvent) {
                GAlert.DestroyAll();
                GPrompt(gThis.m_oOptions.sAddItemPrompt, function (sName) {
                    if (gThis.m_oOptions.bPreventDuplicatesOnAllLevels) {
                        var jSiblings = gThis.m_jTree.find('li');
                        for (var i = 0; i < jSiblings.length; i++) {
                            if (sName == jSiblings.eq(i).children('a').text()) {
                                GAlert.DestroyThis.apply(this);
                                GError(GForm.Language.tree_duplicate_entry_all_levels, GForm.Language.tree_duplicate_entry_all_levels_description);
                                return;
                            }
                        }
                    }
                    else if (gThis.m_oOptions.bPreventDuplicates) {
                        var jSiblings = gThis.m_jTree.children('li');
                        for (var i = 0; i < jSiblings.length; i++) {
                            if (sName == jSiblings.eq(i).children('a').text()) {
                                GAlert.DestroyThis.apply(this);
                                GError(GForm.Language.tree_duplicate_entry, GForm.Language.tree_duplicate_entry_description);
                                return;
                            }
                        }
                    }
                    GCore.StartWaiting();
                    gThis.m_oOptions.fOnAdd({
                        name: sName
                    }, GCallback(function (eEvent) {
                        GCore.StopWaiting();
                        if (gThis.m_oOptions.fOnAfterAdd instanceof Function) {
                            gThis.m_oOptions.fOnAfterAdd(eEvent.id);
                        }
                    }));
                });
                return false;
            });
            gThis.m_jOptions.append($('<p/>').append(jA));

            if (gThis.m_oOptions.fOnDuplicate instanceof Function) {
                jB = $('<a class="' + gThis._GetClass('Button') + ' duplicate" href="#"/>');
                jB.append('<span><img src="' + gThis._GetImage('Duplicate') + '" alt=""/>' + GForm.Language.tree_duplicate_item + '</span>');
                jB.click(function (eEvent) {
                    if (gThis.m_oOptions.fOnDuplicate instanceof Function) {
                        gThis.m_oOptions.fOnDuplicate(sId);
                    }
                });
                if (gThis.m_jTree.find('.' + gThis._GetClass('Active')).length) {
                    gThis.m_jOptions.append($('<p/>').append(jB));
                }
            }


            if (gThis.m_jTree.find('.' + gThis._GetClass('Active')).length) {

                var sId = gThis.m_jTree.find('.' + gThis._GetClass('Active')).get(0).sId;
                jA = $('<a class="' + gThis._GetClass('Button') + '" href="#"/>');
                jA.append('<span><img src="' + gThis._GetImage('Add') + '" alt=""/>' + GForm.Language.tree_add_subitem + '</span>');
                jA.click(function (eEvent) {
                    GAlert.DestroyAll();
                    GPrompt(gThis.m_oOptions.sAddItemPrompt, function (sName) {
                        if (gThis.m_oOptions.bPreventDuplicatesOnAllLevels) {
                            var jSiblings = gThis.m_jTree.find('li > a');
                            for (var i = 0; i < jSiblings.length; i++) {
                                if (sName == jSiblings.eq(i).text()) {
                                    GAlert.DestroyThis.apply(this);
                                    GError(GForm.Language.tree_duplicate_entry_all_levels, GForm.Language.tree_duplicate_entry_all_levels_description);
                                    return;
                                }
                            }
                        }
                        else if (gThis.m_oOptions.bPreventDuplicates) {
                            var jSiblings = gThis.m_jTree.find('li.' + gThis._GetClass('Active') + ' > ul > li > a');
                            for (var i = 0; i < jSiblings.length; i++) {
                                if (sName == jSiblings.eq(i).text()) {
                                    GAlert.DestroyThis.apply(this);
                                    GError(GForm.Language.tree_duplicate_entry, GForm.Language.tree_duplicate_entry_description);
                                    return;
                                }
                            }
                        }
                        GCore.StartWaiting();
                        gThis.m_oOptions.fOnAdd({
                            parent: sId,
                            name: sName
                        }, GCallback(function (eEvent) {
                            GCore.StopWaiting();
                            if (gThis.m_oOptions.fOnAfterAdd instanceof Function) {
                                gThis.m_oOptions.fOnAfterAdd(eEvent.id);
                            }
                        }));
                    });
                    return false;
                });
                gThis.m_jOptions.append($('<p/>').append(jA));

            }

        }

        if (gThis.m_oOptions.bDeletable && (gThis.m_oOptions.fOnDelete instanceof Function) && gThis.m_jTree.find('.' + gThis._GetClass('Active')).length) {

            var sId = gThis.m_jTree.find('.' + gThis._GetClass('Active')).get(0).sId;
            jA = $('<a id="delete-category" class="' + gThis._GetClass('Button') + ' delete" href="#"/>');
            jA.append('<span><img src="' + gThis._GetImage('Delete') + '" alt=""/>' + GForm.Language.tree_delete_item + '</span>');
            jA.click(function (eEvent) {
                GAlert.DestroyAll();
                GWarning(GForm.Language.tree_delete_item_warning, GForm.Language.tree_delete_item_warning_description, {
                    bAutoExpand: true,
                    aoPossibilities: [
                        {
                            mLink: function () {
                                GCore.StartWaiting();
                                gThis.m_oOptions.fOnDelete({
                                    id: sId
                                }, function () {
                                    GCore.StopWaiting();
                                    if (gThis.m_oOptions.fOnAfterDelete instanceof Function) {
                                        gThis.m_oOptions.fOnAfterDelete(gThis.m_oOptions.sOnAfterDeleteId);
                                    }
                                });
                            }, sCaption: GForm.Language.tree_ok
                        },
                        {mLink: GAlert.DestroyThis, sCaption: GForm.Language.tree_cancel}
                    ]
                });
                return false;
            });
            gThis.m_jOptions.append($('<p/>').append(jA));

        }

        gThis.m_jNode.append(gThis.m_jOptions);
    };

    gThis.GetOrder = function () {
        var jItems = gThis.m_jTree.find('li');
        var aoItems = [];
        for (var i = 0; i < jItems.length; i++) {
            var sId = jItems.eq(i).get(0).sId;
            var sParent = '';
            if (jItems.eq(i).parent().closest('li').length) {
                sParent = jItems.eq(i).parent().closest('li').get(0).sId;
            }
            var jSiblings = jItems.eq(i).parent().children('li');
            var iWeight = jSiblings.index(jItems.eq(i));
            aoItems.push({
                id: sId,
                parent: sParent,
                weight: iWeight
            });
        }
        return aoItems;
    };

    gThis.GetValue = function (sRepetition) {
        if (gThis.m_oOptions.bChoosable) {
            return gThis.m_jFieldWrapper.find('input:first').attr('value');
        }
        if (gThis.m_jField == undefined) {
            return '';
        }
        var aValues = [];
        var jValues = gThis._GetField(sRepetition).filter(':checked');
        for (var i in jValues) {
            aValues.push(jValues.eq(i).attr('value'));
        }
        return aValues;
    };

    gThis.SetValue = function (mValue, sRepetition) {
        if (gThis.m_jField == undefined) {
            return;
        }
        gThis._GetField(sRepetition).val(mValue).change();
    };

    gThis.ResetExpansion = function () {
        gThis.m_jTree.find('li').removeClass(gThis._GetClass('Expanded'));
        gThis.m_jTree.find('li.' + gThis._GetClass('Active')).parents('li').andSelf().filter(':has(li)').addClass(gThis._GetClass('Expanded'));
        gThis.m_jTree.find('li > label > input:checked').parents('li').andSelf().filter(':has(li)').addClass(gThis._GetClass('Expanded'));
    };

    gThis._WriteSubtree = function (jParent, sParent) {
        if (sParent == undefined) {
            sParent = null;
        }
        var oItems = GCore.FilterObject(gThis.m_oOptions.oItems, function (oItem) {
            return (oItem.parent == sParent);
        });
        var aIterationArray = GCore.GetIterationArray(oItems, function (oA, oB) {
            return (oA.weight - oB.weight);
        });
        var iLength = aIterationArray.length;
        for (var i = 0; i < iLength; i++) {
            var sId = aIterationArray[i];
            var oItem = oItems[sId];
            jParent.append(gThis._WriteItem(sId, oItem));
        }
    };

    gThis._WriteItem = function (sId, oItem) {
        var jLi = $('<li/>');
        jLi.get(0).sId = sId;
        if (gThis.m_oOptions.sActive == sId) {
            jLi.addClass(gThis._GetClass('Active'));
            if (oItem.hasChildren) {
                gThis._Expand(jLi);
            }
        }
        if (gThis.m_oOptions.bSelectable) {
            var jField = $('<input type="checkbox" value="' + sId + '"/>');
            if (gThis.m_jFieldWrapper.find('input[value="' + sId + '"]').length) {
                jField.click();
                jField.attr('checked', 'checked');
            }
            if ((gThis.m_oOptions.bGlobal == true) && GCore.iActiveView > 0) {
                jField.attr('disabled', 'disabled');
            }
            if ((oItem.allow != undefined) && (oItem.allow == 0) && GCore.iActiveView > 0) {
                jField.attr('disabled', 'disabled');
            }
            jLi.append($('<label class="' + gThis._GetClass('ItemName') + '"/>').append(jField).append(oItem.name));
        }
        else if (gThis.m_oOptions.bChoosable) {
            var jField = $('<input type="radio" name="' + gThis.GetName() + '" value="' + sId + '"/>');
            if (gThis.m_jFieldWrapper.find('input[value="' + sId + '"]').length) {
                jField.click();
                jField.attr('checked', 'checked');
            }
            if ((gThis.m_oOptions.iRestrict > 0) && gThis.m_oOptions.iRestrict == sId) {
                jField.attr('disabled', 'disabled');
            }
            jLi.append($('<label class="' + gThis._GetClass('ItemName') + '"/>').append(jField).append(oItem.name));
        }
        else if (gThis.m_oOptions.bClickable) {
            var jA = $('<a href="#" class="' + gThis._GetClass('ItemName') + '">' + oItem.name + '</a>');
            jLi.append(jA);
        }
        else {
            jLi.append('<span class="' + gThis._GetClass('ItemName') + '">' + oItem.name + '</span>');
        }
        var jUl = $('<ul/>');
        gThis._WriteSubtree(jUl, sId);
        var jExpander = $('<span class="' + gThis._GetClass('Expander') + '"/>');
        jLi.prepend(jExpander);
        jLi.append(jUl);
        jExpander.css('display', 'none');
        if (oItem.hasChildren || jUl.children('li').length) {
            jExpander.css('display', 'block');
        }
        return jLi;
    };

    gThis.UpdateExpanders = function () {
        gThis.m_jTree.find('li::not(:has(li))').removeClass(gThis._GetClass('Expanded')).children('.' + gThis._GetClass('Expander')).css('display', 'none');
        gThis.m_jTree.find('li:has(li) > .' + gThis._GetClass('Expander')).css('display', 'block');
    };

    gThis.Update = function () {
        gThis.m_jTree.empty();
        gThis._WriteSubtree(gThis.m_jTree);
        if (gThis.m_oOptions.bSortable) {
            gThis.m_jTree.sortable({
                items: 'li',
                placeholder: 'item-faux-placeholder',
                opacity: .5,
                tolerance: 'cursor',
                cursor: 'move',
                cursorAt: 'left',
                delay: 200,
                start: function (e, ui) {
                    gThis.m_bIgnoreClick = true;
                    gThis.m_jItemPlaceholder = $('<li class="item-placeholder"/>');
                },
                change: function (e, ui) {
                },
                sort: function (e, ui) {
                    gThis.m_jTree.find('li').removeClass('temporarly-expanded');
                    if (ui.offset.left > $(ui.placeholder).prev().offset().left + 15) {
                        $(ui.placeholder).prev().addClass('temporarly-expanded');
                        gThis.m_jItemPlaceholder.appendTo($(ui.placeholder).prev().children('ul'));
                    }
                    else {
                        gThis.m_jItemPlaceholder.insertAfter($(ui.placeholder));
                    }
                },
                beforeStop: function (e, ui) {
                    gThis.m_jTree.find('li.temporarly-expanded').removeClass('temporarly-expanded').addClass('expanded');
                    gThis.m_jItemPlaceholder.replaceWith($(ui.helper));
                    gThis.UpdateExpanders();
                },
                stop: function (e, ui) {
                    if (gThis.m_oOptions.bPreventDuplicates) {
                        var jLis = gThis.m_jTree.find('li');
                        for (var i = 0; i < jLis.length; i++) {
                            var jSiblings = jLis.eq(i).nextAll('li');
                            var sItem = jLis.eq(i).children('a').text();
                            for (var j = 0; j < jSiblings.length; j++) {
                                if (sItem == jSiblings.eq(j).children('a').text()) {
                                    GError(GForm.Language.tree_found_duplicates + ': "' + sItem + '"', GForm.Language.tree_found_duplicates_description);
                                    return;
                                }
                            }
                        }
                    }
                    GCore.StartWaiting();
                    gThis.m_oOptions.fOnSaveOrder({
                        items: gThis.GetOrder()
                    }, GCallback(function (eEvent) {
                        GCore.StopWaiting();
                    }));

                    setTimeout(function () {
                        gThis.m_bIgnoreClick = false;
                    }, 500);
                }
            });
        }
        gThis._InitializeNodeEvents();
        gThis.ResetExpansion();
    };

    gThis.Populate = function (mValue) {
        if ((mValue == undefined) || (mValue == '')) {
            mValue = [];
        }

        if (gThis.m_oOptions.bChoosable) {
            gThis.m_jFieldWrapper.empty();
            gThis.m_jFieldWrapper.append('<input type="hidden" name="' + gThis.GetName() + '" value="' + mValue + '"/>');
            gThis.m_jNode.find('input:radio[value="' + mValue + '"]').click();
        }
        else if (gThis.m_oOptions.bSelectable) {
            gThis.m_jNode.unCheckCheckboxes();
            gThis.m_jFieldWrapper.empty();
            for (var i in mValue) {
                if (i == 'unmodified') {
                    continue;
                }
                gThis.m_jFieldWrapper.append('<input type="hidden" name="' + gThis.GetName() + '[' + mValue[i] + ']" value="' + mValue[i] + '"/>');
                gThis.m_jNode.find('input:checkbox[value="' + mValue[i] + '"]').parent().checkCheckboxes();
            }
        }
        gThis.ResetExpansion();
    };

    gThis.OnShow = function () {
        if (!gThis.m_bShown) {
            gThis.m_bShown = true;
            gThis.m_jUnmodified.val('0');
        }
    };

    gThis._OnClick = GEventHandler(function (eEvent) {
        GCore.StartWaiting();
    });

    gThis._InitializeEvents = function (sRepetition) {
        gThis.m_jExpandAll.click(gThis.OnExpandAll);
        gThis.m_jRetractAll.click(gThis.OnRetractAll);
        gThis._InitializeNodeEvents();
    };

    gThis._OnSelect = GEventHandler(function (eEvent) {
        if ($(this).is(':radio')) {
            gThis.m_jFieldWrapper.find('input').remove();
        }
        else {
            gThis.m_jFieldWrapper.find('input[value="' + $(this).attr('value') + '"]').remove();
        }
        if ($(this).is(':checked')) {
            var jInput = $('<input type="hidden" name="' + gThis.GetName() + ($(this).is(':radio') ? '' : '[' + $(this).attr('value') + ']') + '" value="' + $(this).attr('value') + '"/>');
            gThis.m_jFieldWrapper.append(jInput);
            for (var i in gThis.m_afDependencyTriggers) {
                gThis.m_afDependencyTriggers[i].apply(jInput.get(0), [{
                    data: {
                        gNode: gThis
                    }
                }]);
            }
        }
    });

    gThis._InitializeNodeEvents = function () {
        gThis.m_jTree.find('.' + gThis._GetClass('Expander')).unbind('click').click(function () {
            if ($(this).closest('li').hasClass(gThis._GetClass('Expanded'))) {
                $(this).closest('li').find('li').andSelf().removeClass(gThis._GetClass('Expanded'));
            }
            else {
                $(this).closest('li').addClass(gThis._GetClass('Expanded'));
                gThis._Expand($(this).closest('li'));
            }

            if (gThis.m_jTree.find('.' + gThis._GetClass('Expanded')).size() == 0) {
                gThis.m_jRetractAll.css('visibility', 'hidden');
            } else {
                gThis.m_jRetractAll.css('visibility', 'visible');
            }
        });
        if (gThis.m_oOptions.bClickable) {
            gThis.m_jTree.find('li').unbind('click').unbind('mousedown').each(function () {
                var sId = $(this).closest('li').get(0).sId;
                $(this).children('a').click(GEventHandler(function (eEvent) {
                    if (gThis.m_bIgnoreClick) {
                        return false;
                    }
                    gThis.m_jTree.find('li').removeClass(gThis._GetClass('Active'));
                    $(this).closest('li').addClass(gThis._GetClass('Active'));
                    gThis._OnClick.apply(this, [eEvent]);
                    if (gThis.m_oOptions.fOnClick instanceof Function) {
                        gThis.m_oOptions.fOnClick(sId);
                    }
                    return false;
                }));
            });
        }
        gThis.m_jTree.find('input').unbind('click').click(gThis._OnSelect);
    };

    gThis._Expand = function (jParentLi) {
        var sId = jParentLi.get(0).sId;
        if (gThis.m_oItems[sId] != undefined) {
            return;
        }
    };

    gThis._OnChildrenLoaded = GEventHandler(function (eEvent) {
        var jUl = $('<ul/>');
        gThis.m_oItems[eEvent.parentNode.get(0).sId] = true;
        var aIterationArray = GCore.GetIterationArray(eEvent.children, function (oA, oB) {
            return (oA.weight - oB.weight);
        });
        var iLength = aIterationArray.length;
        for (var i = 0; i < iLength; i++) {
            var sId = aIterationArray[i];
            jUl.append(gThis._WriteItem(sId, eEvent.children[sId]));
        }
        eEvent.parentNode.find('ul').remove();
        eEvent.parentNode.append(jUl);
        gThis._InitializeNodeEvents();
    });

}, oDefaults);
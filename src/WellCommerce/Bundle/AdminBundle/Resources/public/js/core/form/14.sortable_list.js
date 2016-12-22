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
    bClickable: false,
    bDeletable: false,
    oItems: {},
    fOnClick: GCore.NULL,
    fOnSaveOrder: GCore.NULL,
    fOnAdd: GCore.NULL,
    fOnAfterAdd: GCore.NULL,
    fOnDelete: GCore.NULL,
    fOnAfterDelete: GCore.NULL,
    sActive: '',
    sAddItemPrompt: '',
    bPreventDuplicates: true
};

var GFormSortableList = GCore.ExtendClass(GFormField, function () {

    var gThis = this;

    gThis.m_bShown = false;
    gThis.m_jTree;
    gThis.m_jOptions;
    gThis.m_oItems;
    gThis.m_jFieldWrapper;
    gThis.m_jItemPlaceholder;
    gThis.m_jItemDragged;
    gThis.m_oItems = {};

    gThis._PrepareNode = function () {
        gThis.m_jNode = $('<div/>').addClass(gThis._GetClass('Field'));
        gThis.m_jField = $('<input type="hidden"/>');
        gThis.m_jNode.append(gThis.m_jField);
        gThis.m_jFieldWrapper = $('<div/>');
        gThis.m_jNode.append(gThis.m_jFieldWrapper);
        gThis.m_jNode.append('<label>' + gThis.m_oOptions.sLabel + '</label>');
        gThis.m_jTree = $('<ul/>');
        if (gThis.m_oOptions.iTotal > 0) {
            gThis.m_jNode.append($('<div class="tree-wrapper"/>').append(gThis.m_jTree));
        }
        gThis.Update();
        gThis._PrepareOptions();
        window.setTimeout(gThis.ResetExpansion, 500);
    };

    gThis._PrepareOptions = function () {
        var jA;
        gThis.m_jOptions = $('<div class="options"/>');

        if (gThis.m_oOptions.bSortable && (gThis.m_oOptions.fOnSaveOrder instanceof Function)) {
            jA = $('<a class="' + gThis._GetClass('Button') + '" href="#"/>');
            jA.append('<span><img src="' + gThis._GetImage('Save') + '" alt=""/>' + GForm.Language.tree_save_order + '</span>');
            jA.click(function (eEvent) {
                GCore.StartWaiting();
                gThis.m_oOptions.fOnSaveOrder({
                    items: gThis.GetOrder()
                }, GCallback(function (eEvent) {
                    GCore.StopWaiting();
                    GMessage(eEvent.status);
                }));
                return false;
            });
            gThis.m_jOptions.append($('<p/>').append(jA));

            jA = $('<a class="' + gThis._GetClass('Button') + '" href="#"/>');
            jA.append('<span><img src="' + gThis._GetImage('Restore') + '" alt=""/>' + GForm.Language.tree_restore_order + '</span>');
            jA.click(function (eEvent) {
                gThis.Update();
                return false;
            });
            gThis.m_jOptions.append($('<p/>').append(jA));

        }

        if (gThis.m_oOptions.bAddable && (gThis.m_oOptions.fOnAdd instanceof Function)) {

            jA = $('<a class="' + gThis._GetClass('Button') + '" href="#"/>');
            jA.append('<span><img src="' + gThis._GetImage('Add') + '" alt=""/>' + GForm.Language.tree_add_item + '</span>');
            jA.click(function (eEvent) {
                GAlert.DestroyAll();
                GPrompt(gThis.m_oOptions.sAddItemPrompt, function (sName) {
                    if (gThis.m_oOptions.bPreventDuplicates) {
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

        }

        if (gThis.m_oOptions.bDeletable && (gThis.m_oOptions.fOnDelete instanceof Function) && gThis.m_jTree.find('.' + gThis._GetClass('Active')).length) {

            var sId = gThis.m_jTree.find('.' + gThis._GetClass('Active')).get(0).sId;
            jA = $('<a class="' + gThis._GetClass('Button') + ' delete" href="#"/>');
            jA.append('<span><img src="' + gThis._GetImage('Delete') + '" alt=""/>' + GForm.Language.tree_delete_item + '</span>');
            jA.click(function (eEvent) {
                GAlert.DestroyAll();
                GWarning(gThis.m_oOptions.sDeleteItemPrompt, '', {
                    bAutoExpand: true,
                    aoPossibilities: [
                        {
                            mLink: function () {
                                GCore.StartWaiting();
                                gThis.m_oOptions.fOnDelete({
                                    id: sId
                                }, GCallback(function (eEvent) {
                                    GCore.StopWaiting();
                                    if (gThis.m_oOptions.fOnAfterDelete instanceof Function) {
                                        gThis.m_oOptions.fOnAfterDelete();
                                    }
                                }));
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
        }

        if (gThis.m_oOptions.bClickable) {
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
        gThis.m_jTree.sortable();
        gThis._InitializeNodeEvents();
        gThis.ResetExpansion();
    };

    gThis.OnShow = function () {
        if (!gThis.m_bShown) {
            gThis.m_bShown = true;
        }
    };

    gThis._OnClick = GEventHandler(function (eEvent) {
        GCore.StartWaiting();
    });

    gThis._InitializeEvents = function (sRepetition) {
        gThis._InitializeNodeEvents();
    };

    gThis._InitializeNodeEvents = function () {
        gThis.m_jTree.find('.' + gThis._GetClass('Expander')).unbind('click').click(function () {
            if ($(this).closest('li').hasClass(gThis._GetClass('Expanded'))) {
                $(this).closest('li').find('li').andSelf().removeClass(gThis._GetClass('Expanded'));
            }
            else {
                $(this).closest('li').addClass(gThis._GetClass('Expanded'));
                gThis._Expand($(this).closest('li'));
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

    gThis._OnChildrenLoaded = GEventHandler(function (eEvent) {
        var jUl = $('<ul/>');
        gThis.m_oItems[eEvent.parentNode.get(0).sId] = true;
        for (var i in eEvent.children) {
            jUl.append(gThis._WriteItem(i, eEvent.children[i]));
        }
        eEvent.parentNode.find('ul').remove();
        eEvent.parentNode.append(jUl);
        gThis._InitializeNodeEvents();
    });

}, oDefaults);
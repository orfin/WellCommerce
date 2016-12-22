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
    }
};

var GFormRepeatableFieldset = GCore.ExtendClass(GFormNestedFieldset, function () {

}, oDefaults);
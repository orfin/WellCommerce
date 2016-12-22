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

var GFormCondition = function (sCondition, mArgument) {

    var gThis = this;

    gThis.m_sType = sCondition;
    gThis.m_mArgument = mArgument;

    gThis.Evaluate = function (mValue) {
        switch (gThis.m_sType) {

            // EQUALS
            case GFormCondition.EQUALS:
                if (gThis.m_mArgument instanceof GFormCondition) {
                    return false;
                }
                else if (gThis.m_mArgument instanceof Array) {
                    return $.inArray(mValue, gThis.m_mArgument) != -1;
                }
                else {
                    return mValue == gThis.m_mArgument;
                }
                break;

            // GE
            case GFormCondition.GE:
                if (gThis.m_mArgument instanceof GFormCondition) {
                    return false;
                }
                else {
                    return mValue >= gThis.m_mArgument;
                }
                break;

            // LE
            case GFormCondition.LE:
                if (gThis.m_mArgument instanceof GFormCondition) {
                    return false;
                }
                else {
                    return mValue <= gThis.m_mArgument;
                }
                break;

            // NOT
            case GFormCondition.NOT:
                if (gThis.m_mArgument instanceof GFormCondition) {
                    return !gThis.m_mArgument.Evaluate(mValue);
                }
                else {
                    return false;
                }
                break;

            // AND
            case GFormCondition.AND:
                if (gThis.m_mArgument instanceof GFormCondition) {
                    return true;
                }
                else if (gThis.m_mArgument instanceof Array) {
                    for (var i = 0; i < gThis.m_mArgument.length; i++) {
                        if (!(gThis.m_mArgument[i] instanceof GFormCondition) || !gThis.m_mArgument[i].Evaluate(mValue)) {
                            return false;
                        }
                    }
                    return true;
                }
                else {
                    return false;
                }
                break;

            // OR
            case GFormCondition.OR:
                if (gThis.m_mArgument instanceof GFormCondition) {
                    return true;
                }
                else if (gThis.m_mArgument instanceof Array) {
                    for (var i = 0; i < gThis.m_mArgument.length; i++) {
                        if (!(gThis.m_mArgument[i] instanceof GFormCondition)) {
                            return false;
                        }
                        if (gThis.m_mArgument[i].Evaluate(mValue)) {
                            return true;
                        }
                    }
                    return true;
                }
                else {
                    return false;
                }
                break;

        }
        ;
        return true;
    };

};

GFormCondition.EQUALS = '=';
GFormCondition.GE = '>=';
GFormCondition.LE = '<=';
GFormCondition.NOT = '!';
GFormCondition.AND = '&&';
GFormCondition.OR = '||';
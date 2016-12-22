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
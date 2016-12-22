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

var GLink = function (jA, mLink) {
    if (mLink instanceof Function) {
        jA.attr('href', '#');
        jA.click(function (eEvent) {
            mLink.apply(jA, [eEvent]);
            return false;
        });
    }
    else {
        jA.attr('href', mLink);
    }
};
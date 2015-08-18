<?php
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

namespace WellCommerce\Bundle\IntlBundle\Purger;

use WellCommerce\Bundle\CoreBundle\Purger\AbstractPurger;
use WellCommerce\Bundle\CoreBundle\Purger\PurgerInterface;

class DictionaryPurger extends AbstractPurger implements PurgerInterface
{
    /**
     * {@inheritdoc}
     */
    public function purge()
    {
        return $this->helper->truncateTable('WellCommerce\Bundle\IntlBundle\Entity\Dictionary');
    }
}

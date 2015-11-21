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

namespace WellCommerce\CommonBundle\Purger;

use WellCommerce\CoreBundle\Service\Purger\AbstractPurger;
use WellCommerce\CoreBundle\Service\Purger\PurgerInterface;

class DictionaryPurger extends AbstractPurger implements PurgerInterface
{
    /**
     * {@inheritdoc}
     */
    public function purge()
    {
        return $this->getDoctrineHelper()->truncateTable('WellCommerce\CommonBundle\Entity\Dictionary');
    }
}

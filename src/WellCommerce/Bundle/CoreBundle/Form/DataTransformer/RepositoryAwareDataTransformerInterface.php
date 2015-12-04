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

namespace WellCommerce\Bundle\CoreBundle\Form\DataTransformer;

use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Component\Form\DataTransformer\DataTransformerInterface;

/**
 * Interface RepositoryAwareDataTransformerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RepositoryAwareDataTransformerInterface extends DataTransformerInterface
{
    /**
     * @param RepositoryInterface $repository
     */
    public function setRepository(RepositoryInterface $repository);
}

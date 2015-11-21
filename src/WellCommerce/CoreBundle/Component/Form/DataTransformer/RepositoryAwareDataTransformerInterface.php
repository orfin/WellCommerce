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

namespace WellCommerce\CoreBundle\Component\Form\DataTransformer;

use WellCommerce\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\CoreBundle\Component\Form\DataTransformer\DataTransformerInterface;

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

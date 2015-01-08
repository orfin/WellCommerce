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

namespace WellCommerce\Bundle\UserBundle\Repository;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\DataSetAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface UserRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserRepositoryInterface extends DataSetAwareRepositoryInterface, RepositoryInterface, UserProviderInterface
{

}
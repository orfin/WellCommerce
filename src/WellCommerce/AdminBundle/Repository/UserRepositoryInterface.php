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

namespace WellCommerce\AdminBundle\Repository;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use WellCommerce\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface UserRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserRepositoryInterface extends RepositoryInterface, UserProviderInterface
{

}

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

namespace WellCommerce\AdminBundle\Provider;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\AdminBundle\Repository\AdminMenuRepositoryInterface;

/**
 * Class AdminMenuProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuProvider
{
    /**
     * @var AdminMenuRepositoryInterface
     */
    protected $adminMenuRepository;

    /**
     * Constructor
     *
     * @param AdminMenuRepositoryInterface $adminMenuRepository
     */
    public function __construct(AdminMenuRepositoryInterface $adminMenuRepository)
    {
        $this->adminMenuRepository = $adminMenuRepository;
    }

    public function getMenu()
    {
        $criteria = new Criteria();
        $criteria->orderBy(['hierarchy' => 'asc']);
        $criteria->andWhere($criteria->expr()->eq('parent', null));

        return $this->adminMenuRepository->matching($criteria);
    }
}

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

namespace WellCommerce\Plugin\Producer\Controller\Box;

use WellCommerce\Core\Component\Controller\Box\AbstractBoxController;
use WellCommerce\Plugin\Producer\Repository\ProducerRepositoryInterface;

/**
 * Class ProducerBoxController
 *
 * @package WellCommerce\Plugin\Producer\Controller\Frontend
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerBoxController extends AbstractBoxController
{
    private $repository;

    public function indexAction()
    {
        $producers = $this->repository->getAllProducerToSelect();

        return [
            'producers' => $producers
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository(ProducerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
} 
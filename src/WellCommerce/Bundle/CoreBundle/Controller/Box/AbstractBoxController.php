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
namespace WellCommerce\Bundle\CoreBundle\Controller\Box;

use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class AbstractFrontController
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractBoxController extends AbstractController implements BoxControllerInterface
{
    protected $settings;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param ContainerInterface  $container
     * @param RepositoryInterface $repository
     */
    public function __construct(
        ContainerInterface $container,
        RepositoryInterface $repository
    ) {
        $this->container  = $container;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    protected function getBoxId()
    {
        return $this->getParam('_box_id');
    }

    /**
     * {@inheritdoc}
     */
    protected function getBoxSetting($id)
    {
        $accessor = $this->getPropertyAccessor();

        return $accessor->getValue($this->getParam('_box_settings'), '[' . $id . ']');
    }

    protected function setBoxSettings($settings)
    {
        $this->settings = $settings;
    }


}
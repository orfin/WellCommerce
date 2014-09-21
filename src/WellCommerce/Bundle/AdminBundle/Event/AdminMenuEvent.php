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
namespace WellCommerce\Bundle\AdminBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Bundle\AdminBundle\MenuBuilder\AdminMenuBuilderInterface;

/**
 * Class AdminMenuEvent
 *
 * @package WellCommerce\Bundle\AdminBundle\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuEvent extends Event
{
    const INIT_EVENT = 'admin_menu.init';

    /**
     * @var AdminMenuBuilderInterface
     */
    protected $builder;

    /**
     * Constructor
     *
     * @param AdminMenuBuilderInterface $builder
     */
    public function __construct(AdminMenuBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Returns admin menu builder object
     *
     * @return AdminMenuBuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
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
namespace WellCommerce\Bundle\CoreBundle\Form;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Container\ContainerInterface;

/**
 * Class AbstractForm
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractForm extends AbstractContainer
{
    public function addContainer(ContainerInterface $container){

    }

}
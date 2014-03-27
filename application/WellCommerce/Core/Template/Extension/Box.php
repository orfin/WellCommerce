<?php

/**
 * WellCommerce, Open Source E-Commerce Solution
 * 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed with this source code. 
 * 
 * @package     WellCommerce\Core\Template
 * @subpackage  WellCommerce\Core\Template\Extension
 * @author      Adam Piotrowski <adam@wellcommerce.org>
 * @copyright   Copyright (c) 2008-2014 WellCommerce sp. z o.o. (http://www.gekosale.com)
 */
namespace WellCommerce\Core\Template\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Box extends \Twig_Extension
{

    protected $container;

    public function __construct (ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions ()
    {
        return array(
            new \Twig_SimpleFunction('box', array(
                $this,
                'getBoxContents'
            ))
        );
    }

    public function getBoxContents ($name, $parameters = array())
    {
        return $this->container->get('box.resolver')->getBoxContents($name, $parameters);
    }

    public function getName ()
    {
        return 'box';
    }
}

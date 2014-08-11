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
namespace WellCommerce\Bundle\CoreBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Bundle\CoreBundle\Helper\XajaxManager;

/**
 * Class XajaxExtension
 *
 * Provides method needed to render xajax javascripts
 *
 * @package WellCommerce\Core\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class XajaxExtension extends \Twig_Extension
{
    /**
     * @var \WellCommerce\Bundle\CoreBundle\Helper\XajaxManager
     */
    protected $manager;

    /**
     * Constructor
     *
     * @param XajaxManager $manager
     */
    public function __construct(XajaxManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Returns array containing all functions used by this extension
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('xajax_javascript', [$this, 'getXajaxJavascript'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Returns Xajax javascript
     *
     * @return mixed
     */
    public function getXajaxJavascript()
    {
        return $this->manager->getJavascript();
    }

    /**
     * Returns unique extensions name
     *
     * @return string
     */
    public function getName()
    {
        return 'xajax';
    }
}

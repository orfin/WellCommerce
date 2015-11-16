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

namespace WellCommerce\Bundle\CoreBundle\Helper\Templating;

use Symfony\Component\Templating\EngineInterface;

/**
 * Class TemplatingHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TemplatingHelper implements TemplatingHelperInterface
{
    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * Constructor
     *
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * {@inheritdoc}
     */
    public function render($view, array $parameters = [])
    {
        return $this->engine->render($view, $parameters);
    }
}

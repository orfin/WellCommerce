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

namespace WellCommerce\Bundle\CoreBundle\Event\Code;

/**
 * Class AbstractTemplateEventCode
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractTemplateCode implements TwigTemplateCodeInterface
{
    /**
     * @var array
     */
    private $parameters;
    
    /**
     * @var int
     */
    protected $priority;
    
    /**
     * AbstractTemplateCode constructor.
     *
     * @param array $parameters
     * @param int   $priority
     */
    public function __construct(array $parameters = [], int $priority = 0)
    {
        $this->parameters = $parameters;
        $this->priority   = $priority;
    }
    
    /**
     * @inheritdoc
     */
    public function getPriority() : int
    {
        return $this->priority;
    }
    
    /**
     * @inheritdoc
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }
    
    public function getParameters() : array
    {
        return $this->parameters;
    }
    
    public function setParameters(array $parameters = [])
    {
        $this->parameters = $parameters;
    }
}

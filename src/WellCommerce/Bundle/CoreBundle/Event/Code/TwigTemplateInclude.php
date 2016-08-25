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
 * Class TwigTemplateInclude
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class TwigTemplateInclude extends AbstractTemplateCode
{
    /**
     * @var int
     */
    private $template;
    
    /**
     * TwigTemplateEventString constructor.
     *
     * @param string $template
     * @param array  $parameters
     * @param int    $priority
     */
    public function __construct(string $template, array $parameters = [], int $priority = 0)
    {
        parent::__construct($parameters, $priority);
        $this->template = $template;
    }
    
    public function getTemplate() : string
    {
        return $this->template;
    }
    
    public function setTemplate(string $template)
    {
        $this->template = $template;
    }
    
    
}

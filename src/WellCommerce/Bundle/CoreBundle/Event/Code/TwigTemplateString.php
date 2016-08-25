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
 * Class TwigTemplateString
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class TwigTemplateString extends AbstractTemplateCode
{
    /**
     * @var int
     */
    private $templateString;
    
    /**
     * TwigTemplateEventString constructor.
     *
     * @param string $templateString
     * @param array  $parameters
     * @param int    $priority
     */
    public function __construct(string $templateString, array $parameters = [], int $priority = 0)
    {
        parent::__construct($parameters, $priority);
        $this->templateString = $templateString;
    }
    
    public function getTemplateString() : string
    {
        return $this->templateString;
    }
    
    public function setTemplateString(string $templateString)
    {
        $this->templateString = $templateString;
    }
}

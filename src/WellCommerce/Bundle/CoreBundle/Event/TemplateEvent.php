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

namespace WellCommerce\Bundle\CoreBundle\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Bundle\CoreBundle\Event\Code\TwigTemplateCodeInterface;

/**
 * Class TemplateEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TemplateEvent extends Event
{
    private $codes;
    
    public function __construct()
    {
        $this->codes = new ArrayCollection();
    }
    
    public function addCode(TwigTemplateCodeInterface $code)
    {
        $this->codes->add($code);
    }
    
    public function getCodes() : Collection
    {
        return $this->codes->matching(Criteria::create()->orderBy([
            'priority' => Criteria::ASC
        ]));
    }
}

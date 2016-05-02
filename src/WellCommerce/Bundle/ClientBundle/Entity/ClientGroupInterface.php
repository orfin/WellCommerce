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

namespace WellCommerce\Bundle\ClientBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\PageBundle\Entity\PageInterface;

/**
 * Interface ClientGroupInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientGroupInterface extends EntityInterface, TranslatableInterface, TimestampableInterface, BlameableInterface
{
    public function getDiscount() : float;
    
    public function setDiscount(float $discount);
    
    public function setClients(Collection $clients);
    
    public function getClients() : Collection;
    
    public function addClient(ClientInterface $client);
    
    public function getPages() : Collection;
    
    public function setPages(Collection $pages);
    
    public function addPage(PageInterface $page);
}

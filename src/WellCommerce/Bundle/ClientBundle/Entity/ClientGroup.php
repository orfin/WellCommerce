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
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\PageBundle\Entity\PageInterface;

/**
 * Class ClientGroup
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroup extends AbstractEntity implements ClientGroupInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;
    
    /**
     * @var float
     */
    protected $discount;
    
    /**
     * @var Collection
     */
    protected $clients;
    
    /**
     * @var Collection
     */
    protected $pages;
    
    public function getDiscount() : float
    {
        return $this->discount;
    }
    
    public function setDiscount(float $discount)
    {
        $this->discount = $discount;
    }
    
    public function setClients(Collection $clients)
    {
        $this->clients = $clients;
    }
    
    public function getClients() : Collection
    {
        return $this->clients;
    }
    
    public function addClient(ClientInterface $client)
    {
        $this->clients->add($client);
    }
    
    public function getPages() : Collection
    {
        return $this->pages;
    }
    
    public function setPages(Collection $pages)
    {
        $this->pages = $pages;
    }
    
    public function addPage(PageInterface $page)
    {
        $this->pages->add($page);
    }
}


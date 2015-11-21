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
namespace WellCommerce\ClientBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\CmsBundle\Entity\PageInterface;

/**
 * Class ClientGroup
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroup implements ClientGroupInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;

    /**
     * @var int
     */
    protected $id;

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

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * {@inheritdoc}
     */
    public function setDiscount($discount)
    {
        $this->discount = (float)$discount;
    }

    /**
     * {@inheritdoc}
     */
    public function setClients(Collection $clients)
    {
        $this->clients = $clients;
    }

    /**
     * {@inheritdoc}
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * {@inheritdoc}
     */
    public function addClient(ClientInterface $client)
    {
        $this->clients[] = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * {@inheritdoc}
     */
    public function setPages(Collection $pages)
    {
        $this->pages = $pages;
    }

    /**
     * {@inheritdoc}
     */
    public function addPage(PageInterface $page)
    {
        $this->pages[] = $page;
    }
}


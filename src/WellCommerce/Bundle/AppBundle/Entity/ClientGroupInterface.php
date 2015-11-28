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

namespace WellCommerce\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\PageInterface;
use WellCommerce\Bundle\AppBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\AppBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\AppBundle\Entity\TranslatableInterface;

/**
 * Interface ClientGroupInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientGroupInterface extends TranslatableInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return float
     */
    public function getDiscount();

    /**
     * @param float $discount
     */
    public function setDiscount($discount);

    /**
     * @param Collection $clients
     */
    public function setClients(Collection $clients);

    /**
     * @return Collection
     */
    public function getClients();

    /**
     * @param ClientInterface $client
     */
    public function addClient(ClientInterface $client);

    /**
     * @return Collection
     */
    public function getPages();

    /**
     * @param Collection $pages
     */
    public function setPages(Collection $pages);

    /**
     * @param PageInterface $page
     */
    public function addPage(PageInterface $page);
}

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

namespace WellCommerce\Bundle\ClientBundle\Factory;

use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetails;
use WellCommerce\Bundle\ClientBundle\Entity\ClientDetails;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class ClientFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ClientInterface::class;

    /**
     * @return ClientInterface
     */
    public function create()
    {
        $clientDetails = new ClientDetails();
        $clientDetails->setConditionsAccepted(false);
        $clientDetails->setDiscount(0);
        $clientDetails->setNewsletterAccepted(false);
        $clientDetails->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

        /** @var $client ClientInterface */
        $client = $this->init();
        $client->setContactDetails(new ClientContactDetails());
        $client->setClientDetails($clientDetails);

        return $client;
    }
}

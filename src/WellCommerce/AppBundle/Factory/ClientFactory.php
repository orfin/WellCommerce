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

namespace WellCommerce\AppBundle\Factory;

use WellCommerce\AppBundle\Entity\Client;
use WellCommerce\AppBundle\Entity\ClientContactDetails;
use WellCommerce\CoreBundle\Factory\AbstractFactory;

/**
 * Class ClientFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\AppBundle\Entity\ClientInterface
     */
    public function create()
    {
        $client = new Client();
        $client->setContactDetails(new ClientContactDetails());
        $client->setConditionsAccepted(true);
        $client->setDiscount(0);
        $client->setNewsletterAccepted(true);
        $client->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

        return $client;
    }
}

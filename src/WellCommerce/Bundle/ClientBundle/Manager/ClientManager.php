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

namespace WellCommerce\Bundle\ClientBundle\Manager;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\ClientBundle\Exception\ResetPasswordException;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;

/**
 * Class ClientManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientManager extends AbstractManager
{
    public function getClientByUsername(string $username) : ClientInterface
    {
        $client = $this->getRepository()->findOneBy(['clientDetails.username' => $username]);
        
        if (!$client instanceof ClientInterface) {
            throw new ResetPasswordException(sprintf('client.flash.reset_password.email_not_found', $username));
        }
        
        return $client;
    }
    
    public function resetPassword(ClientInterface $client)
    {
        $hash = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36) . $client->getId();
        $client->getClientDetails()->setResetPasswordHash($hash);
        $client->getClientDetails()->setHashedPassword(Helper::generateRandomPassword(8));
        $this->updateResource($client);
    }
}

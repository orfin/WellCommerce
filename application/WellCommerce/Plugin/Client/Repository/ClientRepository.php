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
namespace WellCommerce\Plugin\Client\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Helper\Password;
use WellCommerce\Plugin\Client\Model\Client;
use WellCommerce\Plugin\Client\Model\ClientDataInterface;
use WellCommerce\Plugin\Client\Model\ClientTranslation;

/**
 * Class ClientRepository
 *
 * @package WellCommerce\Plugin\Client\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientRepository extends AbstractRepository implements ClientRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Client::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Client::findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $this->dispatchEvent(ClientRepositoryInterface::PRE_DELETE_EVENT, [], $id);

        $this->transaction(function () use ($id) {
            return Client::destroy($id);
        });

        $this->dispatchEvent(ClientRepositoryInterface::POST_DELETE_EVENT, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(ClientRepositoryInterface::PRE_SAVE_EVENT, $data, $id);

        $this->transaction(function () use ($data, $id) {
            $client = Client::firstOrNew([
                'id' => $id
            ]);

            $client->first_name = $data['required_data']['first_name'];
            $client->last_name  = $data['required_data']['last_name'];
            $client->email      = $data['required_data']['email'];
            $client->password   = $data['required_data']['password'];
            $client->active     = $data['required_data']['active'];
            $client->global     = $data['required_data']['global'];
            $client->save();
        });

        $this->dispatchEvent(ClientRepositoryInterface::POST_SAVE_EVENT, $data, $id);
    }

    /**
     * Authorizes the client
     *
     * @param array $data Login form data
     */
    public function authProcess(array $data)
    {
        $client = Client::where('email', '=', $data['email'])->first();

        if ($client) {
            $checkPassword = Password::match($data['password'], $client->password);
            if ($checkPassword) {

                $this->getSession()->set('admin/client/id', $client->id);
                $this->getSession()->set('admin/client/first_name', $client->first_name);
                $this->getSession()->set('admin/client/last_name', $client->last_name);
                $this->getSession()->set('admin/client/global', $client->global);

                $this->dispatchEvent(ClientRepositoryInterface::LOGIN_SUCCEED, $client, $data);
            }
        }
    }
}

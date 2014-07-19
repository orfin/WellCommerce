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
namespace WellCommerce\User\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Helper\Password;
use WellCommerce\User\Model\User;
use WellCommerce\User\Model\UserDataInterface;
use WellCommerce\User\Model\UserTranslation;

/**
 * Class UserRepository
 *
 * @package WellCommerce\User\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return User::all();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return User::findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $this->dispatchEvent(UserRepositoryInterface::PRE_DELETE_EVENT, [], $id);

        $this->transaction(function () use ($id) {
            return User::destroy($id);
        });

        $this->dispatchEvent(UserRepositoryInterface::POST_DELETE_EVENT, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(UserRepositoryInterface::PRE_SAVE_EVENT, $data, $id);

        $this->transaction(function () use ($data, $id) {
            $user = User::firstOrNew([
                'id' => $id
            ]);

            $user->first_name = $data['required_data']['first_name'];
            $user->last_name  = $data['required_data']['last_name'];
            $user->email      = $data['required_data']['email'];
            $user->password   = $data['required_data']['password'];
            $user->active     = $data['required_data']['active'];
            $user->global     = $data['required_data']['global'];
            $user->save();
        });

        $this->dispatchEvent(UserRepositoryInterface::POST_SAVE_EVENT, $data, $id);
    }

    /**
     * Authorizes the user
     *
     * @param array $data Login form data
     */
    public function authProcess(array $data)
    {
        $user = User::where('email', '=', $data['email'])->first();

        if ($user) {
            $checkPassword = Password::match($data['password'], $user->password);
            if ($checkPassword) {

                $this->getSession()->set('admin/user/id', $user->id);
                $this->getSession()->set('admin/user/first_name', $user->first_name);
                $this->getSession()->set('admin/user/last_name', $user->last_name);
                $this->getSession()->set('admin/user/global', $user->global);

                $this->dispatchEvent(UserRepositoryInterface::LOGIN_SUCCEED, $user, $data);
            }
        }
    }
}

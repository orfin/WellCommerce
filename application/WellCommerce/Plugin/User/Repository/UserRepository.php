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
namespace WellCommerce\Plugin\User\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Core\Helper\Password;
use WellCommerce\Plugin\User\Model\User;
use WellCommerce\Plugin\User\Model\UserTranslation;

/**
 * Class UserAbstractRepository
 *
 * @package WellCommerce\Plugin\User\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return User::get();
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
        $this->dispatchEvent(UserRepositoryEvents::PRE_DELETE, [], $id);

        $this->transaction(function () use ($id) {
            return User::destroy($id);
        });

        $this->dispatchEvent(UserRepositoryEvents::POST_DELETE, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(UserRepositoryEvents::PRE_SAVE, $data, $id);

        $this->transaction(function () use ($data, $id) {
            $user = User::firstOrNew([
                'id' => $id
            ]);

            $user->first_name = $data['required_data']['first_name'];
            $user->last_name  = $data['required_data']['last_name'];
            $user->email      = $data['required_data']['email'];
            $user->password   = Password::hash($data['required_data']['password']);
            $user->active     = $data['required_data']['active'];
            $user->global     = $data['required_data']['global'];
            $user->save();
        });

        $this->dispatchEvent(UserRepositoryEvents::POST_SAVE, $data, $id);
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

                $this->getSession()->set('user/id', $user->id);
                $this->getSession()->set('user/first_name', $user->first_name);
                $this->getSession()->set('user/last_name', $user->last_name);
                $this->getSession()->set('user/global', $user->global);

                $this->dispatchEvent(UserRepositoryEvents::LOGIN_SUCCEED, $data, $user->id);
            }
        }
    }
}

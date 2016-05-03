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

namespace WellCommerce\Bundle\ClientBundle\Repository;

use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

/**
 * Class ClientGroupRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientRepository extends EntityRepository implements ClientRepositoryInterface, UserProviderInterface, UserLoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('client.id');
        $queryBuilder->leftJoin('client.clientGroup', 'client_group');
        $queryBuilder->leftJoin('client_group.translations', 'client_group_translation');

        return $queryBuilder;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }

    public function loadUserByUsername($username)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.clientDetails.username = :username')
            ->setParameter('username', $username)
            ->getQuery();

        try {
            $user = $queryBuilder->getSingleResult();
        } catch (NoResultException $e) {
            $msg = sprintf(
                'Unable to find an active client identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($msg);
        }

        return $user;
    }
}

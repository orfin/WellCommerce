<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WellCommerce\Profiler\Storage;

use Symfony\Component\HttpKernel\Profiler\Profile;
use Symfony\Component\HttpKernel\Profiler\ProfilerStorageInterface;
use WellCommerce\Profiler\Repository\ProfilerRepositoryInterface;

/**
 * Class ProfilerStorage
 *
 * @package WellCommerce\Profiler\Storage
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProfilerStorage implements ProfilerStorageInterface
{
    /**
     * Constructor
     *
     * @param ProfilerRepositoryInterface $repository
     */
    public function __construct(ProfilerRepositoryInterface $repository)
    {
        $this->repository = $repository;

    }

    /**
     * {@inheritdoc}
     */
    public function find($ip, $url, $limit, $method, $start = null, $end = null)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function read($token)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function write(Profile $profile)
    {
        $this->repository->save($profile);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function purge()
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function initDb()
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function cleanup()
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function exec($db, $query, array $args = array())
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function prepareStatement($db, $query)
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function fetch($db, $query, array $args = array())
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function close($db)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function createProfileFromData($token, $data, $parent = null)
    {
        $profile = new Profile($token);
        $profile->setIp($data['ip']);
        $profile->setMethod($data['method']);
        $profile->setUrl($data['url']);
        $profile->setTime($data['time']);
        $profile->setCollectors(unserialize(base64_decode($data['data'])));

        if (!$parent && !empty($data['parent'])) {
            $parent = $this->read($data['parent']);
        }

        if ($parent) {
            $profile->setParent($parent);
        }

        $profile->setChildren($this->readChildren($token, $profile));

        return $profile;
    }

    /**
     * {@inheritdoc}
     */
    protected function readChildren($token, $parent)
    {

    }

    /**
     * {@inheritdoc}
     */
    protected function has($token)
    {
        $tokenData = $this->repository->findByToken($token);

        return !$tokenData->isEmpty();
    }
}

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
        if (null === $start) {
            $start = 0;
        }

        if (null === $end) {
            $end = time();
        }

        list($criteria, $args) = $this->buildCriteria($ip, $url, $start, $end, $limit, $method);

        $criteria = $criteria ? 'WHERE ' . implode(' AND ', $criteria) : '';

        $db = $this->initDb();
        $tokens
            = $this->fetch($db, 'SELECT token, ip, method, url, time, parent FROM sf_profiler_data ' . $criteria . ' ORDER BY time DESC LIMIT ' . ((int)$limit), $args);
        $this->close($db);

        return $tokens;
    }

    /**
     * {@inheritdoc}
     */
    public function read($token)
    {
        $db   = $this->initDb();
        $args = array(':token' => $token);
        $data
              = $this->fetch($db, 'SELECT data, parent, ip, method, url, time FROM sf_profiler_data WHERE token = :token LIMIT 1', $args);
        $this->close($db);
        if (isset($data[0]['data'])) {
            return $this->createProfileFromData($token, $data[0]);
        }
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
        $db = $this->initDb();
        $this->exec($db, 'DELETE FROM sf_profiler_data');
        $this->close($db);
    }

    protected function initDb()
    {

    }

    protected function cleanup()
    {

    }

    protected function exec($db, $query, array $args = array())
    {

    }

    protected function prepareStatement($db, $query)
    {

    }

    protected function fetch($db, $query, array $args = array())
    {

    }

    protected function close($db)
    {
    }

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

    protected function readChildren($token, $parent)
    {
        $db = $this->initDb();
        $data
            = $this->fetch($db, 'SELECT token, data, ip, method, url, time FROM sf_profiler_data WHERE parent = :token', array(':token' => $token));
        $this->close($db);

        if (!$data) {
            return array();
        }

        $profiles = array();
        foreach ($data as $d) {
            $profiles[] = $this->createProfileFromData($d['token'], $d, $parent);
        }

        return $profiles;
    }

    /**
     * Returns whether data for the given token already exists in storage.
     *
     * @param string $token The profile token
     *
     * @return string
     */
    protected function has($token)
    {
        $tokenData = $this->repository->findByToken($token);

        return !$tokenData->isEmpty();
    }
}

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
namespace WellCommerce\Profiler\Repository;

use Symfony\Component\HttpKernel\Profiler\Profile;
use WellCommerce\Core\Repository\AbstractRepository;
use WellCommerce\Profiler\Model\Profiler;
use WellCommerce\Profiler\Model\ProfilerTranslation;

/**
 * Class ProfilerAbstractRepository
 *
 * @package WellCommerce\Profiler\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProfilerRepository extends AbstractRepository implements ProfilerRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
    }

    /**
     * @param $token
     *
     * @return \WellCommerce\Core\Model\Collection\CustomCollection
     */
    public function findByToken($token)
    {
        return Profiler::where('token', '=', $token)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function save(Profile $profile)
    {
        $profilerData = Profiler::firstOrNew([
            'token' => $profile->getToken()
        ]);

        $profilerData->parent = $profile->getParentToken();
        $profilerData->data   = base64_encode(serialize($profile->getCollectors()));
        $profilerData->method = $profile->getMethod();
        $profilerData->url    = $profile->getUrl();
        $profilerData->time   = $profile->getTime();

        $profilerData->save();
    }
}
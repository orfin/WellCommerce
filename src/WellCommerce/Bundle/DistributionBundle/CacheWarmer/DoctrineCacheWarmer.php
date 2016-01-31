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

namespace WellCommerce\Bundle\DistributionBundle\CacheWarmer;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\DistributionBundle\Console\Action\ExtendDoctrineAction;
use WellCommerce\Bundle\DistributionBundle\Console\Action\UpdateSchemaAction;
use WellCommerce\Bundle\DistributionBundle\Console\ConsoleActionExecutorInterface;

/**
 * Class DoctrineCacheWarmer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DoctrineCacheWarmer implements CacheWarmerInterface
{
    /**
     * @var ConsoleActionExecutorInterface
     */
    protected $consoleActionExecutor;

    /**
     * ExtendedEntityCacheWarmer constructor.
     *
     * @param ConsoleActionExecutorInterface $consoleActionExecutor
     */
    public function __construct(ConsoleActionExecutorInterface $consoleActionExecutor)
    {
        $this->consoleActionExecutor = $consoleActionExecutor;
    }

    public function warmUp($cacheDir)
    {
        return $this->consoleActionExecutor->execute([
//            new UpdateSchemaAction()
        ]);
    }

    public function isOptional()
    {
        return false;
    }
}

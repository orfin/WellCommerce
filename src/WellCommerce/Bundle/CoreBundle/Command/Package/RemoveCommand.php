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

namespace WellCommerce\Bundle\CoreBundle\Command\Package;

use WellCommerce\Bundle\CoreBundle\Helper\Package\PackageHelperInterface;

/**
 * Class RemoveCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RemoveCommand extends AbstractPackageCommand
{
    /**
     * @var string
     */
    protected $composerOperation = PackageHelperInterface::ACTION_REMOVE;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();
        $this->setDescription('Remove WellCommerce package');
        $this->setName('wellcommerce:package:remove');
    }
}


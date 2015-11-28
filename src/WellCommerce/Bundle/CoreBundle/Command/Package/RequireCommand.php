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

use Symfony\Component\Console\Input\InputInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Package\PackageHelperInterface;

/**
 * Class RequireCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RequireCommand extends AbstractPackageCommand
{
    /**
     * @var string
     */
    protected $composerOperation = PackageHelperInterface::ACTION_REQUIRE;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();
        $this->setDescription('Install WellCommerce package');
        $this->setName('wellcommerce:package:require');
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandArguments(InputInterface $input)
    {
        $package = $this->getPackageInformation($input->getOption('package'));
        $version = PackageHelperInterface::DEFAULT_BRANCH_VERSION;

        return [
            $this->getComposer(),
            $this->composerOperation,
            sprintf('%s:%s', $package, $version),
        ];
    }
}


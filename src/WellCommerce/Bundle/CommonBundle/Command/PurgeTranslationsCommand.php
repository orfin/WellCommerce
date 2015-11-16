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

namespace WellCommerce\Bundle\CommonBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PurgeTranslationsCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PurgeTranslationsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setDescription('Purges all translations');
        $this->setName('wellcommerce:purge:translations');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Purging translations. Please wait for process to finish.', true);
        $result = $this->getContainer()->get('dictionary.purger')->purge();

        if (true === $result) {
            $output->write('All translations were purged.', true);
        } else {
            $output->write('Something went wrong. Translations were not purged.', true);
        }
    }
}

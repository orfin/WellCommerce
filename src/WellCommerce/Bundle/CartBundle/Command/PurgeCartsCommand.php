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

namespace WellCommerce\Bundle\CartBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PurgeCartsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setDescription('Purges all carts');
        $this->setName('wellcommerce:purge:carts');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Purging carts. Please wait for process to finish.', true);
        $result = $this->getContainer()->get('cart.purger')->purge();

        if (true === $result) {
            $output->write('All carts were purged.', true);
        } else {
            $output->write('Something went wrong. Carts were not purged.', true);
        }
    }
}
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

namespace WellCommerce\Bundle\DistributionBundle\Composer;

use Composer\Script\Event;

/**
 * Class HerokuEnvironment
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class HerokuEnvironment
{
    /**
     * Populate Heroku environment
     *
     * @param Event $event Event
     */
    public static function populateEnvironment(Event $event)
    {
        $url = getenv('CLEARDB_DATABASE_URL');

        if ($url) {
            $url = parse_url($url);
            putenv("SYMFONY_DATABASE_HOST={$url['host']}");
            putenv("SYMFONY_DATABASE_USER={$url['user']}");
            putenv("SYMFONY_DATABASE_PASSWORD={$url['pass']}");

            $db = substr($url['path'], 1);
            putenv("SYMFONY_DATABASE_NAME={$db}");
            putenv("SYMFONY_PROD_LOG_PATH=php://stderr");

            $io = $event->getIO();
            $io->write('CLEARDB_DATABASE_URL=' . getenv('CLEARDB_DATABASE_URL'));
            $io->write('SYMFONY_PROD_LOG_PATH=' . getenv('SYMFONY_PROD_LOG_PATH'));
        }
    }
}

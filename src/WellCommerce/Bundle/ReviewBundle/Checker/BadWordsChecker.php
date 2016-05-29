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

namespace WellCommerce\Bundle\ReviewBundle\Checker;

use Expalmer\PhpBadWords\PhpBadWords;

/**
 * Class BadWordsChecker
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BadWordsChecker
{
    public function isBadWord(string $phrase) : bool
    {
        $badWords = new PhpBadWords();
        $badWords->setDictionaryFromFile(__DIR__ . '/dictionary.php');
        $badWords->setText($phrase);
        
        return $badWords->check();
    }
}

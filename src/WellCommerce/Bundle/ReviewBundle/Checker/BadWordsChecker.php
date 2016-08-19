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
use ReflectionClass;

/**
 * Class BadWordsChecker
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BadWordsChecker
{
    public function isBadWord(string $phrase) : bool
    {
        $reflection = new ReflectionClass($this);
        $directory  = dirname($reflection->getFileName());
        $badWords   = new PhpBadWords();
        $badWords->setDictionaryFromFile($directory . '/dictionary.php');
        $badWords->setText($phrase);
        
        return $badWords->check();
    }
}

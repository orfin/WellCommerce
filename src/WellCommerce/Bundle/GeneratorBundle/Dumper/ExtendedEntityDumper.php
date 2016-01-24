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

namespace WellCommerce\Bundle\GeneratorBundle\Dumper;

use Wingu\OctopusCore\CodeGenerator\PHP\Annotation\Tags\BaseTag;
use Wingu\OctopusCore\CodeGenerator\PHP\DocCommentGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\ClassGenerator;

/**
 * Class ExtendedEntityDumper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ExtendedEntityDumper implements EntityDumperInterface
{
    /**
     * {@inheritdoc}
     */
    public function dump($targetPath, ClassGenerator $generator)
    {
        $content  = $this->prepareClassContent($generator);
        $fileName = $generator->getName() . '.php';

        return file_put_contents($targetPath . DIRECTORY_SEPARATOR . $fileName, $content, LOCK_EX);
    }

    /**
     * Prepares the extended entity class content
     *
     * @param ClassGenerator $generator
     *
     * @return string
     */
    protected function prepareClassContent(ClassGenerator $generator)
    {
        $content
            = <<<EOT
<?php

# WellCommerce Open-Source E-Commerce Platform
#
# This file is part of the WellCommerce package.
# (c) Adam Piotrowski <adam@wellcommerce.org>
#
# For the full copyright and license information,
# please view the LICENSE file that was distributed with this source code.

EOT;

        $annotation = new BaseTag('author', 'Adam Piotrowski <adam@wellcommerce.org>');
        $classDoc   = new DocCommentGenerator('Class ' . $generator->getName(), "The file was auto-generated.", [$annotation]);
        $generator->setDocumentation($classDoc);

        $content .= PHP_EOL . $generator->generate();

        return $content;
    }
}

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
namespace WellCommerce\Core\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use WellCommerce\Core\AbstractComponent;

/**
 * Class Uploader
 *
 * @package WellCommerce\Core
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Uploader extends AbstractComponent
{
    protected $originalPath;

    protected $rootpath;

    /**
     * Returns files as array from FileBag
     *
     * @param FileBag $bag
     *
     * @return array
     */
    public function getFiles(FileBag $bag)
    {
        $files         = [];
        $fileBag       = $bag->all();
        $arrayIterator = new RecursiveArrayIterator($fileBag);
        $fileIterator  = new RecursiveIteratorIterator($arrayIterator, RecursiveIteratorIterator::SELF_FIRST);

        foreach ($fileIterator as $file) {
            if (is_array($file)) {
                continue;
            }

            $files[] = $file;
        }

        return $files;
    }

    public function setPaths($paths)
    {
        $this->rootpath     = $this->container->getParameter('application.root_path');
        $this->originalPath = sprintf('%s/%s', $this->rootpath, $paths['original']);
    }

    public function upload(UploadedFile $file, $name)
    {
        $file->move($this->originalPath, $name);
    }
}
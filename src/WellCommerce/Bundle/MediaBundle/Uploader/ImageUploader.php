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

namespace WellCommerce\Bundle\MediaBundle\Uploader;

/**
 * Class ImageUploader
 *
 * @package WellCommerce\Bundle\MediaBundle\Uploader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ImageUploader implements UploaderInterface
{
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

    public function supports()
    {
        return [
            'jpg',
            'gif',
            'png',
            'jpeg'
        ];
    }

    public function upload(UploadedFile $file, $name)
    {
        $file->move($this->originalPath, $name);
    }

} 
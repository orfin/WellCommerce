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

namespace WellCommerce\CmsBundle\Uploader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface MediaUploaderInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface MediaUploaderInterface
{
    /**
     * Uploads the file
     *
     * @param UploadedFile $file
     * @param              $dir
     *
     * @return mixed
     */
    public function upload(UploadedFile $file, $dir);

    /**
     * Removes the file from filesystem
     *
     * @param File $file
     *
     * @return mixed
     */
    public function delete(File $file);
}

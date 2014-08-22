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

namespace WellCommerce\Bundle\CoreBundle\Uploader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface FileUploaderInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Uploader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FileUploaderInterface
{
    /**
     * Uploads the file
     *
     * @param UploadedFile $file
     *
     * @return \WellCommerce\Bundle\MediaBundle\Entity\Media
     */
    public function upload(UploadedFile $file);

    /**
     * Removes the file from filesystem
     *
     * @param File $file
     *
     * @return mixed
     */
    public function delete(File $file);
} 
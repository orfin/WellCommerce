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
namespace WellCommerce\Plugin\File\Repository;

use WellCommerce\Core\Image;
use WellCommerce\Core\Repository;
use WellCommerce\Core\Model\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileRepository
 *
 * @package WellCommerce\Plugin\File\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileRepository extends Repository
{
    /**
     * Returns all files
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return File::all();
    }

    /**
     * Returns single file by ID
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return File::findOrFail($id);
    }

    /**
     * Stores uploaded file data
     *
     * @param UploadedFile $file
     */
    public function save(UploadedFile $uploadedFile)
    {
        $file            = new File();
        $file->name      = $uploadedFile->getClientOriginalName();
        $file->size      = $uploadedFile->getClientSize();
        $file->extension = $uploadedFile->getClientOriginalExtension();
        $file->type      = $uploadedFile->getClientMimeType();
        $file->save();

        return $file;
    }
}
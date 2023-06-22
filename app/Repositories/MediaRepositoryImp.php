<?php

namespace App\Repositories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

interface MediaRepositoryImp extends BaseRepositoryImp
{
    /**
     * @return bool|null
     */
    public function forceDelete(int $id);

    /**
     * @param \App\Models\Node $product
     * @return null|int
     */
    public function getMaxOrderOfProductMedia(\App\Models\Node $product);

    /**
     * @param \App\Models\Node $product
     * @param integer $prev_order
     * @param integer $new_order
     * @return void
     */
    public function changeOrderOfProductMedia(\App\Models\Node $product, int $prev_order, int $new_order);

    /**
     * @param string $path
     * @param string $fileName
     * @param string $isInStorage
     */
    public function removeFromPath(string $path, string $fileName = null, $isInStorage = false);

    /**
     * @param Model $model
     * @return string
     */
    public function generateUploadMediaPath(Model $model): string;

    /**
     * @param Model $model
     * @param Media $media
     * @param array $extraData
     */
    public function assignMediaToModel(Model $model, Media $media, array $extraData = []);

    /**
     * @param UploadedFile $uploadedFile
     * @param string $path
     * @param bool $mustUploadToStorage
     * @return boolean|array
     */
    public function uploadMedia(UploadedFile $uploadedFile, string $path, $mustUploadToStorage = false);
}

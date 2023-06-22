<?php

namespace App\Repositories;


use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class MediaRepository extends BaseRepository implements MediaRepositoryImp
{
    /**
     * MediaRepository constructor.
     * @param Media $model
     */
    public function __construct(Media $model)
    {
        parent::__construct($model);
    }

    /**
     * @return bool|null
     */
    public function forceDelete(int $id)
    {
        $this->model->where('id', $id)->first()->forceDelete();
    }

    /**
     * @param \App\Models\Node $product
     * @return null|int
     */
    public function getMaxOrderOfProductMedia(\App\Models\Node $product)
    {
        /** @var int|null $maxOrder */
        return empty($product->medias()->pluck('order')->toArray()) ? null : max($product->medias()->pluck('order')->toArray());
    }

    /**
     * @param \App\Models\Node $product
     * @param integer $prev_order
     * @param integer $new_order
     * @return void
     */
    public function changeOrderOfProductMedia(\App\Models\Node $product, int $prev_order, int $new_order)
    {
        $mustBeChangeFromPrevToNew = $product->medias()->wherePivot('order', $prev_order)->first();
        $mustBeChange = $product->medias()->wherePivot('order', $new_order)->first();
        if ($mustBeChangeFromPrevToNew and $mustBeChange) {
            $product->medias()->updateExistingPivot($mustBeChangeFromPrevToNew->id, ['order' => $new_order]);
            $product->medias()->updateExistingPivot($mustBeChange->id, ['order' => $prev_order]);
        }
    }

    /**
     * @param string $path
     * @param string $fileName
     * @param string $isInStorage
     */
    public function removeFromPath(string $path, string $fileName = null, $isInStorage = false)
    {
        $path = trim($path, '/');
        $path = $path . DIRECTORY_SEPARATOR;
        if ($fileName) {
            $path  = $path . $fileName;
        } else {
            $path = $path . '*';
        }

        if (!$isInStorage) {
            if (file_exists(public_path($path))) {
                unlink($path);
            }
        } else {
            \Storage::disk('public')->delete($path);
        }
    }

    /**
     * @param Model $model
     * @return string
     */
    public function generateUploadMediaPath(Model $model): string
    {
        return
            'upload'
            . DIRECTORY_SEPARATOR
            . strtolower((new \ReflectionClass($model))->getShortName())
            . DIRECTORY_SEPARATOR
            . ($model->id ?? 0)
            . DIRECTORY_SEPARATOR;
    }

    /**
     * @param Model $model
     * @param Media $media
     * @param array $extraData
     */
    public function assignMediaToModel(Model $model, Media $media, array $extraData = [])
    {
        $model->medias()->attach($media->id, $extraData);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $path
     * @param bool $mustUploadToStorage
     * @return boolean|array
     */
    public function uploadMedia(UploadedFile $uploadedFile, string $path, $mustUploadToStorage = false)
    {
        /** @var string $fileType */
        $fileType = (new \App\Models\Media())->getTypeOfFile($uploadedFile);

        /** @var int $size unit is KB */
        $size = $uploadedFile->getSize();

        if ($mustUploadToStorage) {
            /** @var array|boolean $res */
            $res = fileUploadToStorage(
                $uploadedFile,
                $path
            );
            if ($res) {
                return [
                    'size' => $size,
                    'fileType'  => $fileType,
                    'fileName' => $res
                ];
            } else {
                return false;
            }
        } else {
            try {
                /** @var \Symfony\Component\HttpFoundation\File\File $res */
                $res = fileUploader(
                    $uploadedFile,
                    $path
                );
                return [
                    'size' => $size,
                    'fileType'  => $fileType,
                    'fileName' => $res->getFilename()
                ];
            } catch (\Exception $th) {
                return false;
            }
        }
    }
}

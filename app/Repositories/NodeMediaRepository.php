<?php

namespace App\Repositories;

use App\Models\Media;
use App\Models\Node;
use Illuminate\Http\UploadedFile;

class NodeMediaRepository extends MediaRepository implements NodeMediaRepositoryImp
{
    /**
     * MediaRepository constructor.
     * @param Media $model
     */

    /** @var NodeRepositoryImp $nodeRepo */
    private $nodeRepo;
    public function __construct(NodeRepositoryImp $nodeRepo)
    {
        parent::__construct((new \App\Models\Media()));
        $this->nodeRepo = $nodeRepo;
    }

    public function generateUploadMediaPath(\Illuminate\Database\Eloquent\Model $model): string
    {
        if ($model->is_product) {
            return $model->productMediaPath();
        } else {
            return parent::generateUploadMediaPath($model);
        }
    }

    /**
     * @param Node $node
     * @param UploadedFile $uploadedFile
     * @param Media $oldMedia
     * @param bool $isInStorage
     * @param array $extraData
     * @return bool
     */
    private function setNewMedia(
        Node $node,
        UploadedFile $uploadedFile,
        Media $oldMedia = null,
        $isInStorage = false,
        $extraData = []
    ): bool {
        $uploadMediaPath = $this->generateUploadMediaPath($node);
        $order = $oldMedia->pivot->order ?? $extraData['order'] ?? null;
        if ($oldMedia) {
            $this->removeFromPath($uploadMediaPath, $oldMedia->path, $isInStorage);
            $node->medias()->detach($oldMedia->id);
            $this->forceDelete($oldMedia->id);
        }

        /** @var bool|array $uploadResult */
        $uploadResult = $this->uploadMedia($uploadedFile, $uploadMediaPath, $isInStorage);
        if ($uploadResult) {
            $media = $this->create([
                'size' => $uploadResult['size'],
                'path' => $uploadResult['fileName']
            ]);

            $this->assignMediaToModel($node, $media, [
                'type' => $uploadResult['fileType'],
                'order' =>  $order
            ]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Node $node
     * @param UploadedFile $uploadedFile
     * @return boolean
     */
    public function setNewIconImage(Node $node, UploadedFile $uploadedFile): bool
    {
        /** @var null|\App\Models\Media $iconMedia */
        $iconMedia = $this->nodeRepo->getNodeIconMedia($node);

        return $this->setNewMedia($node, $uploadedFile, $iconMedia, false, ['order' => \App\Enums\MediaOrderType::ICON_MEDIA_ORDER]);
    }

    /**
     * @param Node $node
     * @param UploadedFile $uploadedFile
     * @return boolean
     */
    public function setNewIndexImage(Node $node, UploadedFile $uploadedFile): bool
    {
        /** @var null|\App\Models\Media $media */
        $media = $this->nodeRepo->getNodeIndexMedia($node);

        return $this->setNewMedia($node, $uploadedFile, $media, false, ['order' => \App\Enums\MediaOrderType::INDEX]);
    }

    /**
     * @param Node $node
     * @param UploadedFile $uploadedFile
     * @return boolean
     */
    public function setNewBackgroundImage(Node $node, UploadedFile $uploadedFile): bool
    {
        /** @var null|\App\Models\Media $media */
        $media = $this->nodeRepo->getNodeBackgroundMedia($node);

        return $this->setNewMedia($node, $uploadedFile, $media, false, ['order' => \App\Enums\MediaOrderType::BACKGROUND_MEDIA_ORDER]);
    }

    /**
     * @param Node $node
     * @param UploadedFile $uploadedFile
     * @return boolean
     */
    public function setNewProductFile(Node $node, UploadedFile $uploadedFile): bool
    {
        /** * @var null|\App\Models\Media $media */
        $media = $this->nodeRepo->getProductFile($node);
        return $this->setNewMedia($node, $uploadedFile, $media, true);
    }
}

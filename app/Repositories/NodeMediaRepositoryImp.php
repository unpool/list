<?php

namespace App\Repositories;

use App\Models\Node;
use Illuminate\Http\UploadedFile;

interface NodeMediaRepositoryImp extends MediaRepositoryImp
{
    /**
     * @param Node $node
     * @param UploadedFile $uploadedFile
     * @return boolean
     */
    public function setNewIconImage(Node $node, UploadedFile $uploadedFile): bool;

    /**
     * @param Node $node
     * @param UploadedFile $uploadedFile
     * @return boolean
     */
    public function setNewBackgroundImage(Node $node, UploadedFile $uploadedFile): bool;

    /**
     * @param Node $node
     * @param UploadedFile $uploadedFile
     * @return boolean
     */
    public function setNewIndexImage(Node $node, UploadedFile $uploadedFile): bool;

    /**
     * @param Node $node
     * @param UploadedFile $uploadedFile
     * @return boolean
     */
    public function setNewProductFile(Node $node, UploadedFile $uploadedFile): bool;
}

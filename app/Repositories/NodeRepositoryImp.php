<?php

namespace App\Repositories;


use App\Models\Media;
use App\Models\Node;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

interface NodeRepositoryImp extends BaseRepositoryImp
{
    /**
     * Get All Children's of Node
     * @param Node $node
     * @return Collection
     */
    public function getChildesOfNode(Node $node): Collection;


    /**
     * Get All Root Nodes
     * @return Collection
     */
    public function getRoots(): Collection;


    /**
     * All leaf nodes (nodes at the end of a branch)
     * @return Collection
     */
    public function getLeaves(): Collection;

    /**
     * create zero dept if parent_id equal null
     * @param array $new_node
     * @param Node $parent_node
     * @return Node
     */
    public function addChildNode(array $new_node, Node $parent_node = null): Node;


    //get all nodes and Children for tree View cache it if heavy
    /**
     * @param Node|null $node
     * @return Collection
     */
    public function getTreePath(Node $node = null): Collection;


    /**
     * Soft remove  node and all childe but also show alarm in view for it
     * @param Node $node
     * @return bool
     */
    public function removeNodeAndAllChildren(Node $node): bool;

    /**
     * @param Node $node
     * @param Node $new_parent
     * @return Node
     */
    public function moveNode(Node $node, Node $new_parent): Node;

    /**
     * @return Collection
     */
    public function getNodesWhichHaveMedia(): Collection;

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $sortType
     * @param  array $with
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): LengthAwarePaginator;

    /**
     * @return Collection
     */
    public function getFromRootToNode(Node $node): Collection;

    /** @return Collection */
    public function getFromRootToParent(Node $node): Collection;

    /**
     * @return integer
     */
    public function getCountOfProduct(): int;

    /**
     * @return Collection
     */
    public function getPackages(): Collection;

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $sortType
     * @param  array $with
     * @return LengthAwarePaginator
     */
    public function getPaginatedPackages(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): LengthAwarePaginator;

    /**
     * @param Node $node
     * @return Node
     */
    public function addPriceToAttributes(Node $node): Node;

    /**
     * @param Node $package
     * @return array
     */
    public function getProductsIdInPackage(Node $package): array;

    /**
     * @param Node $node
     * @param float|int $newPrice
     * @return void
     */
    public function updateCashPriceOfNode(Node $node, $newPrice);

    /**
     * @param Node $node
     * @param float|int $newPrice
     * @return void
     */
    public function updateCoinPriceOfNode(Node $node, $newPrice);

    /**
     * @param Node $node
     * @param [type] $newPrice
     * @return void
     */
    public function updateFlashPriceOfNode(Node $node, $newPrice);

    /**
     * @param Node $node
     * @param [type] $newPrice
     * @return void
     */
    public function updateDVDPriceOfNode(Node $node, $newPrice);

    /**
     * @param Node $node
     * @param array $prices
     * @return void
     */
    public function setPriceForNode(Node $node, array $prices);

    /**
     * @param Node $package
     * @param array $newProductsId
     * @return void
     */
    public function updateProductsOfPackage(Node $package, array $newProductsId);

    /**
     * @param int $node_id
     * @param int $user_id
     * @return bool
     */
    public function checkNodeBoughtUser(int $node_id, int $user_id): bool;


    /**
     * @param int $node_id
     * @return mixed
     */
    public function getNodeWithSeparateMedias(int $node_id);


    /**
     * count of used product in packages
     *
     * @param Node $product
     * @return integer
     */
    public function countOfUseProductInPackages(Node $product): int;

    /**
     * @param int $id
     * @return int
     */
    public function forceDelete(int $id);

    /**
     * @param Node $node
     * @param integer $order
     * @return void
     */
    public function getNodeMediaWithSpecificOrder(Node $node, int $order);

    /**
     * @param Node $node
     * @return null|Media
     */
    public function getNodeIndexMedia(Node $node);

    /**
     * @param Node $node
     * @return null|Media
     */
    public function getNodeIconMedia(Node $node);

    /**
     * @param Node $node
     * @return null|Media
     */
    public function getNodeBackgroundMedia(Node $node);

    /**
     * @param Node $product
     * @return null|\App\Models\Media
     */
    public function getProductFile(Node $product);

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $sortType
     * @param array|null $with
     * @return LengthAwarePaginator
     */
    public function getPaginatedPublishPackages(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): LengthAwarePaginator;


    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $sortType
     * @param array|null $with
     * @return LengthAwarePaginator
     */
    public function getPaginateRoots(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): LengthAwarePaginator;


    /**
     * @param  $node
     * @return bool
     */
    public function checkNodeIsFree($node): bool;
}

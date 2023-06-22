<?php

namespace App\Repositories;


use App\Enums\PriceType;
use App\Models\Node;
use App\Models\Orderable;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Log;

class NodeRepository extends BaseRepository implements NodeRepositoryImp
{

    private $user;
    private $orderable;

    /**
     * NodeRepository constructor.
     * @param Node $model
     * @param User $user
     */
    public function __construct(Node $model, User $user, Orderable $orderable)
    {
        parent::__construct($model);
        $this->user = $user;
        $this->orderable = $orderable;
    }

    /**
     * @param Node $node
     * @return Collection
     */
    public function getChildesOfNode(Node $node): Collection
    {
        return $node->children()->get();
    }

    /**
     * @return Collection
     */
    public function getRoots(): Collection
    {
        return $this->model->roots()->get();
    }

    /**
     * All leaf nodes (nodes at the end of a branch)
     * @return Collection
     */
    public function getLeaves(): Collection
    {
        return $this->model->allLeaves()->get();
    }


    /**
     * create zero dept if parent_id equal null
     * @param array $new_node
     * @param Node $parent_node
     * @return Node
     */
    public function addChildNode(array $new_node, Node $parent_node = null): Node
    {
        if ($parent_node) {
            return $parent_node->children()->create($new_node);
        } else {
            $node = $this->model->create($new_node);
            $node->makeRoot();
            return $node;
        }
    }

    /**
     * Soft remove  node and all childe but also show alarm in view for it
     * @param Node $node
     * @return bool
     */
    public function removeNodeAndAllChildren(Node $node): bool
    {
        try {
            $this->model->whereIn('id', $node->descendantsAndSelf()->get()->pluck('id')->toArray())->delete();
            return true;
        } catch (Exception $e) {
            Log::error('Error in Delete Nodes' . $e->getMessage() . ' at File ' . $e->getFile() . 'at Line ' . $e->getLine());
            return false;
        }
    }

    /**
     * @param Node|null $node
     * @return Collection
     */
    public function getTreePath(Node $node = null): Collection
    {
        return $this->model->get()->toHierarchy();
    }

    public function moveNode(Node $node, Node $new_parent): Node
    {
        return $node->makeChildOf($new_parent);
    }

    public function getNodesWhichHaveMedia(): Collection
    {
        return $this->model->has('medias')->get();
    }

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $sortType
     * @param  array $with
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): LengthAwarePaginator
    {
        return !is_null($with)
            ? $this->model
                ->products()
                ->orderBy($orderBy, $sortType)
                ->with($with)
                ->paginate($limit)
            : $this->model->products()
                ->orderBy($orderBy, $sortType)
                ->paginate($limit);
    }


    public function getFromRootToNode(Node $node): Collection
    {
        return $node->getAncestorsAndSelf();
    }

    public function getFromRootToParent(Node $node): Collection
    {
        return $node->getAncestors();
    }

    /**
     * @return integer
     */
    public function getCountOfProduct(): int
    {
        return $this->model->products()->count();
    }

    /**
     * @return Collection
     */
    public function getPackages(): Collection
    {
        return $this->model->whereHas('packageItems')->get();
    }

    /**
     * @param int $limit
     * @param string $orderBy
     * @param string $sortType
     * @param  array $with
     * @return LengthAwarePaginator
     */
    public function getPaginatedPackages(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): LengthAwarePaginator
    {
        return !is_null($with)
            ? $this->model
                ->packages()
                ->orderBy($orderBy, $sortType)
                ->with($with)
                ->paginate($limit)
            : $this->model
                ->packages()
                ->orderBy($orderBy, $sortType)
                ->paginate($limit);
    }

    /**
     * @param Node $node
     * @return Node
     */
    public function addPriceToAttributes(Node $node): Node
    {
        $prices = [];
        foreach ($node->prices as $price) {
            if ($price->type === PriceType::CASH) {
                $prices['cash'] = ($price->amount) . ' تومان';
            }
            if ($price->type === PriceType::COIN) {
                $prices['coin'] = ($price->amount) . ' تومان';
            }
        }
        $node->prices = $prices;
        return $node;
    }

    /**
     * @param Node $package
     * @return array
     */
    public function getProductsIdInPackage(Node $package): array
    {
        return $package->packageItems->pluck('product_id')->toArray();
    }

    /**
     * @param Node $node
     * @param float $newPrice
     * @param string $priceType
     * @return void
     */
    private function updatePriceOfNode(Node $node, float $newPrice, string $priceType)
    {
        if ($node->prices->where('type', $priceType)->count()) {
            if (
                $node->prices->where('type', $priceType)->first()->amount != $newPrice
            ) {
                $node->prices()->where('type', $priceType)->update(['amount' => $newPrice]);
            }
        } else {
            $node->prices()->create([
                'type' => $priceType,
                'amount' => $newPrice
            ]);
        }
    }

    /**
     * @param Node $node
     * @param float|int $newPrice
     * @return void
     */
    public function updateCashPriceOfNode(Node $node, $newPrice)
    {
        $this->updatePriceOfNode($node, (float)$newPrice, PriceType::CASH);
    }

    /**
     * @param Node $node
     * @param float|int $newPrice
     * @return void
     */
    public function updateCoinPriceOfNode(Node $node, $newPrice)
    {
        $this->updatePriceOfNode($node, (float)$newPrice, PriceType::COIN);
    }


    /**
     * @param Node $node
     * @param [type] $newPrice
     * @return void
     */
    public function updateFlashPriceOfNode(Node $node, $newPrice)
    {
        $this->updatePriceOfNode($node, (float)$newPrice, PriceType::FLASH);
    }

    /**
     * @param Node $node
     * @param [type] $newPrice
     * @return void
     */
    public function updateDVDPriceOfNode(Node $node, $newPrice)
    {
        $this->updatePriceOfNode($node, (float)$newPrice, PriceType::DVD);
    }

    /**
     * @param Node $node
     * @param array $prices
     * @return void
     */
    public function setPriceForNode(Node $node, array $prices)
    {
        $node->prices()->createMany($prices);
    }


    /**
     * @param Node $package
     * @param array $newProductsId
     * @return void
     */
    public function updateProductsOfPackage(Node $package, array $newProductsId)
    {
        $package->packageItems()->delete();
        $packageItem = [];
        foreach ($newProductsId as $item) {
            $packageItem[] = [
                'product_id' => (int)$item
            ];
        }
        $package->packageItems()->createMany($packageItem);
    }

    /**
     * @inheritDoc
     */
    public function checkNodeBoughtUser(int $node_id, int $user_id): bool
    {

        $node = $this->findOneOrFail($node_id);
        if ($this->checkNodeIsFree($node)) {
            return true;
        }
        $leftOfCurrentNode = $node->left;
        $user = $this->user->findorfail($user_id);
        $order_ids = $user->orders()->where('is_paid', 1)->pluck('id')->toArray();
        $orderables = $this->orderable;
        $count = $orderables->whereIn('order_id', $order_ids)->whereHas("node" , function ($q) use($leftOfCurrentNode) {
            $q->where("left", "<=", $leftOfCurrentNode)->where("right", ">", $leftOfCurrentNode);
        })->count();
        return $count > 0;
    }

    public function getNodeWithSeparateMedias(int $node_id)
    {
        return $this->model->where('status', 'publish')->with(['prices', 'images', 'voices', 'videos', 'prices', 'pdfs', 'offices'])->find($node_id);
    }

    /**
     * count of used product in packages
     *
     * @param \App\Models\Node $product
     * @return integer
     */
    public function countOfUseProductInPackages(\App\Models\Node $product): int
    {
        return $this->model
            ->whereHas('packageItems', function ($q) use ($product) {
                return $q->where('product_id', $product->id);
            })
            ->count();
    }

    /**
     * @param int $id
     * @return int
     */
    public function forceDelete(int $id)
    {
        $node = $this->findOneOrFail($id);
        if ($node) {
            $node->prices()->forceDelete();
            return $this->model->where('id', $id)->forceDelete();
        }
    }

    /**
     * @param Node $node
     * @param integer $order
     * @return void
     */
    public function getNodeMediaWithSpecificOrder(Node $node, int $order)
    {
        return $node->medias()->where('order', $order)->first();
    }

    /**
     * @param Node $product
     * @return null|\App\Models\Media
     */
    public function getProductFile(Node $product)
    {
        return $product->medias()->where('order', null)->first();
    }

    /**
     * @param Node $node
     * @return null|\App\Models\Media
     */
    public function getNodeIndexMedia(Node $node)
    {
        return $this->getNodeMediaWithSpecificOrder($node, \App\Enums\MediaOrderType::INDEX);
    }

    /**
     * @param Node $node
     * @return null|\App\Models\Media
     */
    public function getNodeIconMedia(Node $node)
    {
        return $this->getNodeMediaWithSpecificOrder($node, \App\Enums\MediaOrderType::ICON_MEDIA_ORDER);
    }

    /**
     * @param Node $node
     * @return null|\App\Models\Media
     */
    public function getNodeBackgroundMedia(Node $node)
    {
        return $this->getNodeMediaWithSpecificOrder($node, \App\Enums\MediaOrderType::BACKGROUND_MEDIA_ORDER);
    }

    public function getPaginatedPublishPackages(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        return !is_null($with)
            ? $this->model
                ->packages()
                ->publish()
                ->orderBy($orderBy, $sortType)
                ->with($with)
                ->paginate($limit)
            : $this->model
                ->packages()
                ->publish()
                ->orderBy($orderBy, $sortType)
                ->paginate($limit);
    }

    public function getPaginateRoots(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): LengthAwarePaginator
    {
        return !is_null($with)
            ? $this->model
                ->roots()
                ->orderBy($orderBy, $sortType)
                ->with($with)
                ->paginate($limit)
            : $this->model
                ->roots()
                ->orderBy($orderBy, $sortType)
                ->paginate($limit);
    }

    public function checkNodeIsFree($node): bool
    {

        if (!$node->prices()->where('type', PriceType::CASH)->value('amount')) {
            return true;
        }
        return false;
    }

}

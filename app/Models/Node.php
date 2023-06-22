<?php

namespace App\Models;

use App\Enums\MediaType;
use Baum\Node as BaumNode;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Mockery\Matcher\Not;

/**
 * App\Models\Node
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $left
 * @property int $right
 * @property int $depth
 * @property int $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read BestNode $bestNode
 * @property-read \Baum\Extensions\Eloquent\Collection|Node[] $children
 * @property-read Collection|Comment[] $comments
 * @property-read Collection|Conversation[] $conversations
 * @property-read Collection|Media[] $images
 * @property-read Collection|Orderable[] $orders
 * @property-read Node $parent
 * @property-read Collection|Price[] $prices
 * @property-read Collection|Media[] $videos
 * @property-read Collection|Media[] $voices
 * @method static Builder|BaumNode limitDepth($limit)
 * @method static Builder|Node newModelQuery()
 * @method static Builder|Node newQuery()
 * @method static Builder|Node query()
 * @method static Builder|Node whereCreatedAt($value)
 * @method static Builder|Node whereDepth($value)
 * @method static Builder|Node whereDescription($value)
 * @method static Builder|Node whereId($value)
 * @method static Builder|Node whereLeft($value)
 * @method static Builder|Node whereParentId($value)
 * @method static Builder|Node whereRight($value)
 * @method static Builder|Node whereTitle($value)
 * @method static Builder|Node whereUpdatedAt($value)
 * @method static Builder|BaumNode withoutNode($node)
 * @method static Builder|BaumNode withoutRoot()
 * @method static Builder|BaumNode withoutSelf()
 * @mixin Eloquent
 */
class Node extends BaumNode
{
	use SoftDeletes;
	/**
	 * @var string
	 */
	protected $table = 'nodes';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 'title', 'description', 'parent_id', 'create_at', 'updated_at', 'is_product', 'ownerable_id', 'ownerable_type', 'status', 'score'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'left',
		'right',
		'depth'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [];

	/**
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Column name which stores reference to parent's node.
	 *
	 * @var string
	 */
	protected $parentColumn = 'parent_id';

	/**
	 * Column name for the left index.
	 *
	 * @var string
	 */
	protected $leftColumn = 'left';

	/**
	 * Column name for the right index.
	 *
	 * @var string
	 */
	protected $rightColumn = 'right';

	/**
	 * Column name for the depth field.
	 *
	 * @var string
	 */
	protected $depthColumn = 'depth';

	/**
	 * Column to perform the default sorting
	 *
	 * @var string
	 */
	protected $orderColumn = null;

	/**
	 * With Baum, all NestedSet-related fields are guarded from mass-assignment
	 * by default.
	 *
	 * @var array
	 */
	protected $guarded = [
		'id', 'parent_id', 'left', 'right', 'depth',
	];


	/**
	 * get Base Part of Path for medias that uploaded for product
	 * @return string
	 */
	public function nodeMediaPath(): string
	{
		return 'upload' . DIRECTORY_SEPARATOR . 'node' . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR;
	}

	/**
	 * get Base Part of Path for medias that uploaded for product
	 * @return string
	 */
	public function productMediaPath($is_in_storage = false): string
	{
		return 'upload' . DIRECTORY_SEPARATOR . 'product' .
			DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR;
	}

	// ---------- SCOPE ----------
	public function scopeProducts($query)
	{
		return $query->where('is_product', true)
			->doesntHave('packageItems');
	}
	public function scopePackages($query)
	{
		return $query->where('is_product', true)
			->whereHas('packageItems');
	}

	public function scopePublish($query)
	{
		return $query->where('status', 'publish');
	}

	// ---------- RELATION ----------

	/**
	 * @return HasOne
	 */
	public function bestNode()
	{
		return $this->hasOne(BestNode::class, 'node_id', 'id');
	}

	/**
	 * @return HasMany
	 */
	public function groupConversations()
	{
		return $this->hasMany(GroupConversation::class, 'node_id', 'id');

    }

    /**
	 * @return HasMany
	 */
	public function notes()
	{
		return $this->hasMany(Note::class,'node_id' , 'id');
	}

	/**
	 * @return MorphMany
	 */
	public function orderable()
	{
	    //todo : change it to belong to many
		return $this->morphMany(Orderable::class, 'nodeable');
	}

	/**
	 * @return HasMany
	 */
	public function sliders()
	{
		return $this->hasMany(Slider::class);
	}

	public function medias()
	{
		return $this->morphToMany(Media::class, 'mediable')->withPivot('type', 'order');
	}

	/**
	 * @return MorphToMany
	 */
	public function images()
	{
		return $this->morphToMany(Media::class, 'mediable')
			->wherePivot('type', '=', MediaType::IMAGE)->withPivot('order')->orderBy('order','asc');
	}

	/**
	 * @return MorphToMany
	 */
	public function voices()
	{
		return $this->morphToMany(Media::class, 'mediable')
			->wherePivot('type', '=', MediaType::VOICE)->withPivot('order');
	}

	/**
	 * @return MorphToMany
	 */
	public function videos()
	{
		return $this->morphToMany(Media::class, 'mediable')
			->wherePivot('type', '=', MediaType::VIDEO)->withPivot('order');
	}

	/**
	 * @return MorphToMany
	 */
	public function pdfs()
	{
		return $this->morphToMany(Media::class, 'mediable')
			->wherePivot('type', '=', MediaType::PDF)->withPivot('order');
	}

	/**
	 * @return MorphToMany
	 */
	public function offices()
	{
		return $this->morphToMany(Media::class, 'mediable')
			->wherePivotIn('type', MediaType::OFFICE);
	}

	/**
	 * @return HasMany
	 */
	public function prices(): HasMany
	{
		return $this->hasMany(Price::class, 'node_id', 'id');
	}

	public function discount()
	{
		return $this->morphOne(Discount::class, 'discountable');
	}

	public function nodes(): HasMany
	{
		return $this->hasMany(Node::class, 'parent_id');
	}

	public function childrenNodes(): HasMany
	{
		return $this->hasMany(Node::class, 'parent_id')->with('nodes');
	}

	public function ownerable()
	{
		return $this->morphTo();
	}

	public function packageItems()
	{
		return $this->hasMany(PackageProduct::class, 'package_id');
	}

	public function getFullTitleAttribute($node_id = null)
	{
		$node = $this;
		if (!empty($node_id)) {
			$node = self::findOrFail($node_id);
		}
		$str = "";
		if (!$node->parent_id) {
			return $node->title;
		}
		$str .= $node->getFullTitleAttribute($node->parent_id) . " -> " . $node->title;
		return $str;
	}
}

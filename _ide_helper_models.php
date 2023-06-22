<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\BestNode
 *
 * @property int $id
 * @property int $node_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Node $node
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BestNode whereUpdatedAt($value)
 */
	class BestNode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $user_id
 * @property string $reason
 * @property float $amount
 * @property string $reference_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUserId($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BestNode $bestNode
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Models\Node[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Conversation[] $conversations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Orderable[] $orders
 * @property-read \App\Models\Node $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Price[] $prices
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $videos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $voices
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node limitDepth($limit)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Node whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutNode($node)
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutSelf()
 */
	class Node extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Price
 *
 * @property int $id
 * @property int $node_id
 * @property string $type
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Node $node
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereUpdatedAt($value)
 */
	class Price extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Mediable
 *
 * @property int $id
 * @property int $mediable_id
 * @property string $mediable_type
 * @property int $media_id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Media $media
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereMediableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereMediableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mediable whereUpdatedAt($value)
 */
	class Mediable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SmsCode
 *
 * @property int $id
 * @property string $mobile
 * @property string $code
 * @property string|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SmsCode whereMobile($value)
 */
	class SmsCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserIMIE
 *
 * @property int $id
 * @property int $user_id
 * @property string $imie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereImie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserIMIE whereUserId($value)
 */
	class UserIMIE extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Teacher
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Conversation[] $conversations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Teacher whereUpdatedAt($value)
 */
	class Teacher extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Discount
 *
 * @property int $id
 * @property string $title
 * @property string $code
 * @property string $type
 * @property string $value
 * @property string|null $description
 * @property bool $is_global
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereIsGlobal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereValue($value)
 */
	class Discount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Enum
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Enum whereValue($value)
 */
	class Enum extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentType
 *
 * @property int $id
 * @property int $order_id
 * @property float $price
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereUpdatedAt($value)
 */
	class PaymentType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $images
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereUpdatedAt($value)
 */
	class Slider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Notification
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Conversation
 *
 * @property int $id
 * @property string $text
 * @property int $node_id
 * @property int $conversationable_id
 * @property string $conversationable_type
 * @property int $reply_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Conversation[] $conversationable
 * @property-read \App\Models\Node $node
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation whereConversationableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation whereConversationableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation whereReplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Conversation whereUpdatedAt($value)
 */
	class Conversation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Conversation[] $conversations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AccountBank
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $account_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountBank whereUserId($value)
 */
	class AccountBank extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Invite
 *
 * @property int $id
 * @property int $user_id
 * @property int $invited_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $invited
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereInvitedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invite whereUserId($value)
 */
	class Invite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property float $price
 * @property int $discount_id
 * @property float $discount_price
 * @property bool $is_paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Models\Node[] $nodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentType[] $paymentTypes
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Media
 *
 * @property int $id
 * @property string $size
 * @property string $path
 * @property string $duration
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Models\Node[] $nodes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Slider[] $sliders
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Media withoutTrashed()
 */
	class Media extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $user_id
 * @property int $node_id
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Node $node
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $voices
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Orderable
 *
 * @property int $id
 * @property int $orderable_id
 * @property string $orderable_type
 * @property int $order_id
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable whereOrderableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable whereOrderableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Orderable whereUpdatedAt($value)
 */
	class Orderable extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile
 * @property \Illuminate\Support\Carbon $birth_date
 * @property string $invite_code
 * @property string $fcm_token
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AccountBank[] $accountsBanks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Conversation[] $conversations
 * @property-read \App\Models\UserIMIE $imie
 * @property-read \App\Models\Invite $invitedFrom
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invite[] $invites
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFcmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereInviteCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}


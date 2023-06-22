<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DiscountRequest;
use App\Http\Controllers\Controller;
use App\Repositories\{DiscountRepositoryImp, UserRepositoryImp};
use App\Models\Discount;

class DiscountController extends Controller
{

    /** @var DiscountRepositoryImp $discountRepo */
    private $discountRepo;

    /** @var UserRepositoryImp $userRepo */
    private $userRepo;

    public function __construct(
        DiscountRepositoryImp $discountRepo,
        UserRepositoryImp $userRepo
    ) {
        $this->discountRepo = $discountRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items =  $this->discountRepo->paginate();
        foreach ($items->items() as $item) {
            $item->translate_type = \App\Enums\DiscountType::getValue($item->type);
        }
        return view('admin.discount.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $discountTypes = \App\Enums\DiscountType::toArray();
        return view('admin.discount.create', [
            'discountTypes' => $discountTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DiscountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        /** @var array $data */
        $data = $request->only([
            'title',
            'code',
            'type',
            'description',
        ]);

        $data['value'] = json_encode($this->discountRepo->getRawValueFormat());

        /** @var Discount $discount */
        $discount = $this->discountRepo->create($data);
        setSuccessAlertSession();
        return redirect(
            route('admin.discounts.edit.completion', [
                'discount' => $discount->id
            ])
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /** @var Discount $discount */
        $discount = $this->discountRepo->findOneOrFail($id);
        /** @var array $discountTypes */
        $discountTypes = \App\Enums\DiscountType::toArray();

        return view('admin.discount.edit', [
            'discount' => $discount,
            'discountTypes' => $discountTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DiscountRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $request, $id)
    {
        /** @var Discount $discount */
        $discount = $this->discountRepo->findOneOrFail($id);

        /** @var array $data */
        $data = $request->only([
            'title',
            'code',
            'type',
            'description',
        ]);

        if ($data['type'] === 'user') {
            if (!$this->userRepo->count()) {
                setDangerAlertSession('متاسفانه هیچ کاربری در سیستم ثبت نشده است.');
                return redirect()->back();
            }
        }

        $this->discountRepo->update($data, $discount->id);
        setSuccessAlertSession('اطلاعات اولیه تخفیف با موفقیت ثبت شد.');
        return redirect(
            route('admin.discounts.edit.completion', [
                'discount' => $discount->id
            ])
        );
    }

    public function editCompletion($id)
    {
        /** @var Discount $discount */
        $discount = $this->discountRepo->findOneOrFail($id);
        $data = [
            'discount' => $discount
        ];
        if ($discount->type === 'time') {
            /** @var array $priodTime */
            $priodTime = $this->discountRepo->getPriodTimeFromDiscountValue($discount);
            $discount->start_unix_time = $priodTime['start_at'] ?? null;
            $discount->end_unix_time = $priodTime['end_at'] ?? null;
        } else if ($discount->type === 'user') {
            $data['users'] = $this->userRepo->all();
        } else if ($discount->type === 'count') {
            $discount->allowed_count  = $this->discountRepo->getNumberOfTimesAllowedToUse($discount);
        }

        $discount->translate_type = \App\Enums\DiscountType::getValue($discount->type);
        return view('admin.discount.editCompletion', $data);
    }

    public function updateCompletion(DiscountRequest $request, $id)
    {
        /** @var Discount $discount */
        $discount = $this->discountRepo->findOneOrFail($id);

        if ($discount->type === 'time') {
            $data['value'] =  json_encode(
                $this->discountRepo->setDateInValue(
                    $this->discountRepo->getRawValueFormat(),
                    new \Datetime(
                        $request->get('start')
                    ),
                    new \Datetime(
                        $request->get('end')
                    )
                )
            );
        } else if ($discount->type === 'user') {
            $users_id = $request->get('users');
            array_walk($users_id, function (&$item) {
                $item = (int) $item;
            });
            $data['value'] =  json_encode(
                $this->discountRepo->setAllowedUsersIdInValue(
                    $this->discountRepo->getRawValueFormat(),
                    $users_id
                )
            );
        } else if ($discount->type === 'count') {
            $data['value'] =  json_encode(
                $this->discountRepo->setCountInValue(
                    $this->discountRepo->getRawValueFormat(),
                    $request->get('count')
                )
            );
        } else {
            $data['value'] = json_encode($this->discountRepo->getRawValueFormat());
        }

        $this->discountRepo->update($data, $discount->id);
        setSuccessAlertSession();
        return redirect(
            route('admin.discounts.index')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var Discount $discount */
        $discount = $this->discountRepo->findOneOrFail($id);
        $discount->delete();
        setSuccessAlertSession();
        return redirect(
            route('admin.discounts.index')
        );
    }
}

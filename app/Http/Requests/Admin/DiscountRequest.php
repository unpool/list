<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest as FormRequest;
use App\Models\Discount;
use App\Repositories\DiscountRepository;
use App\Repositories\DiscountRepositoryImp;
use Morilog\Jalali\Jalalian;

class DiscountRequest extends FormRequest
{
	public function prepareForValidation()
	{
		switch ($this->actionName()) {
			case 'update':
				$this->convertJalaliDateToGregorianFromRequest();
				break;
			case 'updateCompletion':
				$this->convertJalaliDateToGregorianFromRequest();
				break;
			default:
				break;
		}
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		switch ($this->actionName()) {
			case 'store':
				$rules = [
					'title' => 'required',
					'code' => 'required|unique:discounts,code',
					'type' => 'required',
					'discription' => 'nullable|min:3'
				];
				break;
			case 'update':
				$rules = [
					'title' => 'required',
					'code' => 'required|unique:discounts,code,' . $this->getParamaterFromRoute('discount'),
					'type' => 'required',
					'discription' => 'nullable|min:3'
				];
				break;
			case 'updateCompletion':
				$discount = $this->findDiscount((int) $this->getParamaterFromRoute('discount'));
				if ($discount->type === 'time') {
					$rules = [
						'start' => 'required|date',
						'end' => 'required|date|after:start'
					];
				} else if ($discount->type === 'count') {
					$rules = [
						'count' => 'required|numeric|min:1',
					];
				} else {
					$rules = [
						'users' => 'required|array',
						'users.*' => 'numeric'
					];
				}
				break;
			default:
				$rules = [];
				break;
		}
		return $rules;
	}

	private function convertJalaliDateToGregorianFromRequest()
	{
		if ($this->has('start')) {
			/** @var Jalalian $birth_date */
			$birth_date = Jalalian::fromFormat('Y/m/d', convert_to_english_digit($this->get('start')));
			$this->merge([
				'start' => date('Y-m-d', $birth_date->getTimestamp()),
			]);
		}
		if ($this->has('end')) {
			/** @var Jalalian $birth_date */
			$birth_date = Jalalian::fromFormat('Y/m/d', convert_to_english_digit($this->get('end')));
			$this->merge([
				'end' => date('Y-m-d', $birth_date->getTimestamp()),
			]);
		}
	}

	/**
	 * get parameter from route
	 * @param  string $parameter parameter name
	 * @return null|string
	 */
	private function getParamaterFromRoute(string $parameter)
	{
		return $this->route()->parameter($parameter);
	}

	/**
	 * @param integer $id
	 * @return \App\Models\Discount|null
	 */
	private function findDiscount(int $id)
	{
		$discountRepo = new DiscountRepository(new Discount());
		return $discountRepo->findOneOrFail($id);
	}
}

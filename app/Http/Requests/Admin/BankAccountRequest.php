<?php

namespace App\Http\Requests\Admin;

use App\Classes\FormRequest;
use App\Rules\BankAccount;

class BankAccountRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return $this->actionRule();
	}

	/**
	 * @return array
	 */
	protected function ruleStore(): array{
		return [
			'bank_account' => ['required', 'size:16', new BankAccount],
			'first_name' => 'required',
			'last_name' => 'required',
		];
	}
}

<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Morilog\Jalali\Jalalian;

class User extends BaseRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth('admin')->check();
	}

	public function prepareForValidation()
	{
		switch ($this->actionName()) {
			case 'store':
				if ($this->has('birth_date') and $this->get('birth_date')) {
					/** @var Jalalian $birth_date */
					$birth_date = Jalalian::fromFormat('Y/m/d', convert_to_english_digit($this->get('birth_date')));
					$this->merge([
						'birth_date' => date('Y-m-d', $birth_date->getTimestamp()),
					]);
				}
				break;
			case 'update':
				if ($this->has('birth_date') and $this->get('birth_date')) {
					/** @var Jalalian $birth_date */
					$birth_date = Jalalian::fromFormat('Y/m/d', convert_to_english_digit($this->get('birth_date')));
					$this->merge([
						'birth_date' => date('Y-m-d', $birth_date->getTimestamp()),
					]);
				}
				break;
			case 'usersInviteOtherUsersByCountAndDate':
				/** @var Jalalian $from_date */
				$from_date = Jalalian::fromFormat('Y/m/d', convert_to_english_digit($this->from_date));
				/** @var Jalalian $to_date */
				$to_date = Jalalian::fromFormat('Y/m/d', convert_to_english_digit($this->to_date));
				$this->merge([
					'from_date' => date('Y-m-d', $from_date->getTimestamp()),
					'to_date' => date('Y-m-d', $to_date->getTimestamp()),
				]);
				break;
			default:
				break;
		}
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(): array
	{
		switch ($this->actionName()) {
			case 'store':
				$rules = [
					'first_name' => 'nullable|min:2',
					'last_name' => 'nullable|min:2',
					'email' => 'nullable|unique:users,email',
					'birth_date' => 'nullable|date',
					'password' => 'required|min:6',
					'mobile' => ['required', 'size:11', new \App\Rules\Mobile],
					'score' => 'required|numeric',
					'share' => 'nullable|numeric',
					'inviteBy' => 'nullable|numeric|in:' . implode(',', \App\User::all()->pluck('id')->toArray())
				];
				break;
			case 'update':
				$rules = [
					'first_name' => 'nullable|min:2',
					'last_name' => 'nullable|min:2',
					'email' => 'nullable|unique:users,email,' . $this->getParamaterFromRoute('user'),
					'birth_date' => 'nullable|date',
					'password' => 'min:6|nullable',
					'mobile' => ['required', 'size:11', new \App\Rules\Mobile],
					'score' => 'required|numeric',
					'share' => 'nullable|numeric',
					'inviteBy' => 'nullable|numeric|exists:users,id',
				];
				break;
			case 'usersInviteOtherUsersByCountAndDate':
				$rules = [
					'count' => 'required',
					'from_date' => 'required|date',
					'to_date' => 'required|date|after:from_date',
				];
				break;
			default:
				$rules = [];
				break;
		}
		return $rules;
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
}

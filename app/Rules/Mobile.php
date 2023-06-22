<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Mobile implements Rule {
	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value): bool {
		return (preg_match("/^09[0-9]{9}$/", $value) || preg_match("/^00989[0-9]{9}$/", $value));
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return __('validation.not_valid');
	}
}

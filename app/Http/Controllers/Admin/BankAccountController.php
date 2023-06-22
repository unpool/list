<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankAccountRequest;
use App\Repositories\AccountBankRepositoryImp;

class BankAccountController extends Controller {
	/**
	 * @var mixed
	 */
	private $bankAccountRepo;

	public function __construct(AccountBankRepositoryImp $bankAccountRepo) {
		$this->bankAccountRepo = $bankAccountRepo;
	}

	/**
	 * @param  \App\User          $user
	 * @param  BankAccountRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(\App\User $user, BankAccountRequest $request): \Illuminate\Http\RedirectResponse{
		$user->accountsBanks()->create([
			'account_number' => $request->bank_account,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
		]);
		session()->flash('alert', [
			'type' => 'success',
			'message' => 'با موفقیت انجام شد.',
		]);
		return redirect()->to(route('admin.user.edit', ['user' => $user]));
	}

	/**
	 * @param $user
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($user, $id): \Illuminate\Http\RedirectResponse {
		try {
			$res = $this->bankAccountRepo->delete($id);
			session()->flash('alert', [
				'type' => 'success',
				'message' => 'با موفقیت انجام شد.',
			]);
		} catch (\Exception $e) {
			session()->flash('alert', [
				'type' => 'danger',
				'message' => 'متاسفانه خاطیی رخ داده است.',
			]);
		}
		return redirect()->to(route('admin.user.edit', ['user' => $user]));
	}
}

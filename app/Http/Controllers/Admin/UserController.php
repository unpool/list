<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\{UserRepositoryImp, UserIMIERepositoryImp};
use App\User;
use Illuminate\View\View;
use App\Http\Requests\Admin\User\SearchUsersRequest;

use App\Http\Requests\Admin\User\AdminNotesRequest;
use App\Models\Invite;
use App\Models\Order;
use App\Models\Orderable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** * @var UserRepositoryImp */
    private $userRepo;

    /** * @var UserIMIERepositoryImp */
    private $userIMIERepo;

    public function __construct(UserRepositoryImp $userRepo, UserIMIERepositoryImp $userIMIERepo)
    {
        $this->userRepo = $userRepo;
        $this->userIMIERepo = $userIMIERepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index', [
            'users' => $this->userRepo->paginate()
        ]);
    }

    public function searchUsers(SearchUsersRequest $request)
    {

        $users = User::where($request['search-filed'],  'LIKE', '%'.$request['search']. '%')->get();

        return view('admin.user.searchUsers', [
            'users' => $users,
            'valueSearch' => [
                'search' => $request['search'],
                'search-filed' => $request['search-filed'],
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.user.create', [
            'usersCanBeInviteAnother' => $this->userRepo->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\User $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(\App\Http\Requests\Admin\User $request): \Illuminate\Http\RedirectResponse
    {
        /** @var array $data */
        $data = $request->only('first_name', 'last_name', 'email', 'birth_date', 'mobile', 'city', 'province', 'address');

        $data['score'] = (int)$request->get('score');
        $data['share'] = (int)$request->get('share');
        $data['password'] = \Hash::make($request->get('password'));
        $data['invite_code'] = $this->userRepo->getInviteCode();

        /** @var User $user */
        $user = $this->userRepo->create($data);

        // invited by
        if ($request->has('inviteBy') and $request->get('inviteBy')) {
            $invitedBy = $this->userRepo->find($request->get('inviteBy'));
            if ($invitedBy instanceof \App\User) {
                $this->userRepo->setInviteByForUser($user, $invitedBy);
            }
        }

        setSuccessAlertSession();
        return redirect()->to(route('admin.user.show', ['user' => $user->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(int $id): \Illuminate\View\View
    {
        return view('admin.user.show', [
            'user' => $this->userRepo->findOneOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id): \Illuminate\View\View
    {
        /** @var \App\User $user */
        $user = $this->userRepo->findWithInviter($id);
        $users = User::all();
        return view('admin.user.edit', [
            'user' => $user,
            'users' => $users,
            'userIMIEs' => $this->userIMIERepo->getUserIMIEs($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Admin\User $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(\App\Http\Requests\Admin\User $request, int $id)
    {
        /** * @var \App\User $user */
        $user = $this->userRepo->findOneOrFail($id);
        // TODO : update city and province

        $this->userRepo->updateWallet($user, $request->get('wallet'));

        if ($request->get('shareAction')) {
            if ($request->get('shareAction') === 'moveShareToWallet') {
                $this->userRepo->moveShareToWallet($user);
            }
            if ($request->get('shareAction') === 'moveShareToCart') {
                $this->userRepo->moveShareToCart($user);
            }
        }

        /** @var array $data */
        $data = $request->only('first_name', 'last_name', 'email', 'birth_date', 'mobile', 'score', 'address');
        if ($request->password) {
            $data['password'] = \Hash::make($request->get('password'));
        }

        $invitedBy = Invite::where('invited_id', $user->id)->first();
        if (!is_null($invitedBy)) {
            $invitedBy->update(['user_id' => $request->input('inviteBy')]);
        } else {
            Invite::create([
                'user_id' => $request->input('inviteBy'),
                'invited_id' => $user->id
            ]);
        }

        $this->userRepo->update($data, $id);
        setSuccessAlertSession();
        return redirect()->to(route('admin.user.show', ['user' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userRepo->delete($id);
        setSuccessAlertSession();
        return redirect(
            route('admin.user.index')
        );
    }

    public function usersInviteUsersWithActiveProfile(): View
    {
        return view('admin.user.usersInviteActiveUser', [
            'users' => $this->userRepo->getUsersThatInvitedOtherActiveUser(),
        ]);
    }

    public function usersInviteOtherUsersByCountAndDate(\App\Http\Requests\Admin\User $request)
    {
        $users = $this->userRepo->getUsersInvitedAnotherFilterByCountAndDate(
            (int)$request->get('count'),
            new \DateTime($request->get('from_date')),
            new \DateTime($request->get('to_date'))
        );
        return view('admin.user.usersInviteAnother', [
            'users' => $users,
            'count_of_introduced' => (int)$request->get('count'),
            'from_date' => GtoJ($request->get('from_date'), 'd-m-Y'),
            'to_date' => GtoJ($request->get('to_date'), 'd-m-Y'),
        ]);
    }

    public function show_info(User $user)
    {
        $invitedUsers = Invite::where('invited_id', $user['id'])
            ->with('user')
            ->get();

        $orders = Order::where('user_id', $user['id'])
            ->with('orderables', 'nodes')
            ->get();

        // dd($orders[0]['nodes'][0]['title']);

        return view('admin.user.show', compact('user', 'invitedUsers', 'orders'));
    }

    /**
     * @param User $user
     * @param AdminNotesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function admin_notes(User $user, AdminNotesRequest $request)
    {
        $user->update([
            'admin_notes' => $request['note']
        ]);

        return redirect()->route('admin.user.show_info', $user);

    }

    public function showFormSendNotificationToUser()
    {
        $users = User::all();

        return view('admin.user.sendNotificationToUser', compact('users'));
    }
}

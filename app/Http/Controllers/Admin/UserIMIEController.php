<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserIMIERepositoryImp;

class UserIMIEController extends Controller
{
    /** @var \App\Models\UserIMIE $userIMIE */
    private $userIMIE;

    public function __construct(UserIMIERepositoryImp $userIMIE)
    {
        $this->userIMIE = $userIMIE;
    }

    /**
     * @param string $id
     * @return void
     */
    public function delete($id)
    {
        $this->userIMIE->delete($id);
        return redirect()->back();
    }
}

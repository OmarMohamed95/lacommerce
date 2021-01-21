<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Model\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Auth;

class ProfileController extends Controller
{
    /**
     * @var UserRepositoryInterface $userRepository
     */
    private $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }

    /**
     * Profile index
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = $this->userRepository->find(Auth::user()->id);

        return view('app.profile.index')->with('user', $user);
    }

    /**
     * Update profile action
     *
     * @param ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $user = $this->userRepository->find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('profile_index');
    }
}

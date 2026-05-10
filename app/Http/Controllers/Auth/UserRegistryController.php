<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DepartmentRef;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Services\UserRegistrationService;

class UserRegistryController extends Controller
{
    public function __construct(UserRegistrationService $userRegistrationService)
    {
        $this->userRegistrationService = $userRegistrationService;
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     * 
     * This function only is used for the system set up with the first ever user.
     * User storing after the first register is located in the storeUser function on
     * the UserPanelController which stores a new user with mass assignment after the 
     * filling of a form.
     */
    public function register(Request $request): JsonResponse
    {
        $selectedRank = "user";

        $reqInfo = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $this->userRegistrationService->createUser($reqInfo, $selectedRank);

        //$user->rank = ('admin');
        //$user->save();

        return response()->json([
            'message' => 'Successfully created the user'
        ], 200);
    }

}
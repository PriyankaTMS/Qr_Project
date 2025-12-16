<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone' => 'required|nullable|string|max:15',
            'property_type' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'prefered_location' => 'nullable|string|max:255',
            'source_of_visite' => 'nullable|string|max:255',
        ]);
    }



    protected function create(array $data)
    {
        // dd($data);
        return User::create([
            'name' => $data['name'],
            //  'email' => $data['email'],
            'phone' => $data['phone'],
            'property_type' => $data['property_type'],
            'budget' => $data['budget'],
            'prefered_location' => $data['prefered_location'],
            'source_of_visite' => $data['source_of_visite'],
            //'password' => Hash::make('12345678'), // just example
        ]);
    }


    public function downloadIdCard($id)
    {
        $user = User::findOrFail($id);

        $pdf = Pdf::loadView('admin.user.id-card', compact('user'))
            ->setPaper('a6', 'portrait');

        return $pdf->download('id-card-' . $user->name . '.pdf');
    }



    protected function registered(Request $request, $user)
    {
        \Illuminate\Support\Facades\Auth::logout(); // logout user after registration

        // $qrUrl = url('/user-details/' . $user->id);
        // $fileName = 'qr_' . $user->id . '.svg';
        // $folder = public_path('users_qr_images');

        // if (!file_exists($folder)) {
        //     mkdir($folder, 0777, true);
        // }

        // $svgQr = QrCode::format('svg')->size(300)->generate($qrUrl);
        // file_put_contents($folder . '/' . $fileName, $svgQr);

        // $user->qr_code = $qrUrl;
        // $user->qr_image = $fileName;
        // $user->save();

        //     $qrCodeValue = $user->id;
        // $qrCodeValue = $user->id;
        $qrCodeValue = "ID: " . $user->id . "\nName: " . $user->name;

        $fileName = 'qr_' . $user->id . '.svg';

        // Folder root मध्ये बनवायचा
        $folder = base_path('users_qr_images');

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $svgQr = QrCode::format('svg')->size(300)->generate($qrCodeValue);
        file_put_contents($folder . '/' . $fileName, $svgQr);

        $user->qr_code = $qrCodeValue;
        $user->qr_image = $fileName;
        $user->save();

        return redirect()->route('success')
            ->with('success', 'Registration successful!')
            ->with('user_id', $user->id);
    }




    public function success()
    {
        return view('auth.success');
    }


    public function privacypolicy()
    {
        return view('auth.privacypolicy');
    }
}

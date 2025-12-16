<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;
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

    public function showRegistrationForm()
    {
        $qrCodes = QrCode::all();
        return view('auth.register', compact('qrCodes'));
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
            'qr_code_id' => 'nullable|exists:qr_codes,id',
        ]);
    }



    protected function create(array $data)
    {
        // dd($data);
        $qrCodeNo = null;
        if (!empty($data['qr_code_id'])) {
            $qrCode = QrCode::find($data['qr_code_id']);
            $qrCodeNo = $qrCode ? $qrCode->qr_code_no : null;
        }

        return User::create([
            'name' => $data['name'],
            //  'email' => $data['email'],
            'phone' => $data['phone'],
            'property_type' => $data['property_type'],
            'budget' => $data['budget'],
            'prefered_location' => $data['prefered_location'],
            'source_of_visite' => $data['source_of_visite'],
            'qr_code_id' => $data['qr_code_id'] ?? null,
            'qr_code_no' => $qrCodeNo,
            'otp' => rand(100000, 999999),
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

        $svgQr = QrCodeFacade::format('svg')->size(300)->generate($qrCodeValue);
        file_put_contents($folder . '/' . $fileName, $svgQr);

        $user->qr_code = $qrCodeValue;
        $user->qr_image = $fileName;
        $user->save();

        // Send OTP via WhatsApp
        Http::get('https://app.aiwati.com/api/whatsapp-base/send_template', [
            'api_key' => 'API1765878328TRwtkJpv3zjqjugIN1v00tMN3EK',
            'to' => $user->phone,
            'template' => '1639453563706347',
            'otp' => $user->otp
        ]);

        return redirect()->route('verify-otp', $user->id);
    }

    public function verifyOtp($userId)
    {
        $user = User::findOrFail($userId);
        return view('auth.verify-otp', compact('user'));
    }

    public function verifyOtpPost($userId, Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        $user = User::findOrFail($userId);
       // dd($user);
        if ($user && $user->otp == $request->otp) {
            $user->otp = null;
            $user->save();
            return redirect()->route('success');
        } else {
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }
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

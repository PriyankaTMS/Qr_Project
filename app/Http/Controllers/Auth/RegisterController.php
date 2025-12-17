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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Services\QrSvgToPngService;


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
        $qrCodes = QrCode::whereDoesntHave('user')->get();
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
        $user = User::with('qrCode')->findOrFail($userId);

        Log::info('RegisterController.verifyOtpPost: Starting OTP verification', [
            'user_id' => $userId,
            'user_phone' => $user->phone,
            'submitted_otp' => $request->otp,
            'stored_otp' => $user->otp
        ]);

        if ($user && $user->otp == $request->otp) {
            Log::info('RegisterController.verifyOtpPost: OTP verified successfully, clearing OTP and preparing WhatsApp message', [
                'user_id' => $user->id,
                'user_name' => $user->name
            ]);

            $user->otp = null;
            $user->save();

            // Generate PNG QR for WhatsApp delivery
            $svgPath = base_path('users_qr_images/' . $user->qr_image);
            $qrPayload = $user->qr_code_no; // Same payload used for SVG generation

            Log::info('RegisterController.verifyOtpPost: Starting PNG generation for WhatsApp', [
                'svg_path' => $svgPath,
                'qr_payload' => $qrPayload,
                'svg_exists' => file_exists($svgPath)
            ]);

            $pngPath = QrSvgToPngService::convert($svgPath, $qrPayload);
            $pngUrl = asset('qr_images_png/' . basename($pngPath));

            Log::info('RegisterController.verifyOtpPost: PNG conversion completed, preparing WhatsApp API call', [
                'png_path' => $pngPath,
                'png_url' => $pngUrl,
                'png_exists' => file_exists($pngPath)
            ]);

            // Send success WhatsApp message
            $whatsappData = [
                'api_key' => 'API1765878328TRwtkJpv3zjqjugIN1v00tMN3EK',
                'to' => $user->phone,
                'template' => '1575185220569951',
                'body' => [
                    $user->name,
                    $user->property_type ?? 'NAREDCO Nashik',
                    now()->format('d-m-Y'),
                    'qr'
                ],
                'header' => $pngUrl
            ];

            Log::info('RegisterController.verifyOtpPost: Preparing WhatsApp API request', [
                'api_endpoint' => 'https://app.aiwati.com/api/whatsapp-base/send_template',
                'request_data' => $whatsappData,
                'phone_format_check' => preg_match('/^[0-9]{10,15}$/', $user->phone) ? 'valid' : 'invalid',
                'png_url_accessible' => $this->checkUrlAccessible($pngUrl)
            ]);

            Log::info('RegisterController.verifyOtpPost: Sending WhatsApp success message', [
                'user_id' => $user->id,
                'phone' => $user->phone,
                'template' => '1575185220569951',
                'header_image_url' => $pngUrl,
                'message_body' => 'Hi ' . $user->name . ', The NAREDCO Nashik Expo is happening on ' . now()->format('d-m-Y') . '. We\'re excited to have you with us! Please visit the venue on the scheduled date. Show the attached QR at the entry point. This is a system-generated notification.'
            ]);

            $response = Http::timeout(30)->get('https://app.aiwati.com/api/whatsapp-base/send_template', $whatsappData);

            $responseData = $response->json();
            Log::info('RegisterController.verifyOtpPost: WhatsApp API response received', [
                'status_code' => $response->status(),
                'response_body' => $response->body(),
                'response_json' => $responseData,
                'success' => $response->successful(),
                'message_id' => $responseData['response']['messages'][0]['id'] ?? null,
                'message_status' => $responseData['response']['messages'][0]['message_status'] ?? null,
                'wa_id' => $responseData['response']['contacts'][0]['wa_id'] ?? null,
                'error_details' => $responseData['error'] ?? null
            ]);

            if (!$response->successful()) {
                Log::error('RegisterController.verifyOtpPost: WhatsApp API call failed', [
                    'error_code' => $response->status(),
                    'error_body' => $response->body(),
                    'troubleshooting' => [
                        'check_api_key' => 'Verify API1765878328TRwtkJpv3zjqjugIN1v00tMN3EK is valid',
                        'check_phone' => 'Phone should be 10-15 digits, may need country code',
                        'check_template' => 'Template 1575185220569951 should be approved',
                        'check_png_url' => 'PNG URL should be publicly accessible: ' . $pngUrl
                    ]
                ]);
            }

            return redirect()->route('success');
        } else {
            Log::warning('RegisterController.verifyOtpPost: OTP verification failed', [
                'user_id' => $user->id,
                'submitted_otp' => $request->otp
            ]);
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

    /**
     * Check if a URL is accessible
     */
    private function checkUrlAccessible(string $url): bool
    {
        try {
            $response = Http::timeout(5)->head($url);
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}

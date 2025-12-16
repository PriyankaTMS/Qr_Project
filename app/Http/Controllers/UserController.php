<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\QrCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $users = User::where('role', 'user')->get();
    //     return view('admin.user.index', compact('users'));
    // }


    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('comp_name', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%');
            }); // <- closes the closure AND the where call
        }

        if ($request->filled('sr_no')) {
            $query->where('id', $request->sr_no);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        if ($request->filled('register_date')) {
            $query->whereDate('created_at', $request->register_date);
        }

        $users = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());
        $count = $query->count();

        $register_date_count = 0;
        if ($request->filled('register_date_count')) {
            $register_date_count = User::where('role', 'user')->whereDate('created_at', $request->register_date_count)->count();
        }

        return view('admin.user.index', compact('users', 'count', 'register_date_count'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $qrCodes = QrCode::all();
        return view('admin.user.create', compact('qrCodes'));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'mobile_number' => 'required|string|max:15',
            'property_type' => 'nullable|string',
            'budget' => 'nullable|string',
            'preferred_location' => 'nullable|string|max:255',
            'source_of_visit' => 'nullable|string',
            'qr_code_id' => 'nullable|exists:qr_codes,id',
        ]);

        $qrCodeNo = null;
        if (!empty($request->qr_code_id)) {
            $qrCode = QrCode::find($request->qr_code_id);
            $qrCodeNo = $qrCode ? $qrCode->qr_code_no : null;
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile_number;
        $user->property_type = $request->property_type;
        $user->budget = $request->budget;
        $user->prefered_location = $request->preferred_location;
        $user->source_of_visite = $request->source_of_visit;
        $user->qr_code_id = $request->qr_code_id;
        $user->qr_code_no = $qrCodeNo;
        $user->save();

        // QR Code will store URL
        // $qrCodeValue = url('/user-details/' . $user->id);

        // $fileName = 'qr_' . $user->id . '.svg';

        // $folder = public_path('users_qr_images');
        // if (!file_exists($folder)) {
        //     mkdir($folder, 0777, true);
        // }

        // $svgQr = QrCode::format('svg')->size(300)->generate($qrCodeValue);
        // file_put_contents($folder . '/' . $fileName, $svgQr);

        // $user->qr_code = $qrCodeValue;
        // $user->qr_image = $fileName;
        // $user->save();



      //  $qrCodeValue = url('/user-details/' . $user->id);
      //$qrCodeValue = $user->id;
      // $qrCodeValue = $user->id;
      $qrCodeValue = "ID: " . $user->id . "\nName: " . $user->name;

      $fileName = 'qr_' . $user->id . '.svg';

      $folder = base_path('users_qr_images');

      if (!file_exists($folder)) {
          mkdir($folder, 0777, true);
      }

      $svgQr = QrCodeFacade::format('svg')->size(300)->generate($qrCodeValue);
      file_put_contents($folder . '/' . $fileName, $svgQr);

      $user->qr_code = $qrCodeValue;
      $user->qr_image = $fileName;
      $user->save();



// Finally redirect
        return redirect()->route('users.index')
    ->with('success', 'User created successfully with QR.');



        return redirect()->route('users.index')->with('success', 'User created successfully with QR.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $qrCodes = QrCode::all();
        return view('admin.user.edit', compact('user', 'qrCodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //return $request->all();
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile_number' => 'nullable|string|max:15',
            'property_type' => 'nullable|string',
            'budget' => 'nullable|string',
            'preferred_location' => 'nullable|string|max:255',
            'source_of_visit' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'qr_code_id' => 'nullable|exists:qr_codes,id',
        ]);

        $qrCodeNo = null;
        if (!empty($request->qr_code_id)) {
            $qrCode = QrCode::find($request->qr_code_id);
            $qrCodeNo = $qrCode ? $qrCode->qr_code_no : null;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile_number;
        $user->property_type = $request->property_type;
        $user->budget = $request->budget;
        $user->prefered_location = $request->preferred_location;
        $user->source_of_visite = $request->source_of_visit;
        $user->payment_status = $request->payment_status;
        $user->qr_code_id = $request->qr_code_id;
        $user->qr_code_no = $qrCodeNo;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Download ID card for the user.
     */
    // public function downloadIdCard($id)
    // {
    //     $user = User::findOrFail($id);

    //     $pdf = Pdf::loadView('admin.user.id-card', compact('user'))
    //         ->setPaper('a6', 'portrait');

    //     return $pdf->download('id-card-' . $user->name . '.pdf');
    // }



    // public function downloadIdCard($id)
    // {
    //     $user = User::findOrFail($id);

    //     $pdf = Pdf::loadView('admin.user.id-card', compact('user'))
    //         ->setPaper('a6', 'portrait');

    //     return $pdf->download('id-card-' . $user->name . '.pdf');
    // }


 public function printQR($id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $user->name,
            'comp_name' => $user->comp_name,
            'qr_image' => base_path('users_qr_images/' . $user->qr_image),
            'registration_date' => $user->created_at->format('d-m-Y'), // ✅ Added
        ];

         //$customPaper = array(0, 0, 242.64, 153.54);
          $customPaper = array(0, 0, 288, 676.8);

        $pdf = PDF::loadView('admin.user.print', $data)->setPaper('A4', 'portrait');

        return $pdf->download($user->name . '_QR.pdf');
    }


// public function printQR($id)
// {
//     $user = User::findOrFail($id);

//     $data = [
//         'name' => $user->name,
//         'qr_image' => base_path('users_qr_images/' . $user->qr_image),
//     ];

//     // Vertical ID Card | 2.125in width x 3.37in height
//     $customPaper = [0, 0, 153.54, 242.64];

//     $pdf = Pdf::loadView('admin.user.print', $data)
//                 ->setPaper($customPaper, 'portrait');

//     return $pdf->download($user->name . '_ID_CARD.pdf');
// }





    // public function downloadIdCard($id)
    // {
    //     $user = User::findOrFail($id);

    //     // Get stored QR Image Path
    //     $qrImagePath = public_path('users_qr_images/' . $user->qr_image);

    //     // Load ID Card Template SVG
    //     $svgPath = public_path('idcardfront-2.svg');
    //     $svgContent = file_get_contents($svgPath);

    //     // Replace placeholders
    //     $svgContent = str_replace('name-placeholder', $user->name, $svgContent);
    //     $svgContent = str_replace('qr-placeholder', $qrImagePath, $svgContent);

    //     // Create temp SVG for this user
    //     $tempSvg = storage_path('app/public/idcard_' . $user->id . '.svg');
    //     file_put_contents($tempSvg, $svgContent);

    //     // Convert SVG → PDF using DOMPDF
    //     $pdf = Pdf::loadHTML($svgContent)
    //         ->setPaper('a6', 'portrait');

    //     return $pdf->download('ID-CARD-' . $user->name . '.pdf');
    // }

     public function downloadIdCard($id)
    {
        $user = User::findOrFail($id);

       // $svgTemplatePath = base_path('Front 01-03.svg');
        $svgTemplatePath = base_path('Front 01-05.svg');
        $svgContent = file_get_contents($svgTemplatePath);

        // Replace Name
       // $svgContent = str_replace('Omkar Kushare', e($user->name), $svgContent);
        $svgContent = str_replace('OMKAR KUSHARE', e($user->name), $svgContent);
         $svgContent = str_replace('Techmet IT Solutions', e($user->comp_name), $svgContent);
        // Get the QR image file path
        $qrImageFilePath = base_path('users_qr_images/' . $user->qr_image);

        // Check if QR image exists
        if (file_exists($qrImageFilePath)) {
            // Read the QR image content and convert to base64
            $qrImageContent = file_get_contents($qrImageFilePath);
            $qrBase64 = base64_encode($qrImageContent);

            // Determine the mime type based on file extension
            $extension = pathinfo($user->qr_image, PATHINFO_EXTENSION);
            $mimeType = $extension === 'svg' ? 'image/svg+xml' : 'image/png';

            // Create data URI with base64 encoded image
            $qrDataUri = 'data:' . $mimeType . ';base64,' . $qrBase64;

            // QR Image Tag with base64 data URI - using correct position from template
            $qrImageTag = '<image id="Image_x0020_replace_x0020_here" xlink:href="' . $qrDataUri . '"
                          x="3573.27"
    y="5852.26"
    width="3025.31"
    height="3011.16"  />';
        } else {
            // If QR image doesn't exist, create an empty placeholder
            $qrImageTag = '<image id="Image_x0020_replace_x0020_here" x="3423.27" y="5702.26" width="3325.31" height="3311.16" xlink:href="" />';
        }

        // Replace the image placeholder with QR code
        $svgContent = preg_replace(
            '/<image id="Image_x0020_replace_x0020_here"[^>]*\/>/s',
            $qrImageTag,
            $svgContent
        );

        return response($svgContent)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="id-card-' . $user->id . '.svg"');
    }

}

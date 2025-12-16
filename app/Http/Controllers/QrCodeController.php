<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;

class QrCodeController extends Controller
{
    public function index()
    {
        $qrCodes = QrCode::orderBy('id', 'desc')->paginate(20);
        return view('admin.qr-codes.index', compact('qrCodes'));
    }

    public function create()
    {
        return view('admin.qr-codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10000',
        ]);

        $quantity = $request->quantity;

        // Get the last QR code number to continue from there
        $lastQrCode = QrCode::orderBy('id', 'desc')->first();
        $startNumber = $lastQrCode ? intval(str_replace('NAREDCO-', '', $lastQrCode->qr_code_no)) + 1 : 1;

        $folder = public_path('Qr_images');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        for ($i = 0; $i < $quantity; $i++) {
            $number = $startNumber + $i;
            $qrCodeNo = 'NAREDCO-' . str_pad($number, 5, '0', STR_PAD_LEFT);

            // Generate QR code with the code number as content
            $svgQr = QrCodeFacade::format('svg')->size(300)->generate($qrCodeNo);
            $fileName = 'qr_' . $qrCodeNo . '.svg';
            file_put_contents($folder . '/' . $fileName, $svgQr);

            QrCode::create([
                'qr_code_no' => $qrCodeNo,
                'qr_code_image' => $fileName,
            ]);
        }

        return redirect()->route('qr-codes.index')->with('success', $quantity . ' QR codes generated successfully.');
    }

    public function show($id)
    {
        $qrCode = QrCode::findOrFail($id);
        return view('admin.qr-codes.show', compact('qrCode'));
    }

    public function destroy($id)
    {
        $qrCode = QrCode::findOrFail($id);

        // Delete the image file
        $imagePath = public_path('Qr_images/' . $qrCode->qr_code_image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $qrCode->delete();

        return redirect()->route('qr-codes.index')->with('success', 'QR code deleted successfully.');
    }
}

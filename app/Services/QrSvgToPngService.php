<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

class QrSvgToPngService
{
    /**
     * Generate PNG version of QR code for WhatsApp delivery
     * Uses endroid/qr-code library with pure GD backend (no external dependencies)
     */
    public static function convert(string $svgPath, string $qrPayload): string
    {
        Log::info('QrSvgToPngService: Starting PNG generation using Endroid QR', [
            'svg_path' => $svgPath,
            'qr_payload_length' => strlen($qrPayload)
        ]);

        $pngDir = public_path('qr_images_png');

        if (!file_exists($pngDir)) {
            mkdir($pngDir, 0777, true);
            Log::info('QrSvgToPngService: Created PNG directory', ['png_dir' => $pngDir]);
        }

        $pngFileName = pathinfo($svgPath, PATHINFO_FILENAME) . '.png';
        $pngPath = $pngDir . '/' . $pngFileName;

        Log::info('QrSvgToPngService: Target PNG path determined', [
            'png_path' => $pngPath,
            'png_exists' => file_exists($pngPath)
        ]);

        // PNG already exists → reuse (no regeneration needed)
        if (file_exists($pngPath)) {
            Log::info('QrSvgToPngService: PNG already exists, reusing cached version', [
                'png_path' => $pngPath,
                'file_size' => filesize($pngPath)
            ]);
            return $pngPath;
        }

        Log::info('QrSvgToPngService: Generating fresh PNG from QR payload using Endroid GD backend', [
            'qr_payload_preview' => substr($qrPayload, 0, 50) . '...'
        ]);

        // 🔥 REGENERATE QR as PNG using Endroid with GD backend (no Imagick dependency)
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrPayload)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(400)
            ->margin(1)
            ->build();

        $result->saveToFile($pngPath);

        Log::info('QrSvgToPngService: PNG generation completed successfully', [
            'png_path' => $pngPath,
            'file_size' => filesize($pngPath),
            'method' => 'regenerated_from_payload_endroid_gd'
        ]);

        return $pngPath;
    }
}

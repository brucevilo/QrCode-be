<?php

namespace App\Http\Controllers;

use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

class QrController extends Controller
{
    public function show($userId)
    {
        $user = User::findOrFail($userId);
        $attachmentData = $user->attachments;

        $qrCodeDataUri = null;

        foreach ($attachmentData as $attachment) {
            if ($attachment->type === 'qrcode') {
                $qrCode = QrCode::format('svg')->size(200)->generate($attachment->url);
                $qrCodeDataUri = 'data:image/svg+xml;base64,' . base64_encode($qrCode);
            }
        }


        return Response::json([
            'qrCodeDataUri' => $qrCodeDataUri,
        ]);


    }
}

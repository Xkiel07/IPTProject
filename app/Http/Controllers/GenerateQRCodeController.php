<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\patientrecord;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQRCodeController extends Controller
{
    public function GenerateQRCode(Request $request){
        $request->validate([
            'Info' => 'string|required'
        ]);
        $Patient = patientrecord::where('PatientID', $request->input('Info'))->first();
        $Stamp_Token = $Patient->Stamp_Token;
        $EncryptedStamp_Token = Crypt::encrypt($Stamp_Token);
        $url = route('Admin.patientFullView', ['Stamp_Token' => urlencode($EncryptedStamp_Token)]);
        $PatientQRCode = base64_encode(QrCode::format('svg')->size(170)->generate($url));
        session(['PatientQRCode' => $PatientQRCode,
                'EncryptedStamp_Token' => $EncryptedStamp_Token]);
        return redirect()->route('View.QrCode');
    }
}

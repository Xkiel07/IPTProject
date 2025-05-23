<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\patientrecord;
use App\Models\patientmedicallog;
use App\Models\ConsultationListModel;
use Illuminate\Support\Facades\Crypt;

use function PHPUnit\Framework\returnSelf;

class SaveBtnController extends Controller
{
        public function SaveBtn(Request $request)
        { 
                $SaveMedicalInfo = $request->validate([
                    'PatientNumber' => 'required|string',
                    'Consultation' => 'required|string',
                    'Remarks' => 'nullable|string',
                    'DateOfConsultation' => 'date',
                    'DateOfUpload' => 'required|date',
                    'Files.*' => 'nullable|image'
                ]);
                if (empty($SaveMedicalInfo['DateOfConsultation'])) {
                   return redirect()->back();
                }

                $filePaths = [];

                if ($request->hasFile('Files')) {
                    foreach ($request->file('Files') as $file) {
                        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('uploads', $fileName, 'public');
                        $filePaths[] = $path;
                    }
                }

                
                if (!empty($filePaths)) {
                    $SaveMedicalInfo['Files'] = json_encode($filePaths);
                } else {
                    $SaveMedicalInfo['Files'] = null;
                }
                
                patientmedicallog::create($SaveMedicalInfo);

                $PatientID = $request->input('PatientNumber');   
                $PatientInfo = patientrecord::where('PatientID', $PatientID)->first();
                $Stamp_Token = $PatientInfo->Stamp_Token;
                $EncryptedStampToken = Crypt::encrypt($Stamp_Token);
                $url = route('Admin.patientFullView', ['Stamp_Token' => urlencode($EncryptedStampToken)]);
                return redirect($url)
                    ->with('success', 'File uploading success.');
        }
        
                
}

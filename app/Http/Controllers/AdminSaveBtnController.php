<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\patientrecord;

class AdminSaveBtnController extends Controller
{
    public function AdminSaveBtn(Request $request)
    {
        $validatedPatientInfo = $request->validate([
            'PatientID' => 'required|string|max:255|unique:patientrecord,PatientID',
            'LastName' => 'required|string|max:255',
            'FirstName' => 'required|string|max:255',
            'MiddleName' => 'required|string|max:255',
            'Birthdate' => 'required|date|before:today',
            'Age' => 'required|integer|min:0',
            'Gender' => 'required|string',
            'HouseNumber' => 'required|string|max:255',
            'Street' => 'required|string|max:255',
            'Barangay' => 'required|string|max:255',
            'Municipality' => 'required|string|max:255',
            'Province' => 'required|string|max:255',
            'ContactNumber' => 'required|string|size:13|regex:/^\+?[0-9]+$/',
            'email' => 'nullable|email|unique:patientrecord,email',
            'PhilhealthNumber' => 'nullable|string|unique:patientrecord,PhilhealthNumber',
        ]);

        // Remove '+63' prefix if it exists
        if (Str::startsWith($validatedPatientInfo['ContactNumber'], '+63')) {
            $validatedPatientInfo['ContactNumber'] = substr($validatedPatientInfo['ContactNumber'], 3);
        }

        // Generate Stamp_Token
        $validatedPatientInfo['Stamp_Token'] = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 10);

        // Save record
        patientrecord::create($validatedPatientInfo);

        return redirect()->route('Admin.New')->with('Update', 'Adding New Patient Record Success!');
    }
}

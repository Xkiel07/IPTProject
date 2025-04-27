<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AccountsModel;
use Illuminate\Support\Facades\Hash;

class AdminCreateAccountBtnController extends Controller
{
    public function createAccountBtn(Request $request)
    {
        // Validation
        $AccountDetails = $request->validate([
            'LastName' => 'required|string',
            'FirstName' => 'required|string',
            'MiddleName' => 'required|string',
            'Birthdate' => 'required|date',
            'Age' => 'required|integer',
            'Gender' => 'required|string',
            'HouseNumber' => 'required|string',
            'Street' => 'required|string',
            'Barangay' => 'required|string',
            'Municipality' => 'required|string',
            'Province' => 'required|string',
            'email' => 'required|email|unique:accounts,email',
            'ContactNumber' => 'required|string|size:13|regex:/^\+?[0-9]+$/',
            'username' => 'required|string|unique:accounts,username',
            'password' => 'required|string|min:8|regex:/[0-9]/|regex:/[@$!%*?&#]/|regex:/[A-Z]/',       
            'profile_picture' => 'nullable|image|max:4096',
        ]);
       
        if (Str::startsWith($AccountDetails['ContactNumber'], '+63')) {
            $AccountDetails['ContactNumber'] = substr($AccountDetails['ContactNumber'], 3);
        } 
      
        // Handle image upload   
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_picture', 'public');
            $AccountDetails['profile_picture'] = $path;
        }
        
        $AccountDetails['Status'] = 'Active';
        $AccountDetails['Position'] = 'Staff';
        $AccountDetails['ActivityStatus'] = 'Offline';
        AccountsModel::create($AccountDetails);

         
        return redirect()->route('Admin.Create')->with('Create',' Creating a new account successfully!');

    }
}

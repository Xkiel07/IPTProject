<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccountsModel;


class AccountListFetchController extends Controller
{
    public function FetchAllAccountsData(){
        // for getting all active accounts
        $AllActiveAccounts = AccountsModel::where('Position', 'Staff')
        ->where('Status', 'Active')
        ->orderBy('id')
        ->get();

        // for checking if the account it inactive for 30 mins
        foreach ($AllActiveAccounts as $AccountsStats) {
        $lastActivity = Carbon::parse($AccountsStats->LastActivity);

        // for changing the status of account if inactive
        if ($lastActivity->diffInMinutes(Carbon::now()) > 30) {
        $AccountsStats->ActivityStatus = 'Offline';
        $AccountsStats->save();
        } 

        }

        // for getting all deactivated accounts
        $AllDeactivedAccounts = AccountsModel::where('Position', 'Staff')
            ->where('Status', 'Deactivated')
            ->get();

        // for displaying if there is no active or deactivated accounts 
        if ($AllActiveAccounts->isEmpty() && $AllDeactivedAccounts->isEmpty()) { 
        return view('AdminPages.AccountList', compact('AllActiveAccounts', 'AllDeactivedAccounts'))
            ->with(['NoAccount' => 'No Accounts']); 
        }

        return response()->json(['ActiveAccounts' => $AllActiveAccounts,
                                'DeactivatedAccounts' => $AllDeactivedAccounts]);
    }
}

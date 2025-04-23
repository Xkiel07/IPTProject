<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccountsModel;

class AccountListFetchController extends Controller
{
    public function FetchAllAccountsData()
    {
        // Get all active staff accounts
        $AllActiveAccounts = AccountsModel::where('Position', 'Staff')
            ->where('Status', 'Active')
            ->orderBy('id')
            ->get();

        // Check activity and update status if inactive for more than 30 minutes
        foreach ($AllActiveAccounts as $AccountsStats) {
            $lastActivity = Carbon::parse($AccountsStats->LastActivity);

            if ($lastActivity->diffInMinutes(Carbon::now()) > 30) {
                $AccountsStats->ActivityStatus = 'Offline';
                $AccountsStats->save();
            }
        }

        // Get all deactivated staff accounts
        $AllDeactivedAccounts = AccountsModel::where('Position', 'Staff')
            ->where('Status', 'Deactivated')
            ->get();

        // Return a message if no accounts found
        if ($AllActiveAccounts->isEmpty() && $AllDeactivedAccounts->isEmpty()) {
            return response()->json(['message' => 'No Accounts Found']);
        }

        // Return both active and deactivated accounts
        return response()->json([
            'ActiveAccounts' => $AllActiveAccounts,
            'DeactivatedAccounts' => $AllDeactivedAccounts
        ]);
    }
}

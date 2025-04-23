<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TotalPatientThisMonth
{
    public function CurrentMonthTotalPatient()
    {
        $TotalNumberOfPatients = DB::table('patientmedicallog')
            ->select(DB::raw('count(distinct "patientmedicallog"."PatientNumber") as "NumPatient"'))
            ->whereYear('DateOfConsultation', date('Y'))
            ->whereMonth('DateOfConsultation', date('m'))
            ->first();

        return $TotalNumberOfPatients->NumPatient;
    }
}

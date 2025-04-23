<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PieChart
{
    public function PieChart(){
        $PieChart = DB::table('patientmedicallog')
            ->select('Consultation', DB::raw('count(distinct "PatientNumber") as NumPatient')) // Added quotes around PatientNumber
            ->whereYear('DateOfConsultation', date('Y'))
            ->whereMonth('DateOfConsultation', date('m'))
            ->groupBy('Consultation')
            ->get();
        
        return $PieChart;
    }
}

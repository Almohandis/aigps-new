<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    protected $cities = ['6th of October', 'Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];

    protected $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

    protected $report_name = [
        '',
        'Blood type distribution',
        'Survey results and answers',
        'Recoveries report',
        'Deaths report',
        'User vaccinating status',
        'User vaccinating status (summary)',
        'Distribution of hospitals',
        'Infections and their relatives',
        'Distribution of chronic diseases',
        'Distribution of doctors in hospitals',
        'Distribution of doctors in campaigns',
        'Hospitalization status',
        'Hospital statistics',
        'Hospital statistics (summary)',
        'Campaign report (summary)',
        'General statistics',
        'Vaccine report',
        'Personal medical report'
    ];

    protected  $report_by = [
        '',
        ['City', 'Blood type', 'Age segment'],
        ['City', 'Question', 'Age segment'],
        ['City', 'Hospital', 'Date', 'Age segment'],
        ['City', 'Hospital', 'Date', 'Age segment'],
        ['City', 'Vaccine status', 'Age segment'],
        ['Default'],
        ['City', 'Hospital'],
        ['City', 'Vaccine status', 'Date', 'Age segment'],
        ['Chronic disease', 'Age segment'],
        ['City', 'Hospital'],
        ['City'],
        ['City', 'Hospital', 'Date', 'Age segment'],
        ['City', 'Hospital', 'Date'],
        ['Default'],
        ['Default'],
        ['Default'],
        ['Default'],
        ['Default'],
    ];


    public function getReportDetails($ids)
    {
        $report_names = [];
        $report_by = [];
        foreach ($ids as $ids) {
            $report_names[] = $this->report_name[$ids];
            $report_by[] = $this->report_by[$ids];
        }
        return [$report_names, $report_by];
    }

    public function getUserAllowedReports($role_id)
    {
        $names = [];
        $report_by = [];
        switch ($role_id) {
            case 1:
                [$names, $report_by] = $this->getReportDetails(range(1, 18));
                break;
            case 2:
                [$names, $report_by] = $this->getReportDetails([6, 16, 17, 18]);
                break;
            case 3:
                [$names, $report_by] = $this->getReportDetails([6, 16, 17, 18]);
                break;
            case 4:
                [$names, $report_by] = $this->getReportDetails([6, 11, 15, 16, 17, 18]);
                break;
            case 5:
                [$names, $report_by] = $this->getReportDetails([1, 2, 3, 4, 5, 6, 8, 9, 11, 15, 16, 17, 18]);
                break;
            case 6:
                [$names, $report_by] = $this->getReportDetails([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 16, 17, 18]);
                break;
            case 7:
                [$names, $report_by] = $this->getReportDetails(range(1, 18));
                break;
            case 8:
                [$names, $report_by] = $this->getReportDetails(range(1, 18));
                break;
            case 9:
                [$names, $report_by] = $this->getReportDetails(range(1, 18));
                break;
        }
        return [$names, $report_by];
    }

    // function named bloodTypeDistribution that takes a report_by, make a switch statment and return the correct query
    public function bloodTypeDistribution($report_by)
    {
        switch ($report_by) {
            case 'City':
                $A_plus = DB::table('users')
                    ->select('city', DB::raw('count(*) as "A_plus"'))
                    ->where('blood_type', '=', 'A+')
                    ->groupBy('city')
                    ->orderBy('city', 'asc')
                    ->get();
                $A_minus = DB::table('users')
                    ->select('city', DB::raw('count(*) as "A_minus"'))
                    ->where('blood_type', '=', 'A-')
                    ->groupBy('city')
                    ->orderBy('city', 'asc')
                    ->get();
                $B_plus = DB::table('users')
                    ->select('city', DB::raw('count(*) as "B_plus"'))
                    ->where('blood_type', '=', 'B+')
                    ->groupBy('city')
                    ->orderBy('city', 'asc')
                    ->get();
                $B_minus = DB::table('users')
                    ->select('city', DB::raw('count(*) as "B_minus"'))
                    ->where('blood_type', '=', 'B-')
                    ->groupBy('city')
                    ->orderBy('city', 'asc')
                    ->get();
                $AB_plus = DB::table('users')
                    ->select('city', DB::raw('count(*) as "AB_plus"'))
                    ->where('blood_type', '=', 'AB+')
                    ->groupBy('city')
                    ->orderBy('city', 'asc')
                    ->get();
                $AB_minus = DB::table('users')
                    ->select('city', DB::raw('count(*) as "AB_minus"'))
                    ->where('blood_type', '=', 'AB-')
                    ->groupBy('city')
                    ->orderBy('city', 'asc')
                    ->get();
                $O_plus = DB::table('users')
                    ->select('city', DB::raw('count(*) as "O_plus"'))
                    ->where('blood_type', '=', 'O+')
                    ->groupBy('city')
                    ->orderBy('city', 'asc')
                    ->get();
                $O_minus = DB::table('users')
                    ->select('city', DB::raw('count(*) as "O_minus"'))
                    ->where('blood_type', '=', 'O-')
                    ->groupBy('city')
                    ->orderBy('city', 'asc')
                    ->get();

                return [$A_plus, $A_minus, $B_plus,  $B_minus, $AB_plus,  $AB_minus,  $O_plus, $O_minus];

                break;
            case 'Blood type':
                return DB::table('users')
                    ->select('blood_type', DB::raw('count(*) as count'))
                    ->groupBy('blood_type')
                    ->orderBy('count', 'desc')
                    ->get();
                break;
            case 'Age segment':
                return DB::table('users')
                    ->select('age_segment', DB::raw('count(*) as count'))
                    ->groupBy('age_segment')
                    ->orderBy('count', 'desc')
                    ->get();
                break;
            default:
                return null;
        }
    }

    public function generateReports($report_name, $report_by, $names)
    {
        switch ($report_name) {
            case 'Blood type distribution':
                $data = $this->bloodTypeDistribution($report_by);

                $data = json_encode($data, true);
                $data = json_decode($data, true);
                return view('statistics.blood-type-dist', ['data' => (array)$data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities, 'blood_types' => $this->blood_types]);
                break;
            case 'Survey results and answers':
                return $this->surveyResultsAndAnswers($report_by);
                break;
            case 'Recoveries report':
                return $this->recoveriesReport($report_by);
                break;
            case 'Deaths report':
                return $this->deathsReport($report_by);
                break;
            case 'User vaccinating status':
                return $this->userVaccinatingStatus($report_by);
                break;
            case 'User vaccinating status (summary)':
                return $this->userVaccinatingStatusSummary($report_by);
                break;
            case 'Distribution of hospitals':
                return $this->distributionOfHospitals($report_by);
                break;
            case 'Infections and their relatives':
                return $this->infectionsAndTheirRelatives($report_by);
                break;
            case 'Distribution of chronic diseases':
                return $this->distributionOfChronicDiseases($report_by);
                break;
            case 'Distribution of doctors in hospitals':
                return $this->distributionOfDoctorsInHospitals($report_by);
                break;
            case 'Distribution of doctors in campaigns':
                return $this->distributionOfDoctorsInCampaigns($report_by);
                break;
            case 'Hospitalization status':
                return $this->hospitalizationStatus($report_by);
                break;
            case 'Hospital statistics':
                return $this->hospitalStatistics($report_by);
                break;
            case 'Hospital statistics (summary)':
                return $this->hospitalStatisticsSummary($report_by);
                break;
            case 'Campaign report (summary)':
                return $this->campaignReportSummary($report_by);
                break;
            case 'General statistics':
                return $this->generalStatistics($report_by);
                break;
            case 'Vaccine report':
                return $this->vaccineReport($report_by);
                break;
            case 'Personal medical report':
                return $this->personalMedicalReport($report_by);
                break;
        }
    }

    public function index(Request $request)
    {
        [$names, $report_by] = $this->getUserAllowedReports($request->user()->role_id);
        return view('statistics.statistics', [
            'names' => $names,
            'report_by' => $report_by
        ]);
    }

    public function getReport(Request $request)
    {
        // return $request->all();
        if (!$request->report_name || !$request->report_by) {
            return redirect()->back()->with('message', 'Please select a report type');
        }
        [$names, $report_by] = $this->getUserAllowedReports($request->user()->role_id);
        if (!in_array($request->report_name, $names)) {
            return redirect()->back()->with('message', 'You are not allowed to generate this report');
        }

        return $this->generateReports($request->report_name, $request->report_by, $names);
    }
}

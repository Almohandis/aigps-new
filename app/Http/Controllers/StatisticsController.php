<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    protected $cities = ['6th of October', 'Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];

    protected $blood_types = ['A_plus', 'A_minus', 'B_plus', 'B_minus', 'AB_plus', 'AB_minus', 'O_plus', 'O_minus'];

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
        [/*'City', */'Question'/*, 'Age segment'*/],
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

    // Take report_by and names, make a switch statment and return the correct query
    public function bloodTypeDistribution($report_by, $names)
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
                $data = [$A_plus, $A_minus, $B_plus,  $B_minus, $AB_plus,  $AB_minus,  $O_plus, $O_minus];
                $data = json_encode($data, true);
                $data = json_decode($data, true);
                return view('statistics.blood-type-dist', ['data_by_city' => (array)$data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities, 'blood_types' => $this->blood_types]);
                break;
            case 'Blood type':
                $data = DB::select('SELECT u1.blood_type AS "Blood type",
                        (SELECT COUNT(*) FROM users AS u5 WHERE u5.blood_type=u1.blood_type) AS "Total persons from this type",
                        ROUND( COUNT(*)/(SELECT COUNT(*) FROM users AS u4 WHERE u4.blood_type IS NOT NULL)*100,1) as "Percentage of this type",
                        ROUND(
                        (SELECT COUNT(*) FROM users AS u2 WHERE u2.blood_type=u1.blood_type AND  gender="Male" )/
                        (SELECT COUNT(*) FROM users AS u3 WHERE u3.blood_type=u1.blood_type AND  gender IS NOT NULL)*100,1)
                        as "Male percentage",
                        ROUND(
                        (SELECT COUNT(*) FROM users AS u2 WHERE u2.blood_type=u1.blood_type AND  gender="Female" )/
                        (SELECT COUNT(*) FROM users AS u3 WHERE u3.blood_type=u1.blood_type AND  gender IS NOT NULL)*100,1)
                        as "Female percentage"
                        FROM users AS u1 GROUP BY u1.blood_type;
                        ');
                $data = json_encode($data);
                $data = json_decode($data);
                return view('statistics.blood-type-dist', ['data_by_blood' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
            case 'Age segment':
                $A_plus = DB::select('SELECT IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=20,"Children",
                                    IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=40,"Youth", "Elder") )  AS age,  COUNT(*) AS A_plus
                                    FROM `users`
                                    WHERE `blood_type`="A+" GROUP BY age;');
                $A_minus = DB::select('SELECT IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=20,"Children",
                                    IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=40,"Youth", "Elder") )  AS age, COUNT(*) AS A_minus
                                    FROM `users`
                                    WHERE `blood_type`="A-" GROUP BY age;');
                $B_plus = DB::select('SELECT IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=20,"Children",
                                    IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=40,"Youth", "Elder") )  AS age, COUNT(*) AS B_plus
                                    FROM `users`
                                    WHERE `blood_type`="B+" GROUP BY age;');
                $B_minus = DB::select('SELECT IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=20,"Children",
                                    IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=40,"Youth", "Elder") )  AS age, COUNT(*) AS B_minus
                                    FROM `users`
                                    WHERE `blood_type`="B-" GROUP BY age;');
                $AB_plus = DB::select('SELECT IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=20,"Children",
                                    IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=40,"Youth", "Elder") )  AS age, COUNT(*) AS AB_plus
                                    FROM `users`
                                    WHERE `blood_type`="AB+" GROUP BY age;');
                $AB_minus = DB::select('SELECT IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=20,"Children",
                                    IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=40,"Youth", "Elder") )  AS age, COUNT(*) AS AB_minus
                                    FROM `users`
                                    WHERE `blood_type`="AB-" GROUP BY age;');
                $O_plus = DB::select('SELECT IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=20,"Children",
                                    IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=40,"Youth", "Elder") )  AS age, COUNT(*) AS O_plus
                                    FROM `users`
                                    WHERE `blood_type`="O+" GROUP BY age;');
                $O_minus = DB::select('SELECT IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=20,"Children",
                                    IF(TIMESTAMPDIFF(YEAR,`birthdate`, now())<=40,"Youth", "Elder") )  AS age, COUNT(*) AS O_minus
                                    FROM `users`
                                    WHERE `blood_type`="O-" GROUP BY age;');

                $data = [$A_plus, $A_minus, $B_plus,  $B_minus, $AB_plus,  $AB_minus,  $O_plus, $O_minus];
                $data = json_encode($data, true);
                $data = json_decode($data, true);
                return view('statistics.blood-type-dist', ['data_by_age' => (array)$data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities, 'blood_types' => $this->blood_types]);
                break;
            default:
                return null;
        }
    }

    public function surveyResultsAndAnswers($report_by, $names)
    {
        switch ($report_by) {
            case 'City':
                break;
            case 'Question':
                $data = DB::select('SELECT title as "title",
                (SELECT COUNT(*) FROM question_user WHERE questions.id=question_user.question_id AND answer="No") AS "no",
                (SELECT COUNT(*) FROM question_user WHERE questions.id=question_user.question_id AND answer="Yes") AS "yes"
                FROM questions, question_user, users WHERE
                users.id=question_user.user_id AND questions.id=question_user.id;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.survey-results', ['data_by_question' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
            case 'Age segment':
                break;
            default:
                return null;
        }
    }

    public function recoveriesReport($report_by, $names)
    {
        switch ($report_by) {
            case 'City':
                $data = DB::select('SELECT DISTINCT u1.city,
                (SELECT COUNT(*) FROM users AS u2, infections AS inf1 WHERE u2.id=inf1.user_id AND u1.city=u2.city AND inf1.is_recovered=1) AS "total_recoveries",
                (SELECT COUNT(*) FROM hospitals WHERE hospitals.city=u1.city) AS "total_hospitals",
                (SELECT ROUND(AVG( hos2.capacity - (SELECT COUNT(*) FROM hospitals AS hos3, hospitalizations AS hoz2 WHERE hos3.id=hoz2.id AND hoz2.checkout_date IS NOT null ))) FROM hospitals AS hos2 WHERE hos2.city=u1.city) AS "average_available_beds"
                FROM users AS u1, hospitals AS hos1, hospitalizations AS hoz1
                WHERE hos1.id=hoz1.hospital_id
                AND u1.id=hoz1.user_id
                AND hos1.city=u1.city
                AND hoz1.checkout_date IS NULL ORDER BY u1.city;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.recoveries-report', ['data_by_city' => $data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities]);
                break;
            case 'Hospital':
                break;
            case 'Date':
                break;
            case 'Age segment':
                break;
            default:
                return null;
        }
    }

    public function generateReports($report_name, $report_by, $names)
    {
        switch ($report_name) {
            case 'Blood type distribution':
                return $this->bloodTypeDistribution($report_by, $names);
                break;
            case 'Survey results and answers':
                return $this->surveyResultsAndAnswers($report_by, $names);
                break;
            case 'Recoveries report':
                return $this->recoveriesReport($report_by, $names);
                break;
            case 'Deaths report':
                return $this->deathsReport($report_by, $names);
                break;
            case 'User vaccinating status':
                return $this->userVaccinatingStatus($report_by, $names);
                break;
            case 'User vaccinating status (summary)':
                return $this->userVaccinatingStatusSummary($report_by, $names);
                break;
            case 'Distribution of hospitals':
                return $this->distributionOfHospitals($report_by, $names);
                break;
            case 'Infections and their relatives':
                return $this->infectionsAndTheirRelatives($report_by, $names);
                break;
            case 'Distribution of chronic diseases':
                return $this->distributionOfChronicDiseases($report_by, $names);
                break;
            case 'Distribution of doctors in hospitals':
                return $this->distributionOfDoctorsInHospitals($report_by, $names);
                break;
            case 'Distribution of doctors in campaigns':
                return $this->distributionOfDoctorsInCampaigns($report_by, $names);
                break;
            case 'Hospitalization status':
                return $this->hospitalizationStatus($report_by, $names);
                break;
            case 'Hospital statistics':
                return $this->hospitalStatistics($report_by, $names);
                break;
            case 'Hospital statistics (summary)':
                return $this->hospitalStatisticsSummary($report_by, $names);
                break;
            case 'Campaign report (summary)':
                return $this->campaignReportSummary($report_by, $names);
                break;
            case 'General statistics':
                return $this->generalStatistics($report_by, $names);
                break;
            case 'Vaccine report':
                return $this->vaccineReport($report_by, $names);
                break;
            case 'Personal medical report':
                return $this->personalMedicalReport($report_by, $names);
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

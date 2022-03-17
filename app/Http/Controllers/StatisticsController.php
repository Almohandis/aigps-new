<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\json;

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
        'Infections report',
        'Distribution of chronic diseases',
        'Distribution of doctors in hospitals',
        // 'Distribution of doctors in campaigns (removed)',
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
        [/*'City',*/'Vaccine status'/*, 'Age segment'*/],
        ['Default'],
        ['City', 'Hospital'],
        ['City', 'Vaccine status', 'Date', 'Age segment'],
        ['Chronic disease'/*, 'Age segment'*/],
        ['City', 'Hospital'],
        // ['City'],
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
                [$names, $report_by] = $this->getReportDetails(range(1, 17));
                break;
            case 2:
                [$names, $report_by] = $this->getReportDetails([6, 15, 16, 17]);
                break;
            case 3:
                [$names, $report_by] = $this->getReportDetails([6, 15, 16, 17]);
                break;
            case 4:
                [$names, $report_by] = $this->getReportDetails([6, 14, 15, 16, 17]);
                break;
            case 5:
                [$names, $report_by] = $this->getReportDetails([1, 2, 3, 4, 5, 6, 8, 9, 14, 15, 16, 17]);
                break;
            case 6:
                [$names, $report_by] = $this->getReportDetails([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17]);
                break;
            case 7:
                [$names, $report_by] = $this->getReportDetails(range(1, 17));
                break;
            case 8:
                [$names, $report_by] = $this->getReportDetails(range(1, 17));
                break;
            case 9:
                [$names, $report_by] = $this->getReportDetails(range(1, 17));
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
                // return $data;
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
                $data = DB::select('SELECT title,
                (SELECT COUNT(*) FROM question_user WHERE questions.id=question_user.question_id AND answer="No") AS "no",
                (SELECT COUNT(*) FROM question_user WHERE questions.id=question_user.question_id AND answer="Yes") AS "yes"
                FROM questions, question_user, users WHERE
                users.id=question_user.user_id AND questions.id=question_user.question_id;');
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
                $data = DB::select('SELECT u1.city, ( SELECT COUNT(*) FROM recoveries_id, users AS u2 WHERE u2.id = recoveries_id.id AND u2.city = u1.city ) as total_rec, ( SELECT COUNT(*) FROM recoveries_id, users AS u2 WHERE u2.gender = "Male" AND recoveries_id.id = u2.id AND u1.city = u2.city ) AS male_count, Round( ifnull( ( SELECT male_count / total_rec * 100 ), 0 ), 1 ) as male_pcnt, ( SELECT COUNT(*) FROM recoveries_id, users AS u2 WHERE u2.gender = "Female" AND recoveries_id.id = u2.id AND u1.city = u2.city ) AS female_count, Round( ifnull( ( SELECT female_count / total_rec * 100 ), 0 ), 1 ) as female_pcnt, ( SELECT COUNT(*) FROM hospitals AS hos1 WHERE hos1.city = u1.city ) AS tot_hos, ( SELECT ifnull( round( ( ( ( SELECT sum(hos3.capacity) FROM hospitals as hos3 where hos3.city = u1.city ) - ( SELECT COUNT(*) FROM hospitalizations AS hoz2, hospitals as hos2 WHERE hoz2.hospital_id = hos2.id AND hoz2.checkout_date IS NULL and hos2.city = u1.city ) )/ ( SELECT count(*) FROM hospitals as hos3 where hos3.city = u1.city ) ), 0 ), 0 ) ) AS avg_avail_beds FROM users AS u1 GROUP BY u1.city ORDER BY u1.city;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.recoveries-report', ['data_by_city' => $data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities]);
                break;
            case 'Hospital':
                $data = DB::select('SELECT hos1.name, hos1.city,
                (SELECT COUNT(*) FROM infections AS inf1 WHERE inf1.hospital_id=hos1.id AND inf1.is_recovered=1 ) AS "total_recoveries",
                (SELECT hos1.capacity - (SELECT COUNT(*) FROM hospitals AS hos2, users AS u1, hospitalizations AS hoz1
                WHERE hos2.id=hoz1.hospital_id AND u1.id=hoz1.user_id AND hos2.id=hos1.id AND hoz1.checkout_date IS NULL ) ) AS "avail_beds"
                FROM hospitals AS hos1;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.recoveries-report', ['data_by_hospital' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
            case 'Date':
                $data = DB::select('SELECT infection_date, COUNT(*) AS "total_rec"
                FROM infections AS inf1
                WHERE inf1.infection_date BETWEEN DATE_ADD(CURDATE(),INTERVAL -DAY(CURDATE())+1 DAY) AND CURDATE() AND is_recovered=1
                GROUP BY infection_date ORDER BY infection_date DESC;');
                $data = json_encode($data);
                $data = json_decode($data);
                $date = date('F, Y');
                // return $data;
                return view('statistics.recoveries-report', ['data_by_date' => $data, 'names' => $names, 'report_by' => $report_by, 'date' => $date]);
                break;
            case 'Age segment':
                $data = DB::select('SELECT DISTINCT IF(TIMESTAMPDIFF(YEAR,u1.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u1.birthdate, now())<=40,"Youth", "Elder")) AS Age,

                (SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.is_recovered=1 AND
                IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age)  ) AS Total,

                (SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.is_recovered=1 AND u2.gender="Male" AND
                IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age)  ) AS Male,

                ROUND((SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.is_recovered=1 AND u2.gender="Male" AND
                IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age))/(SELECT Total)*100,2) AS "male_pcnt",

                (SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.is_recovered=1 AND u2.gender="Female" AND
                IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age)  ) AS Female,

                ROUND((SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.is_recovered=1 AND u2.gender="Female" AND
                IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age))/(SELECT Total)*100,2) AS "female_pcnt"

                FROM infections AS inf1, users AS u1

                WHERE inf1.is_recovered=1 ORDER BY Age;');
                $data = json_decode(json_encode($data));
                // return $data;
                return view('statistics.recoveries-report', [
                    'data_by_age' => $data,
                    'names' => $names,
                    'report_by' => $report_by
                ]);
                break;
            default:
                return null;
        }
    }

    public function deathsReport($report_by, $names)
    {
        switch ($report_by) {
            case 'City':
                $data = DB::select('SELECT u1.city, ( SELECT COUNT(*) FROM deaths_id, users AS u2 WHERE u2.id = deaths_id.id AND u2.city = u1.city ) as total_deaths, ( SELECT COUNT(*) FROM deaths_id, users AS u2 WHERE u2.gender = "Male" AND deaths_id.id = u2.id AND u1.city = u2.city ) AS male_count, Round( ifnull( ( SELECT male_count / total_deaths * 100 ), 0 ), 1 ) as male_pcnt, ( SELECT COUNT(*) FROM deaths_id, users AS u2 WHERE u2.gender = "Female" AND deaths_id.id = u2.id AND u1.city = u2.city ) AS female_count, Round( ifnull( ( SELECT female_count / total_deaths * 100 ), 0 ), 1 ) as female_pcnt, ( SELECT COUNT(*) FROM hospitals AS hos1 WHERE hos1.city = u1.city ) AS tot_hos, ( SELECT ifnull( round( ( ( ( SELECT sum(hos3.capacity) FROM hospitals as hos3 where hos3.city = u1.city ) - ( SELECT COUNT(*) FROM hospitalizations AS hoz2, hospitals as hos2 WHERE hoz2.hospital_id = hos2.id AND hoz2.checkout_date IS NULL and hos2.city = u1.city ) )/ ( SELECT count(*) FROM hospitals as hos3 where hos3.city = u1.city ) ), 0 ), 0 ) ) AS avg_avail_beds FROM users AS u1 GROUP BY u1.city ORDER BY u1.city;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.deaths-report', ['data_by_city' => $data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities]);
                break;
            case 'Hospital':
                $data = DB::select('SELECT hos1.name, hos1.city, (SELECT COUNT(*) FROM infections AS inf1 WHERE inf1.hospital_id=hos1.id AND inf1.has_passed_away=1 ) AS total_deaths, (SELECT hos1.capacity - (SELECT COUNT(*) FROM hospitals AS hos2, users AS u1, hospitalizations AS hoz1 WHERE hos2.id=hoz1.hospital_id AND u1.id=hoz1.user_id AND hos2.id=hos1.id AND hoz1.checkout_date IS NULL ) ) AS "avail_beds" FROM hospitals AS hos1;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.deaths-report', ['data_by_hospital' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
            case 'Date':
                $data = DB::select('SELECT infection_date, COUNT(*) AS total_deaths FROM infections AS inf1 WHERE inf1.infection_date BETWEEN DATE_ADD(CURDATE(),INTERVAL -DAY(CURDATE())+1 DAY) AND CURDATE() AND has_passed_away=1 GROUP BY infection_date ORDER BY infection_date DESC;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                $date = date('F, Y');
                return view('statistics.deaths-report', ['data_by_date' => $data, 'names' => $names, 'report_by' => $report_by, 'date' => $date]);
                break;
            case 'Age segment':
                $data = DB::select('SELECT DISTINCT IF(TIMESTAMPDIFF(YEAR,u1.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u1.birthdate, now())<=40,"Youth", "Elder")) AS Age, (SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.has_passed_away=1 AND IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age) ) AS Total, (SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.has_passed_away=1 AND u2.gender="Male" AND IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age) ) AS Male, ROUND((SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.has_passed_away=1 AND u2.gender="Male" AND IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age))/(SELECT Total)*100,2) AS "male_pcnt", (SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.has_passed_away=1 AND u2.gender="Female" AND IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age) ) AS Female, ROUND((SELECT COUNT(*) FROM users AS u2, infections AS inf2 WHERE inf2.user_id=u2.id AND inf2.has_passed_away=1 AND u2.gender="Female" AND IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=20,"Children", IF(TIMESTAMPDIFF(YEAR,u2.birthdate, now())<=40,"Youth", "Elder"))=(SELECT Age))/(SELECT Total)*100,2) AS "female_pcnt" FROM infections AS inf1, users AS u1 WHERE inf1.has_passed_away=1 ORDER BY Age;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.deaths-report', ['data_by_age' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
            default:
                return null;
        }
    }

    public function userVaccinatingStatus($report_by, $names)
    {
        switch ($report_by) {
            case 'Vaccine status':
                $data = DB::select('SELECT if( m1.vaccine_dose_count = 0, "Not vaccinated", if( m1.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) as vac_status, ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id and u1.gender = "Male" AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status ) as male_count, round((select male_count) / ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status )*100,1) as male_pcnt, ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id and u1.gender = "Female" AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status ) as female_count, round((select female_count) / ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status )*100,1) as female_pcnt, ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status ) as total FROM medical_passports as m1 GROUP BY vac_status;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.vaccine-status', ['data_by_vaccine_status' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
        }
    }

    public function userVaccinatingStatusSummary($report_by, $names)
    {
        switch ($report_by) {
            case 'Default':
                $data = DB::select('SELECT if( mp1.vaccine_dose_count=0,"Not vaccinated", if(mp1.vaccine_dose_count=1,"Partially vaccinated","Fully vaccinated") ) AS vac_status,
                COUNT(*) AS Total FROM medical_passports AS mp1 GROUP BY vac_status;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.vaccine-status-sum', ['data_by_vaccine_status' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
        }
    }

    public function distributionOfHospitals($report_by, $names)
    { ///////////////////////////////////////////////////////////////////
        switch ($report_by) {
            case 'City':
                // $not_vac = DB::select('SELECT u1.city,COUNT(*) AS not_vac FROM users AS u1, medical_passports AS mp1 WHERE mp1.vaccine_dose_count=0 AND mp1.user_id=u1.id GROUP BY u1.city ASC;');
                // $part_vac = DB::select('SELECT u1.city,COUNT(*) AS part_vac FROM users AS u1, medical_passports AS mp1 WHERE mp1.vaccine_dose_count=1 AND mp1.user_id=u1.id GROUP BY u1.city ASC;');
                // $full_vac = DB::select('SELECT u1.city,COUNT(*) AS full_vac FROM users AS u1, medical_passports AS mp1 WHERE mp1.vaccine_dose_count=2 AND mp1.user_id=u1.id GROUP BY u1.city ASC;');
                // $data = [
                //     $not_vac,
                //     $part_vac,
                //     $full_vac,
                // ];
                $data = DB::select('SELECT hos1.city, ( SELECT ifnull( ( ( ( SELECT sum(hos2.capacity) FROM hospitals as hos2 where hos2.city = hos1.city ) - ( SELECT COUNT(*) FROM hospitalizations AS hoz2, hospitals as hos3 WHERE hoz2.hospital_id = hos3.id AND hoz2.checkout_date IS NULL and hos3.city = hos1.city ) ) ), 0 ) ) AS avail_beds , (select count(*) from hospitals as hos4 where hos4.city=hos1.city)as total_hospitals, (select count(*) from hospitals as hos5 where hos5.city=hos1.city and hos5.is_isolation=1)as iso_hospitals, (select count(*) from hospitalizations as hoz3,hospitals as hos6 where hoz3.hospital_id=hos6.id AND hoz3.checkout_date IS NULL and hos6.city = hos1.city) as total_hospitalization FROM hospitals as hos1 GROUP BY hos1.city ORDER BY hos1.city asc;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.distribution-of-hospitals', ['data_by_city' => $data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities]);
                break;
            case 'Hospital':
                $data = DB::select('SELECT hos1.name, hos1.city, IF( hos1.is_isolation=0,"No","Yes") AS is_iso, hos1.capacity, ( SELECT hos1.capacity - ( SELECT COUNT(*) FROM hospitals AS hos2, users AS u1, hospitalizations AS hoz1 WHERE hos2.id = hoz1.hospital_id AND u1.id = hoz1.user_id AND hos2.id = hos1.id AND hoz1.checkout_date IS NULL ) ) AS avail_beds FROM hospitals AS hos1;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.distribution-of-hospitals', ['data_by_hospital' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
        }
    }

    public function infectionsReport($report_by, $names)
    {
        switch ($report_by) {
            case 'City':
                $data = DB::select('SELECT u1.city, ( SELECT COUNT(*) FROM infections_id, users AS u2 WHERE u2.id = infections_id.id AND u2.city = u1.city ) as total_infections, ( SELECT COUNT(*) FROM infections_id, users AS u2 WHERE u2.gender = "Male" AND infections_id.id = u2.id AND u1.city = u2.city ) AS male_count, Round( ifnull( ( SELECT male_count / total_infections * 100 ), 0 ), 1 ) as male_pcnt, ( SELECT COUNT(*) FROM infections_id, users AS u2 WHERE u2.gender = "Female" AND infections_id.id = u2.id AND u1.city = u2.city ) AS female_count, Round( ifnull( ( SELECT female_count / total_infections * 100 ), 0 ), 1 ) as female_pcnt, ( SELECT COUNT(*) FROM hospitals AS hos1 WHERE hos1.city = u1.city ) AS tot_hos, ( SELECT ifnull( round( ( ( ( SELECT sum(hos3.capacity) FROM hospitals as hos3 where hos3.city = u1.city ) - ( SELECT COUNT(*) FROM hospitalizations AS hoz2, hospitals as hos2 WHERE hoz2.hospital_id = hos2.id AND hoz2.checkout_date IS NULL and hos2.city = u1.city ) )/ ( SELECT count(*) FROM hospitals as hos3 where hos3.city = u1.city ) ), 0 ), 0 ) ) AS avg_avail_beds FROM users AS u1 GROUP BY u1.city;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.infections-report', ['data_by_city' => $data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities]);
                break;
            case 'Vaccine status':
                $data = DB::select('SELECT if( m1.vaccine_dose_count = 0, "Not vaccinated", if( m1.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) as vac_status, ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id and u1.gender = "Male" and u1.id in (select id from infections_id) AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status ) as male_count, IFNULL( round( ( select male_count ) / ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id and u1.id in (select id from infections_id) AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status )* 100, 1 ),0) as male_pcnt, ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id and u1.gender = "Female" and u1.id in (select id from infections_id) AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status ) as female_count, IFNULL( round( ( select female_count ) / ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id and u1.id in (select id from infections_id) AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status )* 100, 1 ),0) as female_pcnt, ( select count(*) from medical_passports as m2, users as u1 where u1.id = m2.user_id and u1.id in (select id from infections_id) AND ( select if( m2.vaccine_dose_count = 0, "Not vaccinated", if( m2.vaccine_dose_count = 1, "Partially vaccinated", "Fully vaccinated" ) ) ) = vac_status ) as total FROM medical_passports as m1 , infections_id GROUP BY vac_status;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.infections-report', ['data_by_vaccine_status' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
            case 'Date':
                $data = DB::select('SELECT inf1.infection_date, ( select count(*) from infections as inf2 where inf2.infection_date = inf1.infection_date and inf2.user_id in (select id from infections_id) ) as total_inf, ( select count(*) from users as u2, infections as inf2 where u2.id = inf2.user_id and inf1.infection_date=inf2.infection_date and u2.gender = "Male" and u2.id in ( select id from infections_id ) ) as male_count, ifnull( round( ( ( select male_count ) /( select total_inf )* 100 ), 1 ), 0 ) as male_pcnt, ( select count(*) from users as u2 , infections as inf2 where u2.id = inf2.user_id and inf1.infection_date=inf2.infection_date and u2.gender = "Female" and u2.id in ( select id from infections_id ) ) as female_count, ifnull( round( ( ( select female_count ) /( select total_inf )* 100 ), 1 ), 0 ) as female_pcnt FROM infections AS inf1 WHERE inf1.infection_date BETWEEN DATE_ADD( CURDATE(), INTERVAL - DAY( CURDATE() )+ 1 DAY ) AND CURDATE() AND is_recovered = 0 and has_passed_away = 0 GROUP BY infection_date ORDER BY infection_date DESC;');
                $data = json_encode($data);
                $data = json_decode($data);
                $date = date('F, Y');
                // return $data;
                return view('statistics.infections-report', ['data_by_date' => $data, 'names' => $names, 'report_by' => $report_by, 'date' => $date]);
                break;
            case 'Age segment':
                $data = DB::select('SELECT DISTINCT IF( TIMESTAMPDIFF(YEAR, u1.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u1.birthdate, now())<= 40, "Youth", "Elder" ) ) AS age, ( SELECT COUNT( distinct u2.id) FROM users AS u2, infections AS inf2 WHERE u2.id in (select id from infections_id) AND IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 40, "Youth", "Elder" ) )=( SELECT Age ) ) AS total, ( SELECT COUNT(distinct u2.id) FROM users AS u2, infections AS inf2 WHERE u2.id in (select id from infections_id) AND u2.gender = "Male" AND IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 40, "Youth", "Elder" ) )=( SELECT age ) ) AS male, ROUND( ( SELECT COUNT(distinct u2.id) FROM users AS u2, infections AS inf2 WHERE u2.id in (select id from infections_id) AND u2.gender = "Male" AND IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 40, "Youth", "Elder" ) )=( SELECT age ) )/( SELECT total )* 100, 2 ) AS male_pcnt, ( SELECT COUNT(distinct u2.id) FROM users AS u2, infections AS inf2 WHERE u2.id in (select id from infections_id) AND u2.gender = "Female" AND IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 40, "Youth", "Elder" ) )=( SELECT age ) ) AS female, ROUND( ( SELECT COUNT(distinct u2.id) FROM users AS u2, infections AS inf2 WHERE u2.id in (select id from infections_id) AND u2.gender = "Female" AND IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 40, "Youth", "Elder" ) )=( SELECT age ) )/( SELECT total )* 100, 2 ) AS "female_pcnt" FROM infections AS inf1, users AS u1 group by age ORDER BY age;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.infections-report', ['data_by_age' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
        }
    }

    public function distributionOfChronicDiseases($report_by, $names)
    {
        switch ($report_by) {
            case 'Chronic disease':
                $data = DB::select('SELECT distinct cd1.name, ( SELECT COUNT(distinct u2.id) FROM users AS u2, chronic_diseases AS cd2 WHERE u2.id = cd2.user_id AND cd1.name=cd2.name ) AS total, ( SELECT COUNT(distinct u2.id) FROM users AS u2, chronic_diseases as cd2 WHERE u2.id=cd2.user_id AND u2.gender = "Male" AND cd1.name=cd2.name ) AS male, ROUND( ( SELECT COUNT(distinct u2.id) FROM users AS u2, chronic_diseases as cd2 WHERE u2.id=cd2.user_id and cd2.name=cd1.name AND u2.gender = "Male" )/( SELECT total )* 100, 2 ) AS male_pcnt, ( SELECT COUNT(distinct u2.id) FROM users AS u2, chronic_diseases as cd2 WHERE u2.id=cd2.user_id AND u2.gender = "Female" and cd2.name=cd1.name ) AS female, ROUND( ( SELECT COUNT(distinct u2.id) FROM users AS u2, chronic_diseases as cd2 WHERE u2.id=cd2.user_id and cd2.name=cd1.name AND u2.gender = "Female" )/( SELECT total )* 100, 2 ) AS female_pcnt FROM chronic_diseases AS cd1 group by cd1.name order by cd1.name');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.distribution-of-chronic-diseases', ['data_by_chronic_disease' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
            default:
                return null;
        }
    }

    public function distributionOfDoctorsInHospitals($report_by, $names)
    {
        switch ($report_by) {
            case 'City':
                $data = DB::select('select distinct hos1.city, ( ( select count(u2.id) from users as u2, hospitals as hos2 where u2.hospital_id is not null and u2.hospital_id=hos2.id and hos2.city = hos1.city ) ) as total_doctors, (select count(hos2.id) from hospitals as hos2 where hos2.city=hos1.city )as num_hospitals from hospitals as hos1 ORDER BY hos1.city ASC;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.distribution-of-doctors-in-hospitals', ['data_by_city' => $data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities]);
                break;
            case 'Hospital':
                $data = DB::select('SELECT hos1.name, hos1.city, (select count(*) from users as u2 where u2.hospital_id=hos1.id ) as num_doctors, IF(hos1.is_isolation = 0, "No", "Yes") AS is_iso FROM hospitals AS hos1 ORDER BY hos1.name;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.distribution-of-doctors-in-hospitals', ['data_by_hospital' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
        }
    }

    public function hospitalizationStatus($report_by, $names)
    {
        switch ($report_by) {
            case 'City':
                $data = DB::select('SELECT hos1.city, ( SELECT ifnull( ( ( ( SELECT sum(hos2.capacity) FROM hospitals as hos2 where hos2.city = hos1.city ) - ( SELECT COUNT(*) FROM hospitalizations AS hoz2, hospitals as hos3 WHERE hoz2.hospital_id = hos3.id AND hoz2.checkout_date IS NULL and hos3.city = hos1.city ) ) ), 0 ) ) AS avail_beds , (select count(*) from hospitals as hos4 where hos4.city=hos1.city)as total_hospitals, (select count(*) from hospitals as hos5 where hos5.city=hos1.city and hos5.is_isolation=1)as iso_hospitals, (select count(*) from hospitalizations as hoz3,hospitals as hos6 where hoz3.hospital_id=hos6.id AND hoz3.checkout_date IS NULL and hos6.city = hos1.city) as total_hospitalization FROM hospitals as hos1 GROUP BY hos1.city ORDER BY hos1.city asc;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.hospitalization-status', ['data_by_city' => $data, 'names' => $names, 'report_by' => $report_by, 'cities' => $this->cities]);
                break;
            case 'Hospital':
                $data = DB::select('SELECT hos1.name, hos1.city, IF( hos1.is_isolation=0,"No","Yes") AS is_iso, hos1.capacity, ( SELECT hos1.capacity - ( SELECT COUNT(*) FROM hospitals AS hos2, users AS u1, hospitalizations AS hoz1 WHERE hos2.id = hoz1.hospital_id AND u1.id = hoz1.user_id AND hos2.id = hos1.id AND hoz1.checkout_date IS NULL ) ) AS avail_beds FROM hospitals AS hos1;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.hospitalization-status', ['data_by_hospital' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
            case 'Date':
                $data = DB::select('SELECT Date(hoz1.checkin_date) as hoz_date, ( SELECT COUNT(*) FROM hospitalizations as hoz2 WHERE Date(hoz2.checkin_date) = Date(hoz1.checkin_date ) and hoz2.checkout_date is null ) AS total , ( SELECT COUNT(*) FROM hospitalizations as hoz2, users as u2 WHERE u2.id=hoz2.user_id AND u2.gender = "Male" and Date(hoz2.checkin_date) = Date(hoz1.checkin_date ) and hoz2.checkout_date is null ) AS male, ROUND( (select male)/(select total) * 100, 2 ) AS male_pcnt, ( SELECT COUNT(*) FROM hospitalizations as hoz2, users as u2 WHERE u2.id=hoz2.user_id AND u2.gender = "Female" and Date(hoz2.checkin_date) = Date(hoz1.checkin_date ) and hoz2.checkout_date is null ) AS female , ROUND( (select female)/(select total) * 100,2 )AS female_pcnt FROM hospitalizations as hoz1 where hoz1.checkout_date is null group by Date(hoz1.checkin_date ) order by hoz_date DESC;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.hospitalization-status', ['data_by_date' => $data, 'names' => $names, 'report_by' => $report_by]);
                break;
            case 'Age segment':
                $data = DB::select('SELECT DISTINCT IF( TIMESTAMPDIFF(YEAR, u1.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u1.birthdate, now())<= 40, "Youth", "Elder" ) ) AS age, ( SELECT COUNT(distinct u2.id) FROM users AS u2, hospitalizations as hoz2 WHERE hoz2.user_id = u2.id AND IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 40, "Youth", "Elder" ) )=( SELECT age ) ) AS total, ( SELECT COUNT(distinct u2.id) FROM users AS u2, hospitalizations as hoz2 WHERE hoz2.user_id = u2.id AND u2.gender = "Male" AND IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 40, "Youth", "Elder" ) )=( SELECT age ) ) AS male, ROUND( (select male) /( SELECT total ) * 100, 2 ) AS male_pcnt, ( SELECT COUNT(distinct u2.id) FROM users AS u2, hospitalizations as hoz2 WHERE hoz2.user_id = u2.id AND u2.gender = "Female" AND IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 20, "Children", IF( TIMESTAMPDIFF(YEAR, u2.birthdate, now())<= 40, "Youth", "Elder" ) )=( SELECT age ) ) AS female, ROUND( (select female) /( SELECT total )* 100, 2 ) AS "female_pcnt" FROM hospitalizations as hoz1, users AS u1 group by age ORDER BY age;');
                $data = json_encode($data);
                $data = json_decode($data);
                // return $data;
                return view('statistics.hospitalization-status', ['data_by_age' => $data, 'names' => $names, 'report_by' => $report_by]);
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
            case 'Infections report':
                return $this->infectionsReport($report_by, $names);
                break;
            case 'Distribution of chronic diseases':
                return $this->distributionOfChronicDiseases($report_by, $names);
                break;
            case 'Distribution of doctors in hospitals':
                return $this->distributionOfDoctorsInHospitals($report_by, $names);
                break;
            case 'Distribution of doctors in campaigns (removed)':
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

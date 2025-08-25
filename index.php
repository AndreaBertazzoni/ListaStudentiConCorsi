<?php
require_once "vendor/autoload.php";

use Carbon\Carbon;


function getCourseDateRange(array $course): array
{
    $dates = [];
    foreach ($course["lessons"] as $lesson) {
        $dates[] = $lesson["lessonDate"];
    }
    $start = min($dates);
    $end = max($dates);
    return [$start, $end];
}

function getCourseStatus(Carbon $start, Carbon $end): string
{
    $now = Carbon::now();
    if ($now->lt($start)) {
        return "in attesa di inizio";
    } elseif ($now->between($start, $end)) {
        return "in corso";
    } else {
        return "concluso";
    }
}

function calculateTP(Carbon $entryTime, Carbon $exitTime, Carbon $lessonStart, Carbon $lessonEnd): float
{
    if ($entryTime->lt($lessonStart)) {
        $entryTime = $lessonStart->copy();
    }
    if ($exitTime->gt($lessonEnd)) {
        $exitTime = $lessonEnd->copy();
    }

    if ($exitTime->lte($entryTime)) {
        return 0.0;
    }

    $lessonDuration = $lessonEnd->diffInSeconds($lessonStart);
    $presenceDuration = $exitTime->diffInSeconds($entryTime);

    $tp = ($presenceDuration / $lessonDuration) * 100;

    return round($tp, 1);
}

$students = [
    1 => ["studentId" => 1, "name" => "Andrea", "surname" => "Rossi"],
    2 => ["studentId" => 2, "name" => "Federico", "surname" => "Verdi"],
    3 => ["studentId" => 3, "name" => "Alessandro", "surname" => "Bianchi"],
    4 => ["studentId" => 4, "name" => "Giacomo", "surname" => "Leopardi"],
];

$courses = [
    101 =>
    [
        "courseId" => 101,
        "courseName" => "Storia dell'Arte",
        "lessons" => [
            1001 =>
            [
                "lessonId" => 1001,
                "lessonNumber" => 1,
                "lessonName" => "Introduzione Storia dell'Arte",
                "lessonDate" => "10/05/2025",
                "lessonStart" => "10:00",
                "lessonEnd" => "12:00",
            ],
            1002 =>
            [
                "lessonId" => 1002,
                "lessonNumber" => 2,
                "lessonName" => "Rinascimento",
                "lessonDate" => "13/05/2025",
                "lessonStart" => "09:00",
                "lessonEnd" => "12:00",
            ],
            1003 =>
            [
                "lessonId" => 1003,
                "lessonNumber" => 3,
                "lessonName" => "Futurismo",
                "lessonDate" => "17/05/2025",
                "lessonStart" => "13:30",
                "lessonEnd" => "16:00",
            ],
            1004 =>
            [
                "lessonId" => 1004,
                "lessonNumber" => 4,
                "lessonName" => "Arte Contemporanea",
                "lessonDate" => "22/05/2025",
                "lessonStart" => "14:00",
                "lessonEnd" => "17:30",
            ],
        ],
    ],
    102 =>
    [
        "courseId" => 102,
        "courseName" => "Programmazione PHP",
        "lessons" => [
            2001 =>
            [
                "lessonId" => 2001,
                "lessonNumber" => 1,
                "lessonName" => "Introduzione PHP",
                "lessonDate" => "06/08/2025",
                "lessonStart" => "09:00",
                "lessonEnd" => "12:00",
            ],
            2002 =>
            [
                "lessonId" => 2002,
                "lessonNumber" => 2,
                "lessonName" => "Variabili",
                "lessonDate" => "08/08/2025",
                "lessonStart" => "14:00",
                "lessonEnd" => "18:00",
            ],
            2003 =>
            [
                "lessonId" => 2003,
                "lessonNumber" => 3,
                "lessonName" => "Logica if/else",
                "lessonDate" => "12/08/2025",
                "lessonStart" => "09:30",
                "lessonEnd" => "12:30",
            ],
            2004 =>
            [
                "lessonId" => 2004,
                "lessonNumber" => 4,
                "lessonName" => "Array",
                "lessonDate" => "14/08/2025",
                "lessonStart" => "14:00",
                "lessonEnd" => "17:30",
            ],
        ],
    ],
    103 =>
    [
        "courseId" => 103,
        "courseName" => "Matematica",
        "lessons" => [
            3001 =>
            [
                "lessonId" => 3001,
                "lessonNumber" => 1,
                "lessonName" => "Introduzione Matematica",
                "lessonDate" => "10/09/2025",
                "lessonStart" => "10:00",
                "lessonEnd" => "13:00",
            ],
            3002 =>
            [
                "lessonId" => 3002,
                "lessonNumber" => 2,
                "lessonName" => "Calcoli semplici",
                "lessonDate" => "12/09/2025",
                "lessonStart" => "15:00",
                "lessonEnd" => "18:30",
            ],
            3003 =>
            [
                "lessonId" => 3003,
                "lessonNumber" => 3,
                "lessonName" => "Equazioni",
                "lessonDate" => "15/09/2025",
                "lessonStart" => "08:30",
                "lessonEnd" => "12:00",
            ],
            3004 =>
            [
                "lessonId" => 3004,
                "lessonNumber" => 4,
                "lessonName" => "Algebra",
                "lessonDate" => "17/09/2025",
                "lessonStart" => "14:00",
                "lessonEnd" => "17:30",
            ],
        ],
    ],
];

foreach ($courses as &$course) {
    $course['lessons'] = array_map(function ($lesson) {
        $lesson["lessonDate"] = Carbon::createFromFormat("d/m/Y", $lesson["lessonDate"]);
        $lesson["lessonStart"] = Carbon::createFromFormat("d/m/Y H:i", $lesson["lessonDate"]->format("d/m/Y") . " " . $lesson["lessonStart"]);
        $lesson["lessonEnd"] = Carbon::createFromFormat("d/m/Y H:i", $lesson["lessonDate"]->format("d/m/Y") . " " . $lesson["lessonEnd"]);
        return $lesson;
    }, $course['lessons']);
};
unset($course);

$subscriptions = [
    1 => [101, 103],  // First student Andrea Rossi (studentId = 1) enrolled in "Storia dell'Arte" (courseId = 101) and "Matematica" (courseId = 103) 
    2 => [101, 102, 103],
    3 => [102],
    4 => [102, 103],
];

$attendance_records = [
    // === Andrea Rossi (Best student)  ===

    // Storia dell'Arte (courseId = 101)

    ["studentId" => 1, "lessonId" => 1001, "lessonDate" => "10/05/2025", "entryTime" => "10:00", "exitTime" => "12:00"],
    ["studentId" => 1, "lessonId" => 1002, "lessonDate" => "13/05/2025", "entryTime" => "09:00", "exitTime" => "12:00"],
    ["studentId" => 1, "lessonId" => 1003, "lessonDate" => "17/05/2025", "entryTime" => "13:30", "exitTime" => "16:00"],
    ["studentId" => 1, "lessonId" => 1004, "lessonDate" => "22/05/2025", "entryTime" => "14:00", "exitTime" => "17:30"],

    // Matematica (courseId = 103)
    ["studentId" => 1, "lessonId" => 3001, "lessonDate" => "10/09/2025", "entryTime" => "10:00", "exitTime" => "13:00"],
    ["studentId" => 1, "lessonId" => 3002, "lessonDate" => "12/09/2025", "entryTime" => "15:00", "exitTime" => "18:30"],
    ["studentId" => 1, "lessonId" => 3003, "lessonDate" => "15/09/2025", "entryTime" => "08:30", "exitTime" => "12:00"],
    ["studentId" => 1, "lessonId" => 3004, "lessonDate" => "17/09/2025", "entryTime" => "14:00", "exitTime" => "17:30"],

    // === Federico Verdi (studentId = 2) ===

    // Storia dell'Arte (101)

    ["studentId" => 2, "lessonId" => 1001, "lessonDate" => "10/05/2025", "entryTime" => "10:15", "exitTime" => "11:45"],
    ["studentId" => 2, "lessonId" => 1002, "lessonDate" => "13/05/2025", "entryTime" => "09:05", "exitTime" => "12:00"],
    ["studentId" => 2, "lessonId" => 1003, "lessonDate" => "17/05/2025", "entryTime" => "13:30", "exitTime" => "15:00"],
    // Absent 1004 (Arte Contemporanea)

    // Programmazione PHP (102)

    ["studentId" => 2, "lessonId" => 2001, "lessonDate" => "06/08/2025", "entryTime" => "09:00", "exitTime" => "12:00"],
    ["studentId" => 2, "lessonId" => 2002, "lessonDate" => "08/08/2025", "entryTime" => "14:10", "exitTime" => "17:50"],
    ["studentId" => 2, "lessonId" => 2003, "lessonDate" => "12/08/2025", "entryTime" => "09:40", "exitTime" => "12:30"],
    // Absent 2004

    // Matematica (103)

    ["studentId" => 2, "lessonId" => 3001, "lessonDate" => "10/09/2025", "entryTime" => "10:30", "exitTime" => "13:00"],
    // Absent 3002
    ["studentId" => 2, "lessonId" => 3003, "lessonDate" => "15/09/2025", "entryTime" => "08:30", "exitTime" => "11:30"], // early exitTime
    ["studentId" => 2, "lessonId" => 3004, "lessonDate" => "17/09/2025", "entryTime" => "14:00", "exitTime" => "17:00"],

    //  === Alessandro Bianchi (studentId = 3) === 

    // Programmazione PHP (102)

    ["studentId" => 3, "lessonId" => 2001, "lessonDate" => "06/08/2025", "entryTime" => "09:00", "exitTime" => "11:00"], // early exitTime
    ["studentId" => 3, "lessonId" => 2002, "lessonDate" => "08/08/2025", "entryTime" => "14:00", "exitTime" => "18:00"],
    ["studentId" => 3, "lessonId" => 2003, "lessonDate" => "12/08/2025", "entryTime" => "09:45", "exitTime" => "12:30"],
    ["studentId" => 3, "lessonId" => 2004, "lessonDate" => "14/08/2025", "entryTime" => "14:00", "exitTime" => "17:30"],

    //  === Giacomo Leopardi (studentId = 4) === 

    // Programmazione PHP (102)

    ["studentId" => 4, "lessonId" => 2001, "lessonDate" => "06/08/2025", "entryTime" => "09:15", "exitTime" => "12:00"],
    ["studentId" => 4, "lessonId" => 2002, "lessonDate" => "08/08/2025", "entryTime" => "14:00", "exitTime" => "17:00"], // early exitTime
    ["studentId" => 4, "lessonId" => 2003, "lessonDate" => "12/08/2025", "entryTime" => "10:00", "exitTime" => "12:30"],
    ["studentId" => 4, "lessonId" => 2004, "lessonDate" => "14/08/2025", "entryTime" => "14:00", "exitTime" => "17:00"], // early exitTime

    // Matematica (103)

    ["studentId" => 4, "lessonId" => 3001, "lessonDate" => "10/09/2025", "entryTime" => "10:00", "exitTime" => "13:00"],
    ["studentId" => 4, "lessonId" => 3002, "lessonDate" => "12/09/2025", "entryTime" => "15:10", "exitTime" => "18:30"],
    // Absent 3003
    ["studentId" => 4, "lessonId" => 3004, "lessonDate" => "17/09/2025", "entryTime" => "14:00", "exitTime" => "17:30"],
];

$attendance_records = array_map(function ($record) {
    $record["lessonDate"] = Carbon::createFromFormat("d/m/Y", $record["lessonDate"]);
    $record["entryTime"] = Carbon::createFromFormat("d/m/Y H:i", $record["lessonDate"]->format("d/m/Y") . " " . $record["entryTime"]);
    $record["exitTime"] = Carbon::createFromFormat("d/m/Y H:i", $record["lessonDate"]->format("d/m/Y") . " " . $record["exitTime"]);

    return $record;
}, $attendance_records);

// Print section
foreach ($courses as $course) {
    [$start, $end] = getCourseDateRange($course);
    $status = getCourseStatus($start, $end);

    echo "<h3>Corso: {$course['courseName']}<br></h3>";
    echo "Prima lezione: " . $start->format("d/m/Y") . "<br> Ultima lezione: " . $end->format("d/m/Y") . "<br>";
    echo "Stato: $status<br><br>";
}

$studentStats = [];

foreach ($students as $studentId => $student) {
    $studentStats[$studentId] = [
        "studentId" => $studentId,
        "name" => $student["name"],
        "surname" => $student["surname"],
        "courses" => []
    ];

    foreach ($subscriptions[$studentId] as $courseId) {
        $studentStats[$studentId]["courses"][$courseId] = [
            "courseId" => $courseId,
            "totalLessons" => count($courses[$courseId]["lessons"]),
            "attendedLessons" => 0,
            "absentLessons" => 0,
            "avgTP" => null,
            "tpDetails" => [],
        ];
    }
}

// ------------------ POPOLAMENTO ------------------

foreach ($attendance_records as $record) {
    $studentId = $record["studentId"];
    $lessonId = $record["lessonId"];

    foreach ($courses as $courseId => $course) {
        if (isset($course["lessons"][$lessonId])) {
            $lesson = $course["lessons"][$lessonId];

            $tp = calculateTP(
                $record["entryTime"],
                $record["exitTime"],
                Carbon::parse($lesson["lessonStart"]),
                Carbon::parse($lesson["lessonEnd"])
            );

            $studentStats[$studentId]["courses"][$courseId]["tpDetails"][$lessonId] = $tp;
            if ($tp > 0) {
                $studentStats[$studentId]["courses"][$courseId]["attendedLessons"]++;
            }
        }
    }
}

// ------------------ CALCOLI FINALI ------------------

foreach ($studentStats as &$student) {
    foreach ($student["courses"] as &$courseStats) {
        $courseStats["absentLessons"] = $courseStats["totalLessons"] - $courseStats["attendedLessons"];

        if (count($courseStats["tpDetails"]) > 0) {
            $courseStats["avgTP"] = round(
                array_sum($courseStats["tpDetails"]) / count($courseStats["tpDetails"]),
                1
            );
        }
    }
}
unset($student, $courseStats);

// ------------------ OUTPUT ------------------

foreach ($studentStats as $student) {
    echo "<h3>{$student['name']} {$student['surname']}</h3>";

    foreach ($student["courses"] as $courseStats) {
        $courseName = $courses[$courseStats["courseId"]]["courseName"];
        echo "Corso: $courseName<br>";
        echo "Lezioni totali: {$courseStats['totalLessons']}<br>";
        echo "Presenze: {$courseStats['attendedLessons']}<br>";
        echo "Assenze: {$courseStats['absentLessons']}<br>";
        echo "Media TP: {$courseStats['avgTP']}%<br><br>";
    }
}

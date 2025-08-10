
<?php
require_once "vendor/autoload.php";

use Carbon\Carbon;

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
                "startTime" => "10:00",
                "endTime" => "12:00",
            ],

            1002 =>
            [
                "lessonId" => 1002,
                "lessonNumber" => 2,
                "lessonName" => "Rinascimento",
                "lessonDate" => "13/05/2025",
                "startTime" => "09:00",
                "endTime" => "12:00",
            ],
            1003 =>
            [
                "lessonId" => 1003,
                "lessonNumber" => 3,
                "lessonName" => "Futurismo",
                "lessonDate" => "17/05/2025",
                "startTime" => "13:30",
                "endTime" => "16:00",
            ],
            1004 =>
            [
                "lessonId" => 1004,
                "lessonNumber" => 4,
                "lessonName" => "Arte Contemporanea",
                "lessonDate" => "22/05/2025",
                "startTime" => "14:00",
                "endTime" => "17:30",
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
                "startTime" => "09:00",
                "endTime" => "12:00",
            ],

            2002 =>
            [
                "lessonId" => 2002,
                "lessonNumber" => 2,
                "lessonName" => "Variabili",
                "lessonDate" => "08/08/2025",
                "startTime" => "14:00",
                "endTime" => "18:00",
            ],
            2003 =>
            [
                "lessonId" => 2003,
                "lessonNumber" => 3,
                "lessonName" => "Logica if/else",
                "lessonDate" => "12/08/2025",
                "startTime" => "09:30",
                "endTime" => "12:30",
            ],
            2004 =>
            [
                "lessonId" => 2004,
                "lessonNumber" => 4,
                "lessonName" => "Array",
                "lessonDate" => "14/08/2025",
                "startTime" => "14:00",
                "endTime" => "17:30",
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
                "startTime" => "10:00",
                "endTime" => "13:00",
            ],

            3002 =>
            [
                "lessonId" => 3002,
                "lessonNumber" => 2,
                "lessonName" => "Calcoli semplici",
                "lessonDate" => "12/09/2025",
                "startTime" => "15:00",
                "endTime" => "18:30",
            ],
            3003 =>
            [
                "lessonId" => 3003,
                "lessonNumber" => 3,
                "lessonName" => "Equazioni",
                "lessonDate" => "15/09/2025",
                "startTime" => "08:30",
                "endTime" => "12:00",
            ],
            3004 =>
            [
                "lessonId" => 3004,
                "lessonNumber" => 4,
                "lessonName" => "Algebra",
                "lessonDate" => "17/09/2025",
                "startTime" => "14:00",
                "endTime" => "17:30",
            ],

        ],

    ],



];


foreach ($courses as &$course) {
    foreach ($course["lessons"] as &$lesson) {

        $lesson["lessonDate"] = Carbon::createFromFormat("d/m/Y", $lesson["lessonDate"]);
        $lesson["startTime"] = Carbon::createFromFormat("d/m/Y H:i", $lesson["lessonDate"]->format("d/m/Y") . "" . $lesson["startTime"]);
        $lesson["endTime"] = Carbon::createFromFormat("d/m/Y H:i", $lesson["lessonDate"]->format("d/m/Y") . "" . $lesson["endTime"]);
    }
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
    ["studentId" => 1, "lessonId" => 1003, "lessonDate" => "17/05/2025", "entryTime" => "10:00", "exitTime" => "12:00"],
    ["studentId" => 1, "lessonId" => 1004, "lessonDate" => "22/05/2025", "entryTime" => "10:00", "exitTime" => "12:00"],

    // Matematica (courseId = 103)

    ["studentId" => 1, "lessonId" => 3001, "lessonDate" => "10/09/2025", "entryTime" => "10:00", "exitTime" => "13:00"],
    ["studentId" => 1, "lessonId" => 3002, "lessonDate" => "12/09/2025", "entryTime" => "15:00", "exitTime" => "18:30"],
    ["studentId" => 1, "lessonId" => 3003, "lessonDate" => "15/09/2025", "entryTime" => "08:30", "exitTime" => "12:00"],
    ["studentId" => 1, "lessonId" => 3004, "lessonDate" => "17/09/2025", "entryTime" => "14:00", "exitTime" => "17:30"],




    // === Federico Verdi (studentId = 2) ===

    // Storia dell'Arte (101)

    ["studentId" => 2, "lessonId" => 1001, "lessonDate" => "10/05/2025", "entryTime" => "10:15", "exitTime" => "11:45"],
    ["studentId" => 2, "lessonId" => 1002, "lessonDate" => "13/05/2025", "entryTime" => "09:05", "exitTime" => "12:00"],
    ["studentId" => 2, "lessonId" => 1003, "lessonDate" => "17/05/2025", "entryTime" => "13:30", "exitTime" => "15:00"], // early exit
    // Absent 1004 (Arte Contemporanea)

    // Programmazione PHP (102)

    ["studentId" => 2, "lessonId" => 2001, "lessonDate" => "06/08/2025", "entryTime" => "09:00", "exitTime" => "12:00"],
    ["studentId" => 2, "lessonId" => 2002, "lessonDate" => "08/08/2025", "entryTime" => "14:10", "exitTime" => "17:50"],
    ["studentId" => 2, "lessonId" => 2003, "lessonDate" => "12/08/2025", "entryTime" => "09:40", "exitTime" => "12:30"],
    // Absent 2004

    // Matematica (103)

    ["studentId" => 2, "lessonId" => 3001, "lessonDate" => "10/09/2025", "entryTime" => "10:30", "exitTime" => "13:00"],
    // Absent 3002
    ["studentId" => 2, "lessonId" => 3003, "lessonDate" => "15/09/2025", "entryTime" => "08:30", "exitTime" => "11:30"], // early exit
    ["studentId" => 2, "lessonId" => 3004, "lessonDate" => "17/09/2025", "entryTime" => "14:00", "exitTime" => "17:00"],




    //  === Alessandro Bianchi (studentId = 3) === 

    // Programmazione PHP (102)

    ["studentId" => 3, "lessonId" => 2001, "lessonDate" => "06/08/2025", "entryTime" => "09:00", "exitTime" => "11:00"], // early exit
    ["studentId" => 3, "lessonId" => 2002, "lessonDate" => "08/08/2025", "entryTime" => "14:00", "exitTime" => "18:00"],
    ["studentId" => 3, "lessonId" => 2003, "lessonDate" => "12/08/2025", "entryTime" => "09:45", "exitTime" => "12:30"],
    ["studentId" => 3, "lessonId" => 2004, "lessonDate" => "14/08/2025", "entryTime" => "14:00", "exitTime" => "17:30"],




    //  === Giacomo Leopardi (studentId = 4) === 

    // Programmazione PHP (102)

    ["studentId" => 4, "lessonId" => 2001, "lessonDate" => "06/08/2025", "entryTime" => "09:15", "exitTime" => "12:00"],
    ["studentId" => 4, "lessonId" => 2002, "lessonDate" => "08/08/2025", "entryTime" => "14:00", "exitTime" => "17:00"], // early exit
    ["studentId" => 4, "lessonId" => 2003, "lessonDate" => "12/08/2025", "entryTime" => "10:00", "exitTime" => "12:30"],
    ["studentId" => 4, "lessonId" => 2004, "lessonDate" => "14/08/2025", "entryTime" => "14:00", "exitTime" => "17:00"], // early exit

    // Matematica (103)

    ["studentId" => 4, "lessonId" => 3001, "lessonDate" => "10/09/2025", "entryTime" => "10:00", "exitTime" => "13:00"],
    ["studentId" => 4, "lessonId" => 3002, "lessonDate" => "12/09/2025", "entryTime" => "15:10", "exitTime" => "18:30"],
    // Absent 3003
    ["studentId" => 4, "lessonId" => 3004, "lessonDate" => "17/09/2025", "entryTime" => "14:00", "exitTime" => "17:30"],
];


foreach ($attendance_records as &$record) {

    $record["lessonDate"] = Carbon::createFromFormat("d/m/Y", $record["lessonDate"]);
    $record["entryTime"] = Carbon::createFromFormat("d/m/Y H:i", $record["lessonDate"]->format("d/m/Y") . " " . $record["entryTime"]);
    $record["exitTime"] = Carbon::createFromFormat("d/m/Y H:i", $record["lessonDate"]->format("d/m/Y") . " " . $record["exitTime"]);
}
unset($record);




?>
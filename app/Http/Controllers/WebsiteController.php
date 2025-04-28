<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


class WebsiteController extends Controller
{

    function index()
    {

        $jayParsedAry = [
            [
                "id" => 1,
                "name" => "Cover page",
                "type" => "Cover page",
                "status" => "In Process",
                "target" => "18",
                "limit" => "5",
                "email" => "Eddie Lake"
            ],
            [
                "id" => 2,
                "name" => "Table of contents",
                "type" => "Table of contents",
                "status" => "Done",
                "target" => "29",
                "limit" => "24",
                "email" => "Eddie Lake"
            ],
            [
                "id" => 3,
                "name" => "Executive summary",
                "type" => "Narrative",
                "status" => "Done",
                "target" => "10",
                "limit" => "13",
                "email" => "Eddie Lake"
            ],
            [
                "id" => 4,
                "name" => "Technical approach",
                "type" => "Narrative",
                "status" => "Done",
                "target" => "27",
                "limit" => "23",
                "email" => "Jamik Tashpulatov"
            ],
            [
                "id" => 5,
                "name" => "Design",
                "type" => "Narrative",
                "status" => "In Process",
                "target" => "2",
                "limit" => "16",
                "email" => "Jamik Tashpulatov"
            ],
            [
                "id" => 6,
                "name" => "Capabilities",
                "type" => "Narrative",
                "status" => "In Process",
                "target" => "20",
                "limit" => "8",
                "email" => "Jamik Tashpulatov"
            ],
            [
                "id" => 7,
                "name" => "Integration with existing systems",
                "type" => "Narrative",
                "status" => "In Process",
                "target" => "19",
                "limit" => "21",
                "email" => "Jamik Tashpulatov"
            ],
            [
                "id" => 8,
                "name" => "Innovation and Advantages",
                "type" => "Narrative",
                "status" => "Done",
                "target" => "25",
                "limit" => "26",
                "email" => "Assign email"
            ],
            [
                "id" => 9,
                "name" => "Overview of EMR's Innovative Solutions",
                "type" => "Technical content",
                "status" => "Done",
                "target" => "7",
                "limit" => "23",
                "email" => "Assign email"
            ],
            [
                "id" => 10,
                "name" => "Advanced Algorithms and Machine Learning",
                "type" => "Narrative",
                "status" => "Done",
                "target" => "30",
                "limit" => "28",
                "email" => "Assign email"
            ],
            [
                "id" => 11,
                "name" => "Adaptive Communication Protocols",
                "type" => "Narrative",
                "status" => "Done",
                "target" => "9",
                "limit" => "31",
                "email" => "Assign email"
            ],
            [
                "id" => 12,
                "name" => "Advantages Over Current Technologies",
                "type" => "Narrative",
                "status" => "Done",
                "target" => "12",
                "limit" => "0",
                "email" => "Assign email"
            ]
        ];

        return Inertia::render('website', ['data'  => $jayParsedAry]);
    }
}

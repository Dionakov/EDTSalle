<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Calendar {
    public static function getRoomSchedule($room) {
        $ressources=array('S10'=>127,'S11'=>128,'S23'=>129,'S15'=>130,'S26'=>133,'S01'=>118,'S03'=>119,'S13'=>120,'S14'=>121,'S16'=>122,'S17'=>123,'S22'=>135,'S24'=>136,'S18'=>126,'S25'=>131,'S12'=>132,'S21'=>134);
        $url="http://adelb.univ-lyon1.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=".$ressources[$room]
                . "&projectId=1&calType=ical&firstDate="
                . date("Y-m-d"). "&lastDate=" . date("Y-m-d");
        return Calendar::parse($url);
    }
    public static function getDaySchedule() {
        $url="http://adelb.univ-lyon1.fr/jsp/custom/modules/plannings/anonymous_cal.jsp"
                . "?resources=5700,9309,9310,17480,17481,17498,17499,17500,17501,17502,17503,"
                . "17504,9292,9319,9320,9321,9274,9273,9275,9298,9299,9300,9301,9302,9303,9304,"
                . "9305,9306,5484,9293,9311,9312,9313,9314,9315,9316,9317,9272,18783"
                . "&projectId=1&calType=ical&firstDate=" . date("Y-m-d"). "&lastDate=" . date("Y-m-d");
        return Calendar::parse($url);     
    }
    private static function parse($url) {
        $icsFile = file_get_contents($url);

        $icsData = explode("BEGIN:", $icsFile);

        foreach($icsData as $key => $value) {
            $icsDatesMeta[$key] = explode("\n", $value);
        }
        foreach($icsDatesMeta as $key => $value) {
            foreach($value as $subKey => $subValue) {
                if ($subValue != "") {
                    if ($key != 0 && $subKey == 0) {
                        $icsDates[$key]["BEGIN"] = $subValue;
                    } else {
                        $subValueArr = explode(":", $subValue, 2);
                        $icsDates[$key][$subValueArr[0]] = $subValueArr[1];
                    }
                }
            }
        }
        return $icsDates;
    }
}

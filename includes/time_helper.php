<?php

function Formatdate($date)
{
    $dt = new DateTime($date);
    return $dt->format('l j F Y g:i A');
}

function CheckSubmissionStatus($endDate, $submittedAt = null)
{
    $end = new DateTime($endDate);
    $now = new DateTime();

    if ($submittedAt) {
        $submitted = new DateTime($submittedAt);
        $diff = $submitted->diff($end);
        if ($submitted > $end) {
            return "ส่งสายไปแล้ว {$diff->days} วัน {$diff->h} ชั่วโมง {$diff->i} นาที";
        } else {
            return "ส่งทันเวลา {$diff->days} วัน {$diff->h} ชั่วโมง {$diff->i} นาที";
        }
    } else {
        $diff = $now->diff($end);
        if ($now > $end) {
            return "หมดเขตแล้ว (สายมา {$diff->days} วัน {$diff->h} ชั่วโมง {$diff->i} นาที)";
        }else{
            return "ยังไม่หมดเขต (เหลือ {$diff->days} วัน {$diff->h} ชั่วโมง {$diff->i} นาที)";
        }
    }
}

function checkDueTime($endDate)
{
    $end = new DateTime($endDate);
    $now = new DateTime();

    if($endDate){
        $diff = $now->diff($end);
        if ($now > $end) {
            return true;
        }else{
            return false;
        }
    }
}
function formatDay($date){
    $dt = new DateTime($date);
    return $dt->format('j F g:i A'); // แสดงเลขวัน + ชื่อเดือน
}

?>
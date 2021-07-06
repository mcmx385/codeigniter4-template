<?php

namespace App\Libraries;

use DateTime;
use DatePeriod;
use DateInterval;

class datetimeLib
{

    public $month_chi = ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '十一', '十二'];
    public $week_chi = ['日', '一', '二', '三', '四', '五', '六'];

    // Datetime = DT
    public function currentDT()
    {
        return date("Y-m-d H:i:s");
    }
    public function currentDate()
    {
        return date("Y-m-d");
    }
    public function objectDate($date)
    {
        return new DateTime($date);
    }
    public function pastDT($current_time, $sec)
    {
        $backintime = strtotime($current_time) - $sec;
        return date("Y-m-d H:i:s", $backintime);
    }
    public function futureDT($current_time, $sec)
    {
        $backintime = strtotime($current_time) + $sec;
        return date("Y-m-d H:i:s", $backintime);
    }
    public function utc2local($utc)
    {
        return date('Y-m-d\TH:i', strtotime($utc));
    }
    public function local2utc($local)
    {
        return date("Y-m-d H:i:s", strtotime($local));
    }
    public function utc2iso($utc)
    {
        return date("c", strtotime($utc));
    }
    public function date2DT($date)
    {
        return $date . " 00:00:00";
    }
    public function DT2Date($DT)
    {
        $createDate = new DateTime($DT);
        return $createDate->format('Y-m-d');
    }
    public function DT2Time($DT)
    {
        $createDate = new DateTime($DT);
        return $createDate->format('H:i:s');
    }
    public function DT2HM($DT)
    {
        $createDate = new DateTime($DT);
        return $createDate->format('H:i');
    }
    public function DT2DHM($DT)
    {
        $createDate = new DateTime($DT);
        return $createDate->format('Y-m-d H:i');
    }
    public function getDatePeriod($start_date, $end_date)
    {
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            new DateTime($end_date)
        );
        $list = [];
        foreach ($period as $key => $value) {
            $date = $value->format('Y-m-d');
            array_push($list, $date);
        }
        $list = $this->listDate2weekday($list);
        return $list;
    }
    public function listDate2weekday($result)
    {
        $list = [];
        foreach ($result as $item) :
            $weekday = $this->date2weekday($item);
            $list[$item] = $weekday;
        endforeach;
        return $list;
    }
    public function listDT2Date($result)
    {
        $list = [];
        foreach ($result as $item) :
            $date = date('Y-m-d', strtotime($item));
            array_push($list, $date);
        endforeach;
        return $list;
    }
    public function date2weekday($date)
    {
        return date('w', strtotime($date));
    }

    public function futureDate($current_time, $sec)
    {
        $backintime = strtotime($current_time) + $sec;
        return date("Y-m-d H:i:s", $backintime);
    }
    public function futureWeekDate($current_time, $weeks)
    {
        return $this->futureDate($current_time, $weeks * 7 * 24 * 60 * 60);
    }
    public function DTChangeDate($DT, $date)
    {
        $time = date('H:i:s', strtotime($DT));
        return  $date . " " . $time;
    }
    public function weekDiff($start_date, $end_date)
    {
        $diff = strtotime($end_date, 0) - strtotime($start_date, 0);
        return floor($diff / 604800);
    }
    public function dayDiff($start_date, $end_date)
    {
        $diff = strtotime($end_date, 0) - strtotime($start_date, 0);
        return floor($diff / 86400);
    }
    public function weekDayChi($date)
    {
        $weekday = date('w', strtotime($date));
        return '星期' . $this->week_chi[$weekday];
    }
    public function monthChi($date)
    {
        $weekday = date('m', strtotime($date));
        return $this->month_chi[$weekday] . "月";
    }
    public function formatPercent($date)
    {
        $date = str_split($date);
        $new_date = [];
        foreach ($date as $char) :
            if (ctype_alpha($char)) :
                $char = "%$char";
            endif;
            array_push($new_date, $char);
        endforeach;
        $new_date = implode("", $new_date);
        return $new_date;
    }

    // Defined
    public function todayDT()
    {
        return date("Y-m-d 00:00:00");
    }
    public function todayDate()
    {
        return date("Y-m-d");
    }
    public function tmrDate()
    {
        return date("Y-m-d", strtotime('+1 days'));
    }
    public function tmrDT()
    {
        return date("Y-m-d 00:00:00", strtotime('+1 days'));
    }
    public function yesterdayDT()
    {
        return date("Y-m-d 00:00:00", strtotime('-1 days'));
    }
    public function weekendDT()
    {
        return date("Y-m-d 00:00:00", strtotime('this Saturday'));
    }
    public function sundayDT()
    {
        return date("Y-m-d 00:00:00", strtotime('this Sunday'));
    }
    public function getDTList()
    {
        $data = (object) [];
        $data->yesterday = $this->yesterdayDT();
        $data->current = $this->currentDT();
        $data->today = $this->todayDT();
        $data->tomorrow = $this->tmrDT();
        $data->thisMonthStartDT = $this->thisMonthStartDT();
        $data->nextMonthStartDT = $this->nextMonthStartDT();
        $data->weekend = $this->weekendDT();
        $data->sunday7 = $this->sundayDT();
        return $data;
    }
    public function lastMonthStartDT()
    {
        return date("Y-m-d 00:00:00", strtotime('first day of last month'));
    }
    public function lastMonthStartDateSlash()
    {
        return date("m/d/Y", strtotime('first day of last month'));
    }
    public function thisMonthStartDT()
    {
        return date("Y-m-d 00:00:00", strtotime('first day of this month'));
    }
    public function thisMonthStartDateSlash()
    {
        return date("m/d/Y", strtotime('first day of this month'));
    }
    public function nextMonthStartDT()
    {
        return date("Y-m-d 00:00:00", strtotime('first day of +1 month'));
    }
    public function nextMonthStartDateSlash()
    {
        return date("m/d/Y", strtotime('first day of +1 month'));
    }
    public function hypen2slash($hypen)
    {
        return date("m/d/Y", strtotime($hypen));
    }
    public function slash2Date($slash)
    {
        return date("Y-m-d", strtotime($slash));
    }
    public function slash2DT($slash)
    {
        return date("Y-m-d 00:00:00", strtotime($slash));
    }
    public function turnArrayDT2Date($result, $col)
    {
        $count = 0;
        foreach ($result as $item) :
            $result[$count]->$col = $this->DT2Date($item->$col);
            $count += 1;
        endforeach;
        return $result;
    }

    // Timezone = TZ
    public function setTZ($region)
    {
        date_default_timezone_set($region);
    }
    public function getTZ()
    {
        return date_default_timezone_get();
    }
}

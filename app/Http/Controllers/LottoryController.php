<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
class LottoryController extends Controller
{
    public function create()
    {
        return view('lottory.create');
    }

    function checkLabel(Record $record,Request $request){
        $ret = true;
        
        if (strops(($record->label),$requset->label) == FALSE){
            $ret = false;
        }
        
        return $ret;
    }

    function checkRestrictCond(Record $record,Request $request){
        return true;
    }

    public function store(Request $request)
    {
        $validRecords = [];  // 抽奖池
        $records = Record::all(); // select *
        
        foreach ($records as $record) // 遍历
        {
            
            $date = date_create($record->time); // 将数据库里的聊天记录的发言时间，从 YYYY-MM-DD HH:MM:SS 字符串形式转换为一个datetime对象
            
            if (($date >= $request->start) &&
                ($date <= $request->end))  // 筛选存在于抽奖时间段之内的聊天记录
                {
                    echo "yes";
                    if ((checkLabel($record, $request)) // 发言记录要包含抽奖标签
                        and (checkRestrictCond($record, $request)))
                    {
                        $validRecords.append($record);
                    }
                }
        }
        
        $luckyDog = []; // 中奖幸运儿
        $validRecordsCount = count($validRecords); // 有资格参与抽奖的人的数量比预设中奖人数还少，就全体中奖

        if($validRecordsCount < $request->people_number)
        {
            $luckyDog = $validRecords;
            return $luckyDog;
        }
        // 如果没进上面的if分支，意味着参与抽奖的人数大于可中奖人数。
        for ($ii=0; ($ii < $request->people_number); $$ii++)
        {
            $randNum = mt_rand(0, count($validRecords)-1);
            $luckyDog.append($validRecords[$randNum]->qqnumber);
            array_splice($validRecords, $randNum,1);
        }
        return $luckyDog;
    }
}

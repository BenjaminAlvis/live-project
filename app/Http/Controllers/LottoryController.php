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

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'docs' => 'required',
            'start' => 'required',
            'end' => 'required',
            'release' => 'required',
            'people_number' => 'required',
            'award' => 'required',
        ]);

        $validRecords = [];  // 抽奖池
        $records = Record::all(); // select *
        
        // date_create函数，把格式为 YYYY-MM-DD HH:MM:SS 的字符串转换为一个datetime对象
        $startDate = date_create($request->start); // 抽奖的起始时间，在这个范围内的聊天记录才会被筛查
        $endDate = date_create($request->end);

        foreach ($records as $record) // 遍历聊天记录
        {
            $recordDate = date_create($record->time); 
            
            if (($recordDate >= $startDate) &&
                ($recordDate <= $endDate))  // 筛选存在于抽奖时间段之内的聊天记录
                {
                    if (($this->checkLabel($record, $request)) // 发言记录要包含抽奖标签
                        and ($this->checkRestrictCond($record, $request)))
                    {
                        array_push($validRecords,$record);
                    }
                }
        }
        
        // 由于可能存在重复的QQ号，设计如下逻辑：遍历validRecords，将其中的qqnumber存入validQQnumber数组，**去重**

        $validQQnumber = [];
        foreach($validRecords as $record)
        {
            if(in_array($record->qqnumber , $validQQnumber) == false)
                array_push($validQQnumber, $record->qqnumber);
        }


        $luckyDog = []; // 中奖幸运儿
        $validQQCount = count($validQQnumber); // 有资格参与抽奖的人的数量比预设中奖人数还少，就全体中奖

        if($validQQCount < $request->people_number)
        {
            $luckyDog = $validQQnumber;
            return $luckyDog;
        }
        // 如果没进上面的if分支，意味着参与抽奖的人数大于可中奖人数。
        
        for ($ii=0; $ii < $request->people_number; $ii++)
        {
            $randNum = mt_rand(0, count($validQQnumber)-1);
            array_push($luckyDog, $validQQnumber[$randNum]);
            array_splice($validQQnumber, $randNum,1);
        }
        return $luckyDog;
    }
    function checkLabel(Record $record,Request $request)
    {
        $ret = true;
        
        if (strpos(($record->label),$request->label) == FALSE){
            $ret = false;
        }
        
        return $ret;
    }

    function checkRestrictCond(Record $record,Request $request){
        return true;
    }

}

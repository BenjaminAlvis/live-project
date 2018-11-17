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
                    if ($this->checkLabel($record, $request)) // 发言记录要包含抽奖标签
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
        
        $QQnumberCount = count($validQQnumber);

        if($request->has('block')) // 屏蔽平时未发言用户
        {
            //echo "有屏蔽未发言用户";
            for($i = 0; $i < $QQnumberCount; $i++) // 对于每一个QQ
            {
                $is_Active = false;
                /* 不活跃用户定义*/
                $speakCount = Record::where('qqnumber',$validQQnumber[$i])->count();
                if ($speakCount >= 5){
                    $is_Active = true;
                }
                if($is_Active == false) // 都查看他是否最近是活跃用户
                {
                    array_splice($validQQnumber, $i, 1); // 如果不是活跃用户，就从抽奖名单中剔除
                    $QQnumberCount--;
                }
            }
        }
        
        if($request->has('filter')) // 深度过滤（根据发言频率智能屏蔽用户）
        {
            for($i = 0; $i < $QQnumberCount; $i++) // 对于每一个QQ
            {
                $is_Active = false;
                /* 不活跃用户定义：todo */
                $speakCount = Record::where('qqnumber',$validQQnumber[$i])->count();
                if ($speakCount >= 15){
                    $is_Active = true;
                }
                if($is_Active == false) // 都查看他是否最近是深度用户
                {
                    array_splice($validQQnumber, $i, 1); // 如果不是深度用户，就从抽奖名单中剔除
                    $QQnumberCount--;
                }
            }            
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

       // return $luckyDog;
        $luckyDog2['member_list'] = $luckyDog;
        return view('lottory.result', $luckyDog2);



        // return redirect()->route('draw.result', $luckyDog, $luckyDog);
    }

    public function result($luckyDog)
    {
        return view('lottory.result', $luckyDog);
    }

   
    function checkLabel(Record $record,Request $request){
        $ret = true;
        
        $requestLabels = explode(" ",$request->label); // 返回表单中填写的抽奖关键词的数组
        

        foreach ($requestLabels as $requestLabel) // 对于每一个关键词规则，
        {
            if (strpos(($record->label),$requestLabel) == FALSE){ // 都在聊天记录中查找该子串
                {
                    $ret = false; // 如果有一个没找到，就返回 false
                    break;
                }
            }
        }
        return $ret;
    }

    function checkRestrictCond(Record $record,Request $request){
        return true;
    }

}

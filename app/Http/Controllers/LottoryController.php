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

    /*
    store：抽奖表单post的后台方法
    参数：$request：http请求
    返回值：返回中奖用户id的关联数组给前台lottery.result视图
    作者：赵畅、王源
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'docs' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'release' => 'required|date|after:end',
            'people_number' => 'required',
            'award' => 'required',
        ]);

        $validRecords = [];  // 抽奖池：代表处于抽奖起始时间之内的有效聊天记录
        $records = Record::all(); // 从数据库获取所有的聊天记录，相当于 select *
        
        // date_create，是一个php函数，把格式为 YYYY-MM-DD HH:MM:SS 的字符串转换为一个datetime对象
        $startDate = date_create($request->start); // 抽奖的起始时间
        $endDate = date_create($request->end);

        foreach ($records as $record) // 遍历聊天记录
        {
            $recordDate = date_create($record->time); 
            
            if (($recordDate >= $startDate) &&
                ($recordDate <= $endDate))  // 在这个抽奖起始时间范围内的聊天记录才会被筛查
                {
                    if ($this->checkLabel($record, $request)) // 发言记录要包含抽奖标签
                    {
                        array_push($validRecords,$record);
                    }
                }
        }

        // 由于可能存在重复的QQ号，设计如下逻辑：遍历validRecords，将其中的qqnumber去重后存入validQQnumber数组，

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
            for($i = 0; $i < $QQnumberCount; $i++) // 对于每一个QQ，都查看他是否最近是活跃用户
            {
                $is_Active = false;
                
                $speakCount = Record::where('qqnumber',$validQQnumber[$i])->count();
                if ($speakCount >= 5){ /* 不活跃用户定义：发言数量大于5*/
                    $is_Active = true;
                }
                if($is_Active == false) 
                {
                    array_splice($validQQnumber, $i, 1); // 如果不是活跃用户，就从抽奖名单中剔除
                    $QQnumberCount--;
                }
            }
        }

        if($request->has('filter')) // 深度过滤（根据发言频率智能屏蔽用户）
        {
            for($i = 0; $i < $QQnumberCount; $i++) 
            {
                $is_Active = false;
                $speakCount = Record::where('qqnumber',$validQQnumber[$i])->count();
                if ($speakCount >= 15){
                    $is_Active = true;
                }
                if($is_Active == false) 
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

        $luckyDog2['member_list'] = $luckyDog; // 将luckDog数组中的内容转换成关联数组传递给结果显示视图
        $luckyDog2['docs'] = $request->docs;
        $luckyDog2['award'] = $request->award;
        $luckyDog2['people_number'] = $request->people_number;
        return view('lottory.result', $luckyDog2);
    }

    public function result($luckyDog)
    {
        return view('lottory.result', $luckyDog);
    }

   /*checkLabel：检查某天聊天记录的内容是否包含设定的抽奖标签
    参数：$record：数据库里一条聊天记录的元祖
    $request：http请求，包含表单数据 label 为设定的抽奖标签
    返回值：bool值，包含返回true，反之返回false
    作者：王源 */
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
}

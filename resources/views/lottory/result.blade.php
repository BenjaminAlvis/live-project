
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>获奖界面</title>
  <style>
  body{
    background-image:url(https://ws1.sinaimg.cn/large/005WFp6agy1fxawej2s9oj30jg0dcqa5.jpg);
    no-repeat ;
	background-size:100%;
    color:white;

  }
  .table1_1 {
    margin-left:500px;
    width:30%;
  }
  h1{
		margin-top:500px;
		margin-left:100px;
		color:yellow;
  }
  p{ color:yellow;
    margin-left:50px;
  }
  
  .table1_1,.table1_1 th,.table1_1 td
  {
      font-size: 20px;
      text-align: center;
      padding: 20px;
      border: 1px solid #ffffff;
      border-collapse: collapse;
  }


  </style>

</head>

<body>
    

	<h1>本次的中奖的幸运儿如下<br>
    
    他们将共享本次抽奖的奖品：{{$award}}<br>
    {{$docs}}
</h1>
    
	<table class=table1_1 id='table'>
      <tr>
        <th>获奖者QQ号或邮箱</th>
      </tr>
      
      <?php
        $size = count($member_list);
        //echo $size;
        for($i = 0; $i < $size; $i++)
        {
            echo '<tr>
            <td>';
            echo $member_list[$i];
            echo '</td>
          </tr>
          ';
        }
    ?>

  </table>

  <!-- <script type="text/javascript" src="{{URL::asset('js/jquery-3.3.1.js')}}"></script>
  <script>
    
    var $tr=""; 
    
    $tr = $("<tr>"+
    "<td>"+n.year+"</td>"+
    "<td>"+n.province+"</td>"+
    "</tr>");
    var $table = $('#table');
    $table.append($tr);

  </script> -->

</body>
</html>

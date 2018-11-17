

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>抽奖平台</title>
	<link rel="stylesheet" href="css/style.css">

</head>

<body>
    <h1>抽奖平台</h1>
    <div class="container">

		
              <form method="post"   action="{{ route('view.store') }}" >    <!-- 看这里看这里！！！！ -->
            	 {{ csrf_field() }}
     

					<span>关键词标签：</span>
					<input type="text" name="lable" class="text">

					<span>抽奖人数：</span>
					<input type="text" name="people_number" class="text" >

					<span>奖品列表：</span>
					<input type="text" name="list" class="text">

					<span>抽奖文案：</span>
					<input type="text" name="activity" class="text" >

			  	<span>开始时间:</span> <input type="datetime-local" step="01" class="time" name="start"/>

					<span>截止时间:</span> <input type="datetime-local" step="01" class="time" name="end"/>

					<span>公布时间:</span> <input type="datetime-local" step="01" class="time" name="release"/>

					<div class="check">

					  过滤选项：
						<label><input name="silence" class="checkbox" type="checkbox" value="" />平时未发言 </label>

						<label><input name="nonshort"  class="checkbox" type="checkbox" value="" />发言长度 </label>
					</div>
				<div>
						<input type="submit" class="submit" onclick="" value="查看抽奖结果">
				</div>

		</form>

	</div>
	<div class="footer">
		<p> &copy; 2018  爸爸饿了战队</p>
	</div>
</body>
</html>

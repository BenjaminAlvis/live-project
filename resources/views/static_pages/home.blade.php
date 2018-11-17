@extends('layouts.default')
@section('content')
<div class="jumbotron">
    <h1>你好，旅行者</h1>
    <p class="lead">
      这里是<a href="https://edu.cnblogs.com/campus/fzu/Grade2016SE/homework/2397">福大软工1816 · 团队现场编程实战</a>的抽奖系统项目主页
    </p>
    <p>
      请按“开始抽奖”按钮开始填写抽奖规则
    </p>
    <p>
      <a class="btn btn-lg btn-success" href="{{route('signup')}}" role="button">开始抽奖</a>
    </p>
  </div>
@stop
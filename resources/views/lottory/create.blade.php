@extends('layouts.default')
@section('title', '抽奖规则填写')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>抽奖规则填写</h5>
    </div>
    <div class="panel-body">
      @include('shared._errors')

      <form method="POST" action="{{ route('draw.store') }}">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="label">抽奖关键词：</label>
            <input type="text" name="label" class="form-control" placeholder="头尾用#包围，多个关键词之间用空格分隔" value="{{ old('label') }}">
          </div>

          <div class="form-group">
            <label for="docs">文案：</label>
            <input type="text" name="docs" class="form-control" placeholder="请在这里填写活动宣言" value="{{ old('docs') }}">
          </div>

          <div class="form-group">
            <label for="start">开始时段：</label>
            <input type="text" name="start" class="form-control" placeholder="格式为: YYYY-MM-DD hh:mm:ss" value="{{ old('start') }}">
          </div>

          <div class="form-group">
            <label for="end">结束时段：</label>
            <input type="text" name="end" class="form-control" placeholder="格式为: YYYY-MM-DD hh:mm:ss" value="{{ old('end') }}">
          </div>

          <div class="form-group">
            <label for="release">公布时间：</label>
            <input type="text" name="release" class="form-control" placeholder="格式为: YYYY-MM-DD hh:mm:ss" value="{{ old('release') }}">
          </div>

          <div class="form-group">
            <label for="people_number">获奖人数：</label>
            <input type="text" name="people_number" class="form-control" placeholder="请在这里填写获奖人数，必须是正整数" value="{{ old('people_number') }}">
          </div>

          <div class="checkbox">
            <label><input type="checkbox" name="block"> 屏蔽平时未发言的用户 </label>
          </div>

          <div class="checkbox">
            <label><input type="checkbox" name="filter"> 深度过滤（根据发言频率智能屏蔽用户） </label>
          </div>

          <div class="form-group">
            <label for="award">奖品：</label>
            <input  placeholder="请在这里填写奖品" type="text" name="award" class="form-control" value="{{ old('people_number') }}">
          </div>

          <button type="submit" class="btn btn-primary">提交</button>
      </form>
    </div>
  </div>
</div>
@stop
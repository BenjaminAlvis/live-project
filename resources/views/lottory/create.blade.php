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
            <input type="text" name="label" class="form-control" value="{{ old('label') }}">
          </div>

          <div class="form-group">
            <label for="docs">文案：</label>
            <input type="text" name="docs" class="form-control" value="{{ old('docs') }}">
          </div>

          <div class="form-group">
            <label for="start">开始时段：</label>
            <input type="text" name="start" class="form-control" value="{{ old('start') }}">
          </div>

          <div class="form-group">
            <label for="end">结束时段：</label>
            <input type="text" name="end" class="form-control" value="{{ old('end') }}">
          </div>

          <div class="form-group">
            <label for="release">公布时间：</label>
            <input type="text" name="release" class="form-control" value="{{ old('release') }}">
          </div>

          <div class="form-group">
            <label for="people_number">获奖人数：</label>
            <input type="text" name="people_number" class="form-control" value="{{ old('people_number') }}">
          </div>

          <div class="form-group">
            <label for="award">奖品：</label>
            <input type="text" name="award" class="form-control" value="{{ old('people_number') }}">
          </div>

          <button type="submit" class="btn btn-primary">提交</button>
      </form>
    </div>
  </div>
</div>
@stop
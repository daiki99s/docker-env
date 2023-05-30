@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
      <div class="d-flex justify-content-center">
        <h3>
        {{$user_name}}
        </h3>
      </div>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">報告内容</th>
              <th scope="col">通報日時</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reports as $report)
            <tr>
              <td>{{$report->reason}}</td>
              <td>{{$report->created_at}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
    </div>
</div>
@endsection

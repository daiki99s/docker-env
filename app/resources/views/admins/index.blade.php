@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="d-flex">
            <div class="d-flex">
              <h3>ユーザー総数：</h3>
              <h3>{{$user_count}}</h3>
            </div>
            <div class="col-1"></div>
            <div class="d-flex">
              <h3>投稿総数：</h3>
              <h3>{{$post_count}}</h3>
            </div>
          </div>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">違反件数</th>
              <th scope="col">ユーザーネーム</th>
              <th scope="col">作成日時</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td><a href="{{route('admin.show', $user->id)}}">#</a></td>
              <td>{{$user->reports_count}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->created_at}}</td>
              <td><a href="{{route('admin.delete', $user->id)}}">削除</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>

        </div>
    </div>
</div>
@endsection

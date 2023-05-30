@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        <form action="{{route('post.update', $post->id)}}" method="POST">
        @csrf
        @method('patch')
            <div class="form-group">
                <label for="description">説明文</label>
                @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <textarea name="description" id="description" class="form-control" rows="5" placeholder="本文を入力してください">{{old('description') ?? $post->description}}</textarea>
            </div>
            <input type="submit" value="決定" class="btn btn-primary">
            <input type="reset" value="キャンセル" class="btn btn-secondary" onclick='window.history.back(-1);'>
        </form>

        </div>
    </div>
</div>
@endsection

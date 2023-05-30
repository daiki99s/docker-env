@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @error('reason')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
            <form action="{{route('user.report', $id)}}" method="post">
            @csrf
           
                <div class="form-group btn-primary d-flex">
                    <div class="col-9">
                        <div class="form-group">
                            <label for="reason">報告内容</label>
                            <textarea name="reason" id="reason" class="form-control" rows="5" placeholder="本文を入力してください">{{old('reason')}}</textarea>
                        </div>
                    </div>
                </div>

                <input type="submit" value="決定" class="btn btn-primary">
                <input type="reset" value="キャンセル" class="btn btn-secondary" onclick='window.history.back(-1);'>
            </form>

        </div>
    </div>
</div>
@endsection

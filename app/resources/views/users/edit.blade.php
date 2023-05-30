<style>

.select-profile-bgp {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    border: none;
    cursor: pointer;
    opacity: 0;
}
.select-profile-bgp:hover {
    opacity: .5;
}

.select-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    border: none;
    cursor: pointer;
    opacity: 0;
}

.select-icon:hover {
    opacity: .5;
}
</style>
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{route('user.update', $user->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <!-- profile_background_picture -->
                <div class="form-group" style="height: 40vh; position: relative;">
                    <!-- <label for="profile_bgp">プロファイルピクチャー</label> -->
                    <input type="file" name="profile_bgp" class="select-profile-bgp" accept="image/jpeg, image/png" >
                    <img src="{{ asset('storage/'.$user->profile_bgp) }}" style="width:100%; height:100%; object-fit:cover;" alt="">
                </div>
            <!-- profile_background_picture -->
                <div class="form-group d-flex">
                    <div class="col-3">
                        <div style="height: 10.7vw; width: 10.7vw; border-radius:50%;">
                            <input type="file" name="icon" class="select-icon" accept="image/jpeg, image/png">
                            <img src="{{ asset('storage/'.$user->icon) }}" class="rounded-circle" style="height: 100%; width: 100%; object-fit:cover;" alt="">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-group">
                            <label for="name">user name</label>
                            @error('name')
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                            <input type="text" name="name" id="name" class="form-control" value="{{old('name') ?? $user->name}}" placeholder="ユーザーネームを入力してください">
                        </div>
                        <div class="form-group">
                            <label for="bio">説明文</label>
                            <textarea name="bio" id="bio" class="form-control" rows="5" placeholder="本文を入力してください">{{old('bio') ?? $user->bio}}</textarea>
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

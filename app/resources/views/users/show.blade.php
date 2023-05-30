@extends('layouts.app')

@section('content')

        <div class="container-fluid">
            <div class="row">

 <!-- side navigarion bar -->
 <div class="col-3 d-flex justify-content-center border-right">
      <div class="sidebar position-fixed">
        <ul class="nav nav-sidebar flex-column align-items-center">
      <!-- search form -->
          <form style="max-width:20vw"; action="{{ route('post.index') }}" method="get">
            <div class="input-group">
              <div class="input-group-btn">
                <button class="btn btn-default btn-primary" style="height:100%;" type="submit">
                <i class="fas fa-search"></i>
              </div>
              <input type="search" name="search" value="@if (isset($search)) {{ $search }} @endif" class="form-control" placeholder="Search" id="searchWord">
            </div>
          </form>
      <!-- search form end -->
          <li class="mt-3 mb-3"><a href="{{route('post.index')}}">HOME</a></li>
          <li class="mt-3 mb-3"><a href="{{ route('user.show', Auth::id()) }}">プロファイル</a></li>
      <!-- Open the Modal -->
          <li class="mt-3 mb-3" style="color: #3490dc;" data-toggle="modal" data-target="#postModal">投稿</li>
          <li class="mt-3 mb-3"><a href="{{route('user.index')}}">いいね一覧</a></li>
        </ul>
      </div>
    </div>
  <!-- side navigarion bar end -->

                <div class="col-8">
                    <div class="row position-relative d-flex justify-content-center" style="height: 40vw;">
                        <img src="{{ asset('storage/'.$user->profile_bgp) }}" style="width:100%; object-fit:cover;" alt="">
                    </div>
                    <div class="row position-relative" style="height: 25vw;">
                    <!-- icon -->
                        <div class="position-absolute" style="height: 15vw; width:15vw; border-radius:50%; top: -7vw; left: 25vw; z-index:1;">
                        <img src="{{ asset('storage/'.$user->icon) }}" class="rounded-circle" style="height: 100%; width: 100%; object-fit: cover;" alt="">
                        </div>
                    <!-- icon end -->
                        <div class="col-12 position-relative p-0" style="background-color: white;">
                            <div class="row justify-content-around">
                                <p class="col-1">{{$user->name}}</p>
                                @if($user->id != Auth::id())
                                    @if($followed_id != $user->id)
                                    <form action="{{route('follow.create')}}" method="POST" class="col-1">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <button type="submit">
                                        follow
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{route('follow.destroy')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                        <button type="submit">
                                        unfollow
                                        </button>
                                    </form>
                                    @endif 
                                @else
                                <form action="{{route('user.edit', $user->id)}}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <button type="submit">
                                        編集
                                    </button>
                                </form>
                                @endif 
                            </div>
                        </div> 
                        <div class="col-12 p-0 d-flex align-items-center" style="background-color: white;"> 
                            <p class="">{{$user->bio}}</p>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-12 border d-flex justify-content-center" style="height: 2vw; background-color:white;">フィード</div>
                        <div class="col-12 border">
                                <div class="row d-flex">
                                    @foreach ($posts as $post)
                                    <div class="col-4 p-0">
                                        <a href="{{route('post.show', $post->id)}}">
                                        <img src="{{ asset('storage/'.$post->image) }}" usemap="#workmap" style="width: 22.13vw; height: 22.13vw; object-fit: cover;" alt="">
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                        </div>



                    </div>

    <!-- Modal -->
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalTitle" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
<div id="validationErrors" class="alert alert-danger" style="display: none;"></div>
            <div class="modal-content" id="modal-frame">
                <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                  <div class="modal-body">
                    <div class="container">
                    
                      <div class="row">
                          <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                              <div>
                                <img src="{{ asset('storage/'.Auth::user()->icon) }}" id="modal-icon" class="rounded-circle" alt="User Icon">
                              </div>
                              <h4 class="mt-3">{{ Auth::user()->name }}</h4>
                              <div class="just-a-line border-bottom"></div>
                              <textarea name="description" id="modal-description" cols="30" rows="10" class="mt-3 border-0" placeholder="write a description"></textarea>
                          </div>
                          <div class="col-8 d-flex justify-content-center align-items-center">
                            <input type="file" name="image" accept="image/jpeg, image/png">
                          </div>
                      </div>
                    </div>
                  </div>
                <!-- post and close buttons -->
                  <div class="modal-footer d-flex justify-content-start">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Post</button>
                  </div>
                </form>
            </div>
          </div>
        </div>
    <!-- Modal end -->


                </div>

            </div>
        </div>

@endsection



<!-- like feature -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(function () {
var like = $('.js-like-toggle');
var likePostId;

like.on('click', function () {
    var $this = $(this);
    likePostId = $this.data('postid');
    $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/ajaxlike',  //routeの記述
            type: 'POST', //受け取り方法の記述（GETもある）
            data: {
                'post_id': likePostId //コントローラーに渡すパラメーター
            },
    })

        // Ajaxリクエストが成功した場合
        .done(function (data) {
//lovedクラスを追加
            $this.toggleClass('loved'); 

//.likesCountの次の要素のhtmlを「data.postLikesCount」の値に書き換える
            $this.next('.likesCount').html(data.postLikesCount); 

        })
        // Ajaxリクエストが失敗した場合
        .fail(function (data, xhr, err) {
//ここの処理はエラーが出た時にエラー内容をわかるようにしておく。
//とりあえず下記のように記述しておけばエラー内容が詳しくわかります。笑
            console.log('エラー');
            console.log(err);
            console.log(xhr);
        });
    
    return false;
});
});

    $(document).ready(function() {
        $('#postModal form').submit(function(e) {
            e.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var formData = new FormData(form[0]);
            
            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // バリデーション成功時の処理
                    // モーダルダイアログを閉じたり、成功メッセージを表示したりする
                    
                    // 例えば、成功時にモーダルを閉じる場合は以下のようにします
                    $('#postModal').modal('hide');
                },
                error: function(response) {
                    // バリデーションエラー時の処理
                    if (response.status === 422) {
                        var errors = response.responseJSON.errors;
                        var errorMessages = '';

                        $.each(errors, function(field, messages) {
                            errorMessages += '<p>' + messages.join(', ') + '</p>';
                        });

                        $('#validationErrors').html(errorMessages);
                        $('#validationErrors').show();
                    }
                }
            });
        });
    });
</script>

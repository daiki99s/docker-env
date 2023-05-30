<!-- Home Screen -->


<script defer>
function search() {
  // Get value from the input element
  let searchWord = document.getElementById("searchWord").value;

  // 入力が空白の場合は display:none を解除して全要素を表示する
  if (!searchWord) {
    let posts = document.getElementsByClassName('posts');
    let quantity = posts.length;
    for (let i = 0; i < quantity; i++) {
      posts[i].style.display = ""; // デフォルトの表示設定に戻す
    }
    return;
  }

  // 全要素取得
  let descriptions = document.getElementsByClassName('descriptions');
  let quantity = descriptions.length;
  console.log(descriptions.length);

  const keyword = searchWord ? searchWord.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') : null;
  const flags = "i"; // フラグ（オプション）
  const regex = keyword ? new RegExp(keyword, flags) : null;

  for (let i = 0; i < quantity; i++) {
    let description = descriptions[i].textContent;
    console.log(description);

    const isMatch = regex ? regex.test(description) : false;
    console.log(isMatch); // true or false

    let posts = document.getElementsByClassName('posts');

    if (!isMatch) {
      posts[i].style.display = "none";
    } else {
      posts[i].style.display = ""; // デフォルトの表示設定に戻す場合は "" を指定
    }
  }
}

</script>


@extends('layouts.app')

@section('content')




<div class="container-fluid">
  <div class="row">
  <!-- side navigarion bar -->
    <div class="col-3 d-flex justify-content-center border-right">
      <div class="sidebar position-fixed">
        <ul class="nav nav-sidebar flex-column align-items-center">
     <!-- search form -->
     <form style="max-width:20vw";>
            <div class="input-group">
              <div class="input-group-btn">
                <input type="text" name="prevent_submitting" style="display:none;">
                <button class="btn btn-default btn-primary" style="height:100%;" type="button" onclick="search()">
                <i class="fas fa-search"></i>
              </div>
              <input type="text" class="form-control" placeholder="Search" id="searchWord" oninput="search()">
              <!-- <input type="reset" class="fas fa-backspace"> -->
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

    <div class="col-8 p-0">
    @foreach($posts as $post)
      <div class="container post-card posts">
        <div class="row border-top border-right border-bottom post-frame">
          <div class="col-4 post-content post-left p-0 d-flex flex-column justify-content-center align-items-center" style="background-color: white; border-radius: 1.428vw 0px 0px 1.428vw;
">
          <!-- jump to the user profile -->
              <div>
                <img src="{{ asset('storage/'.$post->icon) }}" usemap="#workmap" class="rounded-circle object-fit-cover posts-icon" alt="icon">
                <map name="workmap">
                  <area shape="circle" coords="34,44,270,350" alt="Computer" href="{{route('user.show',$post->user_id)}}">
                </map>
              </div>
          <!-- jump to the user profile end -->
            <h4 class="mt-3">
              <a href="{{route('user.show',$post->user_id)}}">
              {{$post->name}}
              </a>
            </h4>
            <div class="just-a-line border-bottom"></div>
            <a href="{{route('post.show', $post->id)}}">
              <p class="descriptions mt-3">
              {{$post->description}}
              </p>
            </a>
          </div>
          <div class="col-8 post-left p-0">
            <a href="{{route('post.show', $post->id)}}" class="d-block">
              <img src="{{ asset('storage/'.$post->image) }}" class="object-fit-cover post-img" alt="">
            </a>
          </div>
        </div>
        
      </div>



    @endforeach

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

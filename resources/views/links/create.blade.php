@extends('layouts.master')

@section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Tạo link Spam - 1 link chỉ nên đăng 1 nick</h1>
    </div>
    <div class="panel-body">
        <form method="POST" action="/">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="fake_link">Link giả: (Dùng link không có dấu sét trên điện thoại)</label>
                <input type="text" class="form-control" name="fake_link" id="fake_link" value="{{ old('fake_link') }}">
            </div>

            <div class="form-group">
                <label for="real_link">Link đích:</label>
                <input type="text" class="form-control" name="real_link" id="real_link" value="{{ old('real_link') }}">
            </div>

            <div class="form-group">
                <label for="title">Tiêu đề: (Để trống nếu không dùng)</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" placeholder="Hết mụn trong 4 ngày">
            </div>

            <div class="form-group">
                <label for="description">Dưới tiêu đề: (Để trống nếu không dùng)</label>
                <input type="text" class="form-control" name="description" id="description" value="{{ old('description') }}" placeholder="Chỉ dùng vỏ chuối thôi không cần bất kỳ gì khác mà hết mụn trong 4 ngày đó hay không? Nguyên liệu: Vỏ chuối (trời ơi nó còn tầm thường và rẻ tiền hơn là">
            </div>

            <div class="form-group">
                <label for="image">Link ảnh: (Để trống nếu không dùng)</label>
                <input type="text" class="form-control" name="image" id="image" value="{{ old('image') }}" placeholder="http://www.webtretho.com/contentreview/wp-content/uploads/sites/53/2015/11/banana-peels-acne-treatment-317x1024.png">
            </div>

            <div class="form-group">
                <label for="website">Địa chỉ web giả: (Để trống nếu không dùng)</label>
                <input type="text" class="form-control" name="website" id="website" value="{{ old('website') }}" placeholder="webtretho.vn">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Tạo link</button>
            </div>

            <div class="form-group">
                @include('layouts.errors')
            </div>
        </form>

         @if (session()->has('link'))
            <div class="form-group">
                <hr>
                <button class="btn btn-primary" onclick="copyToClipboard('#result-link')">Copy link thường</button><br>
                <a id="result-link" href="{{ session()->get('link')->full_link }}">{{ session()->get('link')->full_link }}</a><br>
            </div>
         @endif
         @if (session()->has('lin'))
            <div class="form-group">
                <hr>
                <button class="btn btn-primary" onclick="copyToClipboard('#result-lin')">Copy link chỉnh sửa</button><br>
                <a id="result-lin" href="{{ session()->get('lin') }}">{{ session()->get('lin') }}</a><br>
            </div>
        @endif

    </div>
@endsection

<script>
    function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
    }

    function copyFakeLink() {
        var title = $('#title').val();
        var description = $('#description').val();
        var image = $('#image').val();
        var web = $('#web').val();
        var realLink = $('#result-link').val();

        var link = 'https://www.facebook.com/sharer/sharer.php?&u=' + realLink + '&caption=' + web + '&title=' + title + '&description=' + description + '&picture=' + image;

        var dummy = document.createElement("input");
      document.body.appendChild(dummy);
      $(dummy).css('display','none');
      dummy.setAttribute("id", "dummy_id");
      document.getElementById("dummy_id").value=link;
      dummy.select();
      document.execCommand("copy");
      document.body.removeChild(dummy);
    }
</script>


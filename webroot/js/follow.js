function follow() {
  // when #tweet_button is clicked
  $(document).on('click', 'img.fbutton', function () {
      var [toggle, id] = $(this).attr('id').split(':');
      if (toggle == 'addfollow') {
        addfollow(id);
      } else if (toggle == 'unfollow') {
        unfollow(id);
      }
  });
}

function addfollow(id) {
  if (window.confirm('フォローに追加しますか？')) {
    $.ajax({
      url: '/follows/addFollow/' + id,
      success: function() {
        $('img#addfollow:' + id).attr({
          'id': 'unfollow:' + id,
          'src': '/img/hide-16.png',
          'alt': 'フォロー解除',
          'title': 'フォロー解除'
        });
        location.reload();
      },
      error: function() {
        alert("フォローへの追加に失敗しました。");
      }
    });
  } else {
    alert('キャンセルされました');
  }
}

function unfollow(id) {
  if (window.confirm('フォロー解除しますか？')) {
    $.ajax({
      url: '/follows/unfollow/' + id,
      success: function() {
        $('img#unfollow:' + id).attr({
          'id': 'addfollow:' + id,
          'src': '/img/plus-16.png',
          'alt': 'フォロー追加',
          'title': 'フォロー追加'
        });
        location.reload();
      },
      error: function() {
        alert("フォローの解除に失敗しました。");
      }
    });
  } else {
    alert('キャンセルされました');
  }
}


$(follow);

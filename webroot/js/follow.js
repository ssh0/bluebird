function follow() {
  // when #tweet_button is clicked
  $(document).on('click', 'i.fbutton', function () {
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
        $('i#addfollow:' + id).attr({
          'id': 'unfollow:' + id,
          'class': 'fa fa-bell-slash-o fbutton'
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
        $('i#unfollow:' + id).attr({
          'id': 'addfollow:' + id,
          'class': 'fa fa-user-plus fbutton'
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

$(removeTweet);

function removeTweet() {
  // when div.tweet-removebutton is clicked
  $(document).on('click', 'div.tweet-removebutton', function () {
    if (window.confirm('このツイートを削除してよろしいですか？')) {
      var tweet_id = $(this).parents('div.tweet').attr('id');
      $('div.tweet[id=' + tweet_id + ']').children('div.tweet-removebutton').children('i').attr({
        'class': 'fa fa-spinner fa-spin'
      });
      $.ajax({
        url: '/tweets/ajaxRemove/' + tweet_id,
        success: function() {
          $('div.tweet[id=' + tweet_id + ']').remove();

          var tweets_num = parseInt($('#profile-tweets-num').children('a').text());
          $('#profile-tweets-num').children('a').text(tweets_num - 1);
        },
        error: function() {
          alert("ツイートの削除に失敗しました。");
          $('div.tweet[id=' + tweet_id + ']').children('div.tweet-removebutton').children('i').attr({
            'class': 'fa fa-trash-o'
          });
        }
      });
    } else {
      alert('キャンセルされました');
    }
  });
}


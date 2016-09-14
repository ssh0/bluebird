function follow() {
  // when #tweet_button is clicked
  $(document).on('click', 'div.follow-button', function () {
      var toggle = $(this).children('img').attr('class');
      var follow_id = $(this).parents('div.follow').attr('id');
      if (toggle == 'addfollow') {
        if (window.confirm('フォローに追加しますか？')) {
        alert(toggle + follow_id);
        }
      } else if (toggle == 'unfollow') {
        if (window.confirm('フォロー解除しますか？')) {
        alert(toggle + follow_id);
        }
      }
    // $('follow_button').attr('disabled', true);
    // $.ajax({
    //   url: '/tweets/ajaxPost',
    //   type: 'POST',
    //   data: { content: $('follow [name=content]').val() },
    //   success: function(result) {
    //     $('#tweet_button').attr('disabled', false);
    //     $('textarea').val('');
    //     acceptNewTweets_();

    //     var tweets_num = parseInt($('#profile-tweets-num').children('a').text());
    //     $('#profile-tweets-num').children('a').text(tweets_num + 1);
    //   },
    //   error: function() {
    //     $('#tweet_button').attr('disabled', false);
    //     $('textarea').val('');
    //     alert("error");
    //   }
    // });
  });
}


$(follow);

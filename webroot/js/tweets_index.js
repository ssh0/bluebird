function postTweet() {
  // when #tweet_button is clicked
  $(document).on('click', '#tweet_button', function () {

    $('#tweet_button').attr('disabled', true);
    $.ajax({
      url: '/tweets/ajaxPost',
      type: 'POST',
      data: { content: $('#tweet_form [name=content]').val() },
      success: function(result) {
        $('#tweet_button').attr('disabled', false);
        $('textarea').val('');
        acceptNewTweets_();

        var tweets_num = parseInt($('#profile-tweets-num').children('a').text());
        $('#profile-tweets-num').children('a').text(tweets_num + 1);
      },
      error: function() {
        $('#tweet_button').attr('disabled', false);
        $('textarea').val('');
        alert("error");
      }
    });
  });
}


function acceptNewTweets() {
  // Update each 13 seconds
  var interval_time_ms = 13000;
  setInterval(acceptNewTweets_, interval_time_ms);
}


function acceptNewTweets_() {
  var latest_id = $('div.tweet').first().attr('id');
  $.ajax({
    url: '/tweets/ajaxRecieveNewTweets/' + latest_id,
    type: 'POST',
    success: function(result) {
      $('div.tweets').prepend(result);
    },
    error: function() {
      alert("Connection error");
    }
  });

}


function syncAllTweets() {
  // Update each 37 seconds
  var interval_time_ms = 37000;
  setInterval(syncAllTweets_, interval_time_ms);
}

function syncAllTweets_() {
  var oldest_id = $('div.tweet').last().attr('id');
  var latest_id = $('div.tweet').first().attr('id');
  var tweets_in_view = $('div.tweet').length;
  $.ajax({
    url: '/tweets/ajaxSyncAllTweets/' 
      + oldest_id + '/'
      + latest_id + '/'
      + tweets_in_view,
    type: 'POST',
    success: function(result) {
      if (result !== '') {
        $('div.tweets').html(result);
      }
    },
    error: function() {
      alert("Connection error");
    }
  });
}


function lazyLoad() {
  var win = $(window);

  win.scroll(function() {
    // Reached to end of the document?
    if ($(document).height() - win.height() == win.scrollTop()) {
      $('#loading').show();

      $.ajax({
        url: '/tweets/ajaxLoadTweets/' + $('div.tweet').last().attr('id'),
        success: function(result) {
          if (result !== '') {
            $('div.tweets').append(result);
          } else {
            $('#content_end_message').show();
          }

            $('#loading').hide();
        },
        error: function() {
          alert("Connection error");
        }
      });
    }
  });
}

$(postTweet);
$(acceptNewTweets);
$(syncAllTweets);
$(lazyLoad);

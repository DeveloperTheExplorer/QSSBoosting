var open = false;
var soloDuo, yourRank, yourDiv, boostType, wishRank, wishDiv, numOfGames, rankFrom, rankTo, currentRank, currentDiv, menu, scrolled, server;
var numOfGames = 4;
var winPrice, divPrice = 0;
var prices = [8, 8, 8, 8, 10, 10, 10, 10, 13, 15, 17, 20, 22, 24, 27, 32, 34, 36, 38, 45, 85, 100, 175, 275];
var wins = [3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 6, 6, 6, 6, 8, 8, 8, 8, 12, 16, 20,  25];
var duo = 1.5;
$(function() {
  $('a').on('click', function() {
    if($(this).attr('href') == '#')
      return false
  })

  $(".config.popup").on('click', function() {
    menu = $(this).attr('data-display');
    if($(this).parent().attr('data-tooltip') != null || $(this).hasClass('disabled'))
     return
    if(!open) {
      $('#'+menu).fadeIn(300)
      $('body').css('overflow-y', 'hidden')
      $('.blurred').addClass('activated')
      open = true;
    }
  });

  $(".exit").on('click', function() {
    $(this).parent().fadeOut(300, function(){
      open = false;
    });
    $('body').css('overflow-y', 'initial');
    $('.blurred').removeClass('activated')
  });

  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 54)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  $(".option").on('click', function() {
    if($(this).parent().parent().attr('id') == 'SoloDuo') {
      soloDuo = $(this).attr('data-option');
      if(boostType != null) {
        if(boostType == 'win') {
          if(soloDuo == "Duo")
            winPrice = winPrice * 1.5
          else {
            winPrice = numOfGames * wins[(currentRank * 4) + currentDiv];
          }
            $('.price').html('Total Price: $' + winPrice);
        } else if(boostType == 'div') {
          if(soloDuo == "Duo") {
            divPrice = divPrice * 1.5
          } else {
            divPrice = 0;
            for (var i = rankFrom; i < rankTo; i++) {
              divPrice += prices[i];
            }
          }
          $('.price').html('Total Price: $' + divPrice);
        }
      }
    } else if($(this).parent().parent().attr('id') == 'YourDiv') {
      yourDiv = $(this).attr('data-option');
      currentDiv = parseInt($(this).attr('data-boostVal'));
      rankFrom += currentDiv;
      if(wishDiv != null && rankTo > rankFrom) {
        divPrice = 0;
        for (var i = rankFrom; i < rankTo; i++) {
          divPrice += prices[i];
        }
        if(soloDuo == "Duo")
          divPrice = divPrice * 1.5
        $('.price').html('Total Price: $' + divPrice);
      }
    } else if($(this).parent().parent().attr('id') == 'BoostType') {
      boostType = $(this).attr('data-option');
    } else if($(this).parent().parent().attr('id') == 'WishDiv') {
      wishDiv = $(this).attr('data-option');
      rankTo += parseInt($(this).attr('data-boostVal'));
      divPrice = 0;
      if(rankFrom < rankTo) {
        for (var i = rankFrom; i < rankTo; i++) {
          divPrice += prices[i];
        }
        if(soloDuo == "Duo")
          divPrice = divPrice * 1.5
        $('.price').html('Total Price: $' + divPrice);
      }
    }


    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    if($(this).parent().parent().attr('id') == 'YourRank') {
      $(this).parent().parent().fadeOut(300, function() {
        open = false;
      })
      yourRank = $(this).attr('data-option');
      currentRank = parseInt($(this).attr('data-boostVal'));
      rankFrom = currentRank * 4;
      $('#YourDiv').fadeIn(300);
      open = true;
      $('body').css('overflow-y', 'hidden');
    } else if($(this).parent().parent().attr('id') == 'WishRank') {
      $(this).parent().parent().fadeOut(300, function() {
        open = false;
      })
      wishRank = $(this).attr('data-option');
      rankTo = $(this).attr('data-boostVal') * 4;
      $('#WishDiv').fadeIn(300);
      open = true;
      $('body').css('overflow-y', 'hidden');
    } else {
      $(this).parent().parent().fadeOut(300, function() {
        open = false;
        $('body').css('overflow-y', 'initial');
        $('.blurred').removeClass('activated')
      });
    }



    if(soloDuo != null) {
      if(soloDuo == "Solo") {
        $('.SoloDuo').html('<span><i class="fas fa-user"></i></span><h2 class="txt-center"> Selected: Solo</h2>');
      } else if(soloDuo == "Duo") {
        $('.SoloDuo').html('<span><i class="fas fa-user-friends"></i></span><h2 class="txt-center"> Selected: Duo</h2>');
      }
    }
    if(yourRank != null) {
      $('.YourRank').html('<img class="rankImg" src="assets/img/ranks/'+yourRank+'.png"/><h2 class="txt-center">Your Rank</h2>');
    }
    if(yourDiv != null) {
      $('.YourRank').prepend('<div class="selectedDiv">'+yourDiv+'</div>');
      if(boostType != null) {
        if(boostType == 'win') {
          winPrice = numOfGames * wins[(currentRank * 4) + currentDiv];
          if(soloDuo == "Duo")
            winPrice = winPrice * 1.5
          $('.price').html('Total Price: $' + winPrice);
        }
      }
    }
    if(wishRank != null) {
      $('.WishRank').html('<img class="rankImg" src="assets/img/ranks/'+wishRank+'.png"/><h2 class="txt-center">Your Rank</h2>');
    }
    if(wishDiv != null) {
      $('.WishRank').prepend('<div class="selectedDiv">'+wishDiv+'</div>');
    }
    if(boostType != null) {
      if(boostType == 'win') {
        $('.wishRank').fadeOut(300, function() {
          $('.numOfGames').fadeIn(300);
        });
        $('.BoostType').html('<span><i class="fas fa-plus"></i></span><h2 class="txt-center"> Selected: Net Wins</h2>');
        winPrice = numOfGames * wins[(currentRank * 4) + currentDiv];
        if(soloDuo == "Duo")
          winPrice = winPrice * 1.5
        $('.price').html('Total Price: $' + winPrice);
        console.log("Price is: $" + winPrice);
      } else if(boostType == 'div') {
        $('.numOfGames').fadeOut(300, function() {
          $('.wishRank').fadeIn(300);
        });
        $('.BoostType').html('<span><i class="fas fa-plus"></i></span><h2 class="txt-center"> Selected: Division Boost</h2>');
      }
    }


    if(!open) {
      $('body').css('overflow-y', 'initial');
      $('.blurred').removeClass('activated')
    }
    console.log('Open: ' +open)
  });

  $('.wininput').keyup(function() {
    numOfGames = $('.wininput').val();
    winPrice = numOfGames * wins[(currentRank * 4) + currentDiv];
    if(soloDuo == "Duo")
    winPrice = winPrice * 1.5
    if(winPrice < 0)
    winPrice = null
    else
    $('.price').html('Total Price: $' + winPrice);
  })
  $('.winbtn.plus').on('click', function() {
    numOfGames = $('.wininput').val();
    numOfGames++;
    $('.wininput').val(numOfGames);
    winPrice = numOfGames * wins[(currentRank * 4) + currentDiv];
    if(soloDuo == "Duo")
      winPrice = winPrice * 1.5
    if(winPrice < 0)
      winPrice = null
    else
      $('.price').html('Total Price: $' + winPrice);
  });
  $('.winbtn.minus').on('click', function() {
    numOfGames = $('.wininput').val();
    if (numOfGames > 0) {
      numOfGames--;
    }
    $('.wininput').val(numOfGames);
    winPrice = numOfGames * wins[(currentRank * 4) + currentDiv];
    if(soloDuo == "Duo")
      winPrice = winPrice * 1.5
    if(winPrice < 0)
      winPrice = null
    else
      $('.price').html('Total Price: $' + winPrice);
  });


  // FOOTER
  function scroll() {
    scrolled = $(window).scrollTop();
    if(scrolled > $('.full-screen-back').height())
      $('footer').addClass('active');
    else
      $('footer').removeClass('active');
  }
  $(window).scroll(function() {
    scroll();
  });
  scroll();


});




// SELECTION
$('select').each(function(){
    var $this = $(this), numberOfOptions = $(this).children('option').length;

    $this.addClass('select-hidden');
    $this.wrap('<div class="select"></div>');
    $this.after('<div class="select-styled"></div>');

    var $styledSelect = $this.next('div.select-styled');
    $styledSelect.text($this.children('option').eq(0).text());

    var $list = $('<ul />', {
        'class': 'select-options'
    }).insertAfter($styledSelect);

    for (var i = 0; i < numberOfOptions; i++) {
        $('<li />', {
            text: $this.children('option').eq(i).text(),
            rel: $this.children('option').eq(i).val()
        }).appendTo($list);
    }

    var $listItems = $list.children('li');

    $styledSelect.click(function(e) {
        e.stopPropagation();
        $('#quePurchase').parent().css('z-index', '-1')
        $('div.select-styled.active').not(this).each(function(){
            $(this).removeClass('active').next('ul.select-options').hide();
            $('#quePurchase').parent().css('z-index', '0')
        });
        $(this).toggleClass('active').next('ul.select-options').toggle();
    });

    $listItems.click(function(e) {
        e.stopPropagation();
        $('#quePurchase').parent().css('z-index', '0')
        $styledSelect.text($(this).text()).removeClass('active');
        $this.val($(this).attr('rel'));
        $list.hide();
        server = $this.val();
        $('#quePurchase').parent().removeAttr('data-tooltip')
        // console.log($this.val());
    });

    $(document).click(function() {
      $('#quePurchase').parent().css('z-index', '0')
        $styledSelect.removeClass('active');
        $list.hide();
      if(winPrice > 0 || divPrice > 0) {
        $('#quePurchase').removeClass('disabled')
        document.getElementById('quePurchase').disabled = false
        if (soloDuo == 'Duo') {
          $('.soloRequired').hide();
          $('.duoRequired').show();
        } else {
          $('.soloRequired').show();
          $('.duoRequired').hide();
        }
      }
    });
  });


$(function() {
  // CONTACT
  document.getElementById('sendContact').disabled = true
  $('.contactInputs').keyup(function() {
    if($('#nameContact').val() != "" && $('#emailContact').val() != "" && $('#inquiryContact').val() != "") {
      $('#sendContact').removeClass('disabled')
      document.getElementById('sendContact').disabled = false
    } else {
      $('#sendContact').addClass('disabled')
      document.getElementById('sendContact').disabled = true
    }
  })


  // PURCHASE
  $('.purchaseInputs').keyup(function() {
    if($('#usernamePurchase').val() != "" && $('#emailPurchase').val() != "" && soloDuo == "Duo" || $('#loginPurchase').val() != "" && $('#passPurchase').val() != ""  && $('#emailPurchase').val() != "" && soloDuo == "Solo") {
      $('#sendPurchase').removeClass('disabled')
      document.getElementById('sendPurchase').disabled = false
    } else {
      $('#sendPurchase').addClass('disabled')
      document.getElementById('sendPurchase').disabled = true
    }

  })

  $('#quePurchase').on('click', function() {
      if(server == null) {
          return false;
      } else {
          if (boostType == "div") {
              window.location.href = "purchase.php?SD="+soloDuo+"&r1="+currentRank+"&d1="+currentDiv+"&server="+server+"&BT="+boostType+"&r2="+rankTo;
          } else {
              window.location.href = "purchase.php?SD="+soloDuo+"&r1="+currentRank+"&d1="+currentDiv+"&server="+server+"&BT="+boostType+"&numGames="+numOfGames;
          }
      }
  })
})

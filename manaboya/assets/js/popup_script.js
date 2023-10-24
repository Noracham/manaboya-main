jQuery(document).ready(function ($) {
  // 「きく」ボタンをクリックした時の処理
  // $('#chatgpt_pop').click(function () {
  //     $('#popup').toggle(); // ポップアップの表示・非表示を切り替える
  // });
  var tog = false;
  var click = true;
  $('#chatgpt_pop').click(function () {
    if (click) {
      click = false;
      setTimeout(function () {
        click = true;
      }, 500);
      if (tog == false) {
        $('#pop').fadeIn();
        $('#chatgpt_pop').css({ 'background': '#FFAF14', 'color': '#fff' })
        $('#chatgpt_pop img').css({ "filter": "brightness(0) invert(1)" })
        //   $('#chatgpt_pop').html('<img src="<?php echo get_theme_file_uri(\'/assets/img/chatbubbles-outline.svg\') ?>">とじる');
        tog = true;
      } else {
        $('#pop').fadeOut();
        tog = false;
        $('#chatgpt_pop').css({ 'background': '#fff', 'color': '#000' })
        $('#chatgpt_pop img').css({ "filter": "none" })
      }
      $('#pop').toggleClass('pop-active');
    }
  });

  $('#pop').click(function (e) {
    if (e.target === this) {
      $('#pop').removeClass('pop-active');
      $('#chatgpt_pop').css({ 'background': '#fff', 'color': '#000' })
      $('#chatgpt_pop img').css({ "filter": "none" })
      $('#pop').fadeOut();
      tog = false;
    }
  });

  // $('#scroll').click(function (event) {
  //   event.preventDefault();
  //   // var parentElement = $('#chatgpt-messages');
  //   // var lastChild = $('#chatgpt-messages').children(':last');

  //   //var currentPosition = parentElement.offset().top + parentElement.outerHeight();
  //   // var currentPosition = lastChild.offset().top;

  //   // 移動先を0px調整する。0を30にすると30px下にずらすことができる。
  //   let adjust = -500;
  //   // スクロールの速度
  //   let speed = 400; // ミリ秒
  //   // 移動先を取得
  //   let target = $('#chatgpt-messages').children(':last');
  //   // 移動先を調整
  //   let position = target.offset().top + adjust;
  //   // スムーススクロール
  //   $("body,html").animate({ scrollTop: position }, speed, "swing");

  //   console.log('スクロール位置:', position);
  // });


  //body res
  // $(document).ready(function(){
  //   $("body").css('height',$(window).height());
  //   $(".main-visual").css('height',$(window).height());
  //   console.log($(window).height());
  // })


  //textarea 改行
  function flexTextarea(el) {
    const dummy = el.querySelector('.FlexTextarea__dummy')
    el.querySelector('.FlexTextarea__textarea').addEventListener('input', e => {
      dummy.textContent = e.target.value + '\u200b'
    })
  }

  document.querySelectorAll('.FlexTextarea').forEach(flexTextarea)

});
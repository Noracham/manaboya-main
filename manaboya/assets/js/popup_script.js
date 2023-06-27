jQuery(document).ready(function ($) {
    // 「きく」ボタンをクリックした時の処理
    // $('#chatgpt_pop').click(function () {
    //     $('#popup').toggle(); // ポップアップの表示・非表示を切り替える
    // });
    var tog = false;
    var click = true;
    $('#chatgpt_pop').click(function () {
        if(click){
            click = false;
            setTimeout(function() {
                click = true;
              }, 500);
              if(tog == false){
                  $('#pop').fadeIn();
                  $('#chatgpt_pop').css({'background':'#FFAF14','color':'#fff'})
                //   $('#chatgpt_pop').html('<img src="<?php echo get_theme_file_uri(\'/assets/img/chatbubbles-outline.svg\') ?>">とじる');
                  tog = true;
                }else{
                    $('#pop').fadeOut();
                    tog = false;
                  $('#chatgpt_pop').css({'background':'#fff','color':'#000'})
                }
                $('#pop').toggleClass('pop-active');
            }
      });
    
      $('#pop').click(function(e) {
        if (e.target === this) {
          $('#pop').removeClass('pop-active');
          $('#chatgpt_pop').css({'background':'#fff','color':'#000'})
          $('#pop').fadeOut();
          tog = false;
        }
      });
   
      
      //body res
      // $(document).ready(function(){
      //   $("body").css('height',$(window).height());
      //   $(".main-visual").css('height',$(window).height());
      //   console.log($(window).height());
      // })
});
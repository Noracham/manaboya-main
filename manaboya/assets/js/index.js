jQuery(document).ready(function ($) {
      //ローディング
      $(window).on('load',function(){
        $('.loader').delay(500).fadeOut(500);
        $('.loader-content').delay(800).fadeOut(700);
    });
    setTimeout(function(){
        $('.loader').fadeOut(500);
    },5000);
});


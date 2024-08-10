require('./bootstrap');

$(".option").click(function(){
    $('.next').attr('disabled',false);
})

$(function(){
    $('.loading-section').fadeOut().removeClass("loader")
    $('#loading').fadeOut()
    // hide loader
    $('#loading', '.loading-section').fadeOut();
    $('.loading-section').removeClass('loader').fadeOut();

    $(".show-dropdown, .categories_menu").mouseenter(function(){
        $(".categories_menu").show()
      });

     $(".show-dropdown, .categories_menu").mouseleave(function(){
       $(".categories_menu").hide()
     });
})

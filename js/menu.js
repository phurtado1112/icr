$(document).ready(function(){
    $('.nav > li > a').click(function(){
        $('.nav > li >a ', $(this).parent()).removeClass('active');
        $(this).addClass('active');
    });
});
        

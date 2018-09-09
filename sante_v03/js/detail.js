$(function(){
    'use strict';
    $("#more-btn").click(function(){
        if($("p").hasClass('comment')){
            console.log("hhh");
            $("p").removeClass("comment");
        }else{
            $("p").addClass("comment");
        }
        
       
    });

});
$(function(){
    'use strict';
    $("#more-btn").click(function(){
        if($("#comment").hasClass('comment')){
            // console.log("hhh");
            $("#comment").removeClass("comment");
        }else{
            $("#comment").addClass("comment");
        }
    });
    $(".join-container").click(function(){
        console.log('test')
        swal("Welcome!!", "", "success");
    });
    console.log("hey");
    
    
     
});


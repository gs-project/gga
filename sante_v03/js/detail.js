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
        swal("Welcom!!", "イベント詳細はActivity画面で確認できます", "success");
    });
    console.log("hey");
        
        
});


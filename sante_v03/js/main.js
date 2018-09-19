$(function(){
    'use strict';
    
    //datepicker
    let dateFormat ='yy-mm-dd';
    $('#datepicker').datepicker({
        dateFormat: dateFormat
    });
   
   
    window.onload = function () {
        //今日の日時を表示
        var date = new Date()
        var year = date.getFullYear()
        var month = date.getMonth() + 1
        var day = date.getDate()
      
        var toTwoDigits = function (num, digit) {
          num += ''
          if (num.length < digit) {
            num = '0' + num
          }
          return num
        }
        
        var yyyy = toTwoDigits(year, 4)
        var mm = toTwoDigits(month, 2)
        var dd = toTwoDigits(day, 2)
        var ymd = yyyy + "-" + mm + "-" + dd;
        
        document.getElementById("datepicker").value = ymd;
    }
    // 最初の表示一覧

    let fun=[];
    let relax=[];
    let hard=[];
    function makeContainers(item){
            $.getJSON("json/activity.json",
                function pushes(data){
                    
                    for (let i = 0; i < data.length; i++) {
                        
                        if(data[i].key === 'fun') {
                            fun.push(data[i]);
                        }else if(data[i].key ==='relax'){
                            relax.push(data[i]);
                        }else{
                            hard.push(data[i]);
                        }
                    }
                    // let i =0;
                for(var i=0; i< item.length; i++){
                    let container = $('<a href="detail.php?activity_id='+item[i].id+'"></a>');
                //    console.log(item[i].id);
                    let imageContainer = $('<div></div>');
                    let timeContainer = $('<div></div>');
                    let profileContainer = $('<div></div>');
                    let detailContainer = $('<div></div>');
                    let locationContainer = $('<div><img class="location-icon" src="icon/cont_location_icon.png" alt="アイコン"></div>');
                    let location =$(' <img class="location-icon" src="icon/cont_location_icon.png" alt="アイコン"><p>'+ item[i].location +'</p>');

                    $(container).addClass("container");
                    $(imageContainer).addClass("image-container");
                    $(timeContainer).addClass("time-container");
                    $(profileContainer).addClass("profile-container");
                    $(detailContainer).addClass("detail-container");
                    $(locationContainer).addClass("location-container");
                    $(location).addClass("location");
                    //ここの画像ファイルとテキストを入れる形に
                    function　images(){
                        if(item[i].image == null){                            
                            images = '<img class ="ci-null"src="img/gene_noimage.png" alt="画像がありません">';
                            // $("image-container").addClass("ci-null-container");
                        } else{            
                            images = '<img class ="container-img"src="main_img/'+ item[i].image +'" alt="' + item[i].name + '">';
                        }
                        return images;
                    }

                    function　profiles(){
                        if(item[i].profile == null){                            
                            profiles ='<img src="img/gene_noimage.png" alt="プロフィール">';
                            // console.log(profile);
                            
                        } else{            
                            profiles ='<img src="host_img/' + item[i].profile +'" alt="プロフィール">';
                        }
                        return profiles;
                    }
                     console.log(profiles());                
                    
                    imageContainer.html(images);
                    timeContainer.html('<p>'+ item[i].startTime +'~'+ item[i].endTime +'</p>');
                    profileContainer.html(profiles);
                    detailContainer.html('<p>'+ item[i].name +'</p>');
                    location.html();
                    locationContainer.html(location);
                    container.html(imageContainer);
                    container.append(timeContainer).append(profileContainer).append(detailContainer).append(locationContainer);
                    $(".main-container").prepend(container);
                    // console.log(relax);
                    
                    // console.log(hard);
                }
            });
    }
    makeContainers(fun);
    

    $('#slide-title1').on("click", function(){ 
        fun =[];
        $('.main-container').empty();
        makeContainers(fun);
        console.log(fun);
    });
    $('#slide-title2').on("click", function(){ 
        relax = [];
        $('.main-container').empty();
        makeContainers(relax);
        
    });
    $('#slide-title3').on("click", function(){ 
        hard = [];
        $('.main-container').empty();
        makeContainers(hard);
        console.log(hard);
        console.log(hard);
        
    });
    
});
    
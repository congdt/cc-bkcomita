$(document).ready(function(){
	var comment = 0;
	var like = 0;

	//Xu ly Co dinh giao dien neu co thu nho cua so
	var height = $("#nav").height();

	// Giao dien
	$(".content").height($(document).height() - $("footer").height() - $(".header").height());
    
	// Tieu de
    title = $('title').html();
    if (title == "Trang chủ"){
      	$("li#trangchu").addClass("active");
    }
    else if (title == "Trang cá nhân") {
      	$("li#trangcanhan").addClass("active");
    }
    else if (title == "Đăng ảnh"){
    	$("li#danganh").addClass("active");
    }
    else if (title == "Kho ảnh"){
    	$("li#khoanh").addClass("active");
    }
    else {
    	$("li#theodoi").addClass("active");
    }


	// Ấn nut tai them =>ajax
	$("#taithem").click(function(){
	    $.get("loadimage.php", function(data, status){
	    	for(i=0; i<10; i++){
	    		if($("#div1").height() < $("#div2").height()){
	        		$("#div1").append(data);
	    		}
	        	else{
	        		$("#div2").append(data);
	        	}
	        }
	   	});
	});
	
	
	
	$("button").click(function(){
		if($(this).attr('id') == "show_comment"){
			
			//alert ($(this).attr("name"))
			picture_id = $(this).attr("name");
			
			loadComment(picture_id);
			$(this).attr('id', "showed_comment");
		}
		else if ($(this).attr('id') == "showed_comment" ){
			picture_id = $(this).attr("name");
			$(this).attr('id', "show_comment");
			//alert( $("#display_comment_id_" + picture_id).html());
			$('#display_comment_id_'+ picture_id).html("");
			$('#load_comment_' + picture_id).html("");
		}
		else if($(this).attr('id') === "Like"){
			var picture_id = $(this).attr("name");
			var thisObj = $(this);
			
			$.ajax({
				url : "/like",
				type : "post",
				dataType:"json",
				data : {
					'picture_id' : picture_id
				},
				success : function (result){
				console.log(result);
				//var data = $.parseJSON(result);
						
				if(result.title === 'success'){
					//$('#numLike_' + picture_id).html(result.numLike);
					//$('#like_button_' + picture_id).attr("value", result.button);
					numLike = result.numLike;
					thisObj.removeClass('btn-default');
					thisObj.addClass('btn-danger');
					thisObj.html( numLike + " <i class='fa fa-heart-o' style='font-size:12px' >" );
					thisObj.attr('id', result.button);
					
					
				}
				else 
					alert(result.title);
				},
				error : function (data){
					alert("fail");
				}
			});
			//$(this).removeClass('btn-default');
			//$(this).addClass('btn-danger');
			//$(this).html( numLike + " <i class='fa fa-heart-o' style='font-size:12px' >" );
			//$(this).attr('id', "liked");
		}
		else if( $(this).attr('id') === "Liked" ){
			var picture_id = $(this).attr("name");
			
			var thisObj = $(this);
			
			$.ajax({
				url : "/like",
				type : "post",
				dataType:"json",
				data : {
					'picture_id' : picture_id
				},
				success : function (result){
				console.log(result);
				//var data = $.parseJSON(result);
						
				if(result.title === 'success'){
					//$('#numLike_' + picture_id).html(result.numLike);
					//$('#like_button_' + picture_id).attr("value", result.button);
					numLike = result.numLike;
					thisObj.removeClass('btn-danger');
					thisObj.addClass('btn-default');
					thisObj.html( numLike + " <i class='fa fa-heart-o' style='font-size:12px; color:red' >" );
					thisObj.attr('id', result.button);
					
					
				}
				else 
					alert(result.title);
				},
				error : function (data){
					alert("fail");
				}
			});
			//$(this).removeClass('btn-danger');
			//$(this).addClass('btn-default');
			//$(this).html( numLike + " <i class='fa fa-heart-o' style='font-size:12px; color:red' >" );
			//$(this).attr('id', "like");
		}
	})
	$("#bt1").click(function(){
		a = $("#soluong").html()
		$("#like").html("Liked");
		$("#soluong").html(a+1)
	})
	
});

function loadComment(picture_id)
{
	
	$.ajax({
		url : "/loadComment",
		type : "get",
		dataType:"json",
		data : {
			'picture_id' : picture_id
		},
		success : function (result){
			console.log(result);
			
		if(result.title === 'success'){
			var picture_id = result.picture_id;
			var display_comment = document.getElementById('display_comment_id_' + picture_id);
			display_comment.innerHTML= "";
			var load_comment = document.getElementById('load_comment_' + result.picture_id);
			load_comment.innerHTML = "";
			
			for (var i=0; i< result.comments.length; i++){
				var comment_div = $('<div class="media" style="font-family: cursive;"> </div>');
				var img_div = $('<div class="media-left"> </div>');
				var img = $('<img class="media-object" style="width:60px; height:40px;">');
				var body_div = $('<div class="media-body"> </div>');
				var h5 = $('<h5 class="media-heading"></h5>');
				var p  = $('<p style="font-size: 16px"> </p>').text( result.comments[i].content ).html();;
				img.attr('src', result.url + result.comments[i].user_avatar);
				h5.text(result.comments[i].user_name).html();
				
				
				comment_div.append(img_div);
				comment_div.append(body_div);
				img_div.append(img);
				body_div.append(h5);
				body_div.append(p);
				
				$('#load_comment_' + picture_id).append(comment_div);
				
				/*
				var comment_div = document.createElement('div');
				comment_div.setAttribute('class', 'media');
				comment_div.setAttribute('style', "font-family: cursive;");
				var img_div = document.createElement('div');
				img_div.setAttribute('class', 'media-left');
				var body_div = document.createElement('div');
				body_div.setAttribute('class', 'media-body');
				var img = document.createElement('img');
				img.setAttribute('class', 'media-object');
				img.setAttribute('style', 'width:60px; height:40px;');
				var h5 = document.createElement('h5');
				h5.setAttribute('class', 'media-heading');
				var p = document.createElement('p');
				p.setAttribute('style', 'font-size: 16px;');
				
				
				img.setAttribute('src', "https://epic.co:4430/storage/" + result.comments[i].user_avatar);
				h5.innerHTML = result.comments[i].user_name;
				p.innerHTML = result.comments[i].content;
				
				img_div.appendChild(img);
				body_div.appendChild(h5);
				body_div.appendChild(p);
				comment_div.appendChild(img_div);
				comment_div.appendChild(body_div);
				var load_comment = document.getElementById('load_comment_' + result.picture_id);
				load_comment.appendChild(comment_div);
				*/
			}
		}
		else 
			alert(result.title);
					
		},
		error : function (data){
			alert("fail");
		}
	});
}

function ajax_comment( picture_id){
	
	console.log('comment_content_' + picture_id);
	var comment_content = document.getElementById('comment_content_' + picture_id).value;
	//comment_content.innerHTML = "";
	$('#comment_content_' + picture_id).val("");
	$.ajax({
		url : "/comment",
		type : "post",
		dataType: "json",
		data : {
			'picture_id' : picture_id,
			'comment_content' : comment_content
		},
		success : function (result){
			if(result.title === 'success'){
				pictue_id = result.picture_id;
				
				var comment_div = $('<div class="media" style="font-family: cursive;"> </div>');
				var img_div = $('<div class="media-left"> </div>');
				var img = $('<img class="media-object" style="width:60px; height:40px;">');
				var body_div = $('<div class="media-body"> </div>');
				var h5 = $('<h5 class="media-heading"></h5>');
				var p  = $('<p style="font-size: 16px"> </p>').text( result.comment_content ).html();;
				img.attr('src', result.user_avatar);
				h5.text(result.user_name).html();
				
				
				comment_div.append(img_div);
				comment_div.append(body_div);
				img_div.append(img);
				body_div.append(h5);
				body_div.append(p);
				
				
				$('#display_comment_id_' + picture_id).prepend(comment_div);
				
				/*
				var comment_div = document.createElement('div');
				var user_link = document.createElement('a');
				var content = document.createElement('p');
				
				user_link.setAttribute('href', "/user/"+ result.user_id);
				user_link.innerHTML = result.user_name;
				content.innerHTML = result.comment_content + " || created_at: " + result.created_at;
				
				comment_div.appendChild(user_link);
				comment_div.appendChild(content);
				*/
				
				/*
				var display_comment = document.getElementById('display_comment_id_' + result.picture_id);
				
				
				var comment_div = document.createElement('div');
				comment_div.setAttribute('class', 'media');
				comment_div.setAttribute('style', "font-family: cursive;");
				var img_div = document.createElement('div');
				img_div.setAttribute('class', 'media-left');
				var body_div = document.createElement('div');
				body_div.setAttribute('class', 'media-body');
				var img = document.createElement('img');
				img.setAttribute('class', 'media-object');
				img.setAttribute('style', 'width:60px; height:40px;');
				var h5 = document.createElement('h5');
				h5.setAttribute('class', 'media-heading');
				var p = document.createElement('p');
				p.setAttribute('style', 'font-size: 16px;');
				
						
				img.setAttribute('src', result.user_avatar);
				h5.innerHTML = result.user_name;
				p.innerHTML = result.comment_content;
						
				img_div.appendChild(img);
				body_div.appendChild(h5);
				body_div.appendChild(p);
				comment_div.appendChild(img_div);
				comment_div.appendChild(body_div);
						
				var display_comment = document.getElementById('display_comment_id_' + result.picture_id);
				display_comment.appendChild(comment_div);
				*/
			}
			else {
				alert(result.title);
			}
		},
		error : function (data){
			alert("comment error");
		}
	});
}

function ajax_like(picture_id){
	var numLike = 'error';
    $.ajax({
        url : "/like",
        type : "post",
        dataType:"json",
        data : {
			'picture_id' : picture_id
        },
        success : function (result){
		console.log(result);
		//var data = $.parseJSON(result);
				
		if(result.title === 'success'){
			//$('#numLike_' + picture_id).html(result.numLike);
			//$('#like_button_' + picture_id).attr("value", result.button);
			numLike = result.numLike;
			return result.numLike;
			console.log(numLike);
		}
		else 
			alert(result.title);
        },
		error : function (data){
			alert("fail");
		}
    });
    return numLike;
}
// looking main js file
function send_post(){
	$.post("send_post.php", { "post": document.getElementById("post").value }, function(data){
			if (typeof data == "string"){
				alert(data);
			} 
		});
}
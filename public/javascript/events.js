function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


$("a.love").live("click", function() {
	pic_id = getUrlVars()["id"];

	$.post('add_vote.php', {
		image_id : pic_id
	}, function(data) {
		
		if(data == "true"){
			$("a.love").removeClass('love').addClass('love-current');
			
			trenGlasova = parseInt( $(".loved").text() );
			trenGlasova++;
			
			$(".loved").text( trenGlasova + '');
			
			
		} else {
			alert(data);
		}
	});

});

$("a.love-current").live("click", function() {
	pic_id = getUrlVars()["id"];

	$.post('delete_vote.php', {
		image_id : pic_id
	}, function(data) {
		
		if(data == "true"){
			$("a.love-current").removeClass('love-current').addClass('love');
			
			trenGlasova = parseInt( $(".loved").text() );
			trenGlasova--;
			
			$(".loved").text( trenGlasova + '');
			
			
		} else {
			
			alert(data);
		}
	});

});

$("#comentara").live("click", function(){
		pic_id = getUrlVars()["id"];

	$.post('add_comment.php', $("#comentaraa").serialize(), function(data) {
		
		$("#comment_container").prepend( data);
		
		trenKomentara = parseInt( $(".comment").text() );
		trenKomentara++;
		
		$("#comentaraa").hide();
		
		$(".comment").text( trenKomentara + '');
	});
})


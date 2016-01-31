var id = "first";
function sendRequest( BlogOption )
{
	$.get("blog/ajax.php",BlogOption).done(function(data){
		var obj =JSON.parse(data)
		console.log(data);
		var BlogHtml = '';
	
		for (var i in obj)
		{
			if ( obj[ i ].id != undefined )
			{
				id = obj[ i ].id;
				var content = obj[i].content;
				if ( content != undefined )
				{
					content = XBBCODE.process({
					    text: content + "",
					    removeMisalignedTags: true,
					    addInLineBreaks: true
					});
				}
				BlogHtml = '<div class="blogPostblock">' +
					' <div class="blogPost_title">'+obj[i].title+'</div>' +
					'<div class="blogPost_author">Post by <span class="underline">'+obj[i].author+'</span> on <span class="blogPost_time">'+obj[i].datePosted+'</span> </div>'+	
					'<div class="blog_Post_content">'+ content.html +'</div>' +
					'</div>';
				$('#blogContent').append(BlogHtml);
			}
			
		}

		if ( id == "first" )
		{
			$('#blogContent').append( "There are currently no posts" );
			$( ".readmore" ).remove();
		}

		if ( obj.length == 0 )
		{
			$( ".readmore" ).remove();
		}
		
			
	})
}

$(document).ready(function(){
	sendRequest( {blog:"first"} );
	$( '.readmore' ).click( function( e ) {
		e.preventDefault();
		sendRequest( {blog: id + "" } );
	}
	);	
});


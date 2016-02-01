var id = "first";
function sendRequest( BlogOption )
{
	$.get("blog/ajax.php",BlogOption).done(function(data)
	{
		var obj = JSON.parse(data)
		console.log(data);
		var BlogHtml = '';
	
		for (var i in obj)
		{
			//if the object does not have an id field then the data is not a blog post so ignore it and continue
			if ( obj[ i ].id != undefined )
			{
				id = obj[ i ].id;
				var content = obj[i].content;
				//if there is content in the blog post then parse any BBCode in it using XBBCODE parser
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

		//if the id is still first after sending the request then none of the information from the server was a blog post
		//assume that there are no blog posts and show that on the page
		if ( id == "first" )
		{
			$('#blogContent').append( "There are currently no posts" );
			$( ".readmore" ).remove();
		}

		//if there were no blog posts received in this request then remove the readmore link
		if ( obj.length == 0 )
		{
			$( ".readmore" ).remove();
		}
		
			
	})
}

/*
	Popup an alert if there was a problem downloading an agenda file, for example there are no agenda's yet.
*/
function checkError()
{
	console.log( "Checking for errors" );
	var queryDict = {};
	location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]});

	if ( queryDict.error == "download" )
	{
		alert( "Something went wrong with downloading the agenda file" );
	}
}

/*
	Populates the blog section with blog posts from the server using an AJAX get request.
*/
$(document).ready(function()
{
	sendRequest( {blog:"first"} );
	$( '.readmore' ).click( function( e ) 
	{
		e.preventDefault();
		sendRequest( {blog: id + "" } );
	});

	checkError();	
});


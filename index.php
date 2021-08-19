<html>
<head>
<title>Makeup Web Service</title>
<style>
	body {font-family:georgia;}

	.film{
		border:1px solid #E77DC2;
		border-radius: 5px;
		padding: 5px;
		margin-bottom:5px;
		position:relative;	
		}

	.pic{
		position:absolute;
		right:10px;
		top:10px;
	}

</style>
<script src="https://code.jquery.com/jquery-latest.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {  

	$('.category').click(function(e){
        	e.preventDefault(); //stop default action of the link
		cat = $(this).attr("href");  //get category from URL
		loadAJAX(cat);  //load AJAX and parse JSON file
	});
});	


function loadAJAX(cat)
{
   $.ajax({
       type: "GET",
       dataType: "json",
       url: "api.php?cat=" + cat,
       success: bondJSON,
       error: function(xhr, status, error){
        let errorMessage = xhr.status + ': ' + xhr.statusText
        alert('Error - ' + errorMessage);
    }
 
   });
}
   
function toConsole(data)
{//return data to console for JSON examination
	console.log(data); //to view,use Chrome console, ctrl + shift + j
}

function bondJSON(data){
	//HERE IS HOW I SEE DATA RETURNED VIA THE CONSOLE
	console.log(data);

	//identifies the type of data returned
	$('#filmtitle').html(data.title);

	//clears other clicked films
	$("#films").html("");

	//loop through films and add template
	
	$.each(data.makeup, function(i,item){ //reloads
		let myMakeup = bondTemplate(item);
		$('<div></div>').html(myMakeup).appendTo('#films');
	});
	

	//this loads the data on the page but its all bunched up
	//$("#output").text(JSON.stringify(data));

	//this creates a map of the JSON on our page
	
	let myData = JSON.stringify(data, null, 4);
	myData = "<pre>" + myData + "</pre>";
	$("#output").html(myData);
	
}

function bondTemplate(film){

	return `
		<div class="film">
				<b>title: </b>${makeup.title}<br />
				<b>Name: </b>${makeup.Name}<br />
				<b>Type: </b>${makeup.Type}<br />
				<b>Company: </b>${makeup.Company}<br />
				<b>Release Year: </b>${makeup.ReleaseYear}<br />
				<b>Rating: </b>${makeup.Rating}<br />
				<div class="pic"><img src="thumbnails/${makeup.Image}" /></div>
		</div>
	
	`;
}


</script>
</head>
	<body>
	<h1>Makeup Web Service</h1>
		<a href="year" class="category">Makeup by Release Year</a><br />
		<a href="box" class="category">Makeup by Name</a>
		<h3 id="filmtitle">Title Will Go Here</h3>
		<div id="films">
			
		</div>
		<div id="output">Results go here</div>
	</body>
</html>
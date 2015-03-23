<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Flickr Search</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<style>
		#search-form {
			width: 300px;
		}
	</style>
	<script>
		var key = 'a20ecbe391bca214cd8dff80c1c188bd'; // key to use flicker api ... updated to mine
		var base_url = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=" + key + "&format=json&nojsoncallback=1";

		$(document).ready(function () {

			var displayPhotos = function (photos) { //creates a function to display imgs on page
				if(photos.length > 0){              //if statement to determine if any photos were returned from search
					$('#photo-list').html('');
				}else{
					$('#photo-list').html('No Photos Found');
				}
				for (var index in photos) {
					var photoObj = photos[index];              //loops through all found photos
					var url = 'https://farm' + photoObj.farm + '.staticflickr.com/' + photoObj.server + '/' + photoObj.id + '_' + photoObj.secret + '.jpg'
					var img = $('<img/>').attr('src', url).width(250); //creates an img tag containing a img
					$('#photo-list').append(img);                      //appends img to the photo list div
				}
			}

			$('body').on('click', '#search-btn', function () {   //onclick handeler for search button 
				var val = $('#search').val();                    //gets users input
				var search_url = base_url + "&text=" + val;      //adds the search criteria to the above defined base url
				var photos = [];                                 //creates a blank array to hold the returned photos

				$('#photo-list').html('Searching');               //displays 'searching' while waiting for search to finish

				$.ajax({                                        //ajax call to flicker to retrieve photos based on search
					url: search_url,
					dateType: 'json',      //expect json data back
					crossDomain: true,     //allows for cross domain calls
					success: function (response) {         //if the call is successful run function
						photos = response.photos.photo;   //set the response to the above declared photos array
						displayPhotos(photos);            //calls the displayphotos function with photos as a param to display photos on page
					},
					error: function (response) {          //if there was an error with the call console log the response
						console.error(response);
					}
				});


			});
		});
	</script>

</head>

<body>
	<div id="search-form">
		<div class="panel panel-default panel-primary">
			<div class="panel-heading">Search Flickr</div>
			<div class="panel-body">
				<div class="form-group">
					<div class="input-group input-group-lg">
						<span class="input-group-addon glyphicon glyphicon-search"></span>
						<input id="search" type="text" class="form-control" placeholder="Search" name="search" />
					</div>
				</div>
				<button id="search-btn" class="btn btn-lrg btn-default pull-right">Search</button>
			</div>
		</div>
	</div>
	<div id="photo-list">
	</div>
</body>

</html>
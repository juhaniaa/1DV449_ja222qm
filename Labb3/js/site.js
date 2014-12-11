var APP = APP || {};

APP.initialize = function() {
	var mapOptions = {
		center: { lat: -34.397, lng: 150.644},
		zoom: 8
	};
	var map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
};

google.maps.event.addDomListener(window, 'load', APP.initialize);

//src="http://api.sr.se/api/v2/traffic/messages"
/*
$("#updTraficBtn").click(function(){
		
	APP.getApi("http://api.sr.se/api/v2/traffic/messages", function(result){
		alert("hello");
		console.log(result);
	});
	
});*/

$("#updTraficBtn").click(function(){
		
	APP.getServer({url:"http://api.sr.se/api/v2/traffic/messages?format=json&size=138"}, function(result){
		alert("hello");
		console.log(result);
		$.each(result.contents.messages, function(i, row){
			console.log("hello");
			console.log(row.latitude);
			console.log(row.longitude);
			console.log(row.createddate);
			console.log(new Date(row.createddate * 1000));
			console.log(new Date(parseInt(row.createddate.substr(6))));
			
		});
					
	});
	
});

APP.getApi = function(urlRef, successRef){
	
	$.ajax({
		url: urlRef,		        
        type: 'get',
        crossDomain: true,
                        
        success: function(result){          	   
        	successRef(result);        	
        },
        error: function (request,error) {                          
            alert('Nätverksfel, var god testa igen');   
        }
    }); 
};

APP.getServer = function(data, successRef){
	$.ajax({
		url: "http://aavanenprogramming.com/WebbteknikII/Labb03/api/ba-simple-proxy.php",
		data: data,
		type: "get",
		success: function(result){
			successRef(result); 
		},
		
		error: function(request, error){
			alert("Network error, try again");
		}
	});	
};

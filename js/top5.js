$(document).ready(function(){
	$.ajax({
		url : "http://localhost/covid_database/top5data.php",
		type : "GET",
		success : function(data){
			console.log(data);
			var landesname = [];
			var summecases = [];
			var summetode = [];
			
			for(var i in data){
				landesname.push(data[i].landesname);
				summecases.push(data[i].summecases);
				summetode.push(data[i].summetode);
				
			}
			
			var chartdata = {
				labels: landesname,
				datasets: [
					{
						label: "Gemeldete Infizierte",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: summecases
					},
					{
						label: "Tote",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(79, 202, 70, 0.75)",
						borderColor: "rgba(79, 202, 70, 1)",
						pointHoverBackgroundColor: "rgba(79, 202, 70, 1)",
						pointHoverBorderColor: "rgba(59, 202, 70, 1)",
						data: summetode
					}
				]
			};
			
			var ctx = $("#top5");
			
			var LineGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			});

		},
		error : function(data) {
			
		}
	})
});
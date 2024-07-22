	$('#btnRun').click(function() {

		$.ajax({
			url: "libs/php/getCountryInfo.php",
			type: 'POST',
			dataType: 'json',
			data: {
				country: $('#selCountry').val(),
				lang: $('#selLanguage').val()
			},
			success: function(result) {

				console.log(JSON.stringify(result));

				if (result.status.name == "ok") {

					$('#txtContinent').html(result['data'][0]['continent']);
					$('#txtCapital').html(result['data'][0]['capital']);
					$('#txtLanguages').html(result['data'][0]['languages']);
					$('#txtPopulation').html(result['data'][0]['population']);
					$('#txtArea').html(result['data'][0]['areaInSqKm']);

				}
			
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// your error code
			}
		}); 
	
	});


		$('#oceanBtn').click(function() {
			var latitude = $('#selLatitude').val();
			var longitude = $('#selLongitude').val();
	
			// Validate input values
			if (latitude === '' || longitude === '') {
				$('#output').html('<p>Please enter both latitude and longitude.</p>');
				return;
			}
	
			$.ajax({
				url: 'libs/php/getOcean.php',
				type: 'GET',
				dataType: 'json',
				data: {
					latitude: latitude,
					longitude: longitude
				},
				success: function(result) {
					if (result.status.code === "200") {
						var ocean = result.data;
						$('#output').html(
							'<h3>Ocean Information</h3>' +
							'<p><strong>Name:</strong> ' + (ocean.name || 'N/A') + '</p>' +
							'<p><strong>GeonameId:</strong> ' + (ocean.geonameId || 'N/A') + '</p>' 

						);
					} else {
						$('#output').html('<p>Error: ' + result.status.description + '</p>');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$('#output').html('<p>Error: ' + textStatus + '</p>');
				}
			});
		});
	
			$('#neighBtn').click(function() {
				var latitude = $('#neighLatitude').val();
				var longitude = $('#neighLongitude').val();
		
				// Validate input values
				if (latitude === '' || longitude === '') {
					$('#neighResults').html('<p>Please enter both latitude and longitude.</p>');
					return;
				}
		
				$.ajax({
					url: 'libs/php/getNeighbourhood.php',
					type: 'GET',
					dataType: 'json',
					data: {
						latitude: latitude,
						longitude: longitude
					},
					success: function(result) {
						if (result.status.code === "200") {
							var neighbourhood = result.data;
							$('#neighResults').html(
								'<h3>Neighbourhood Information</h3>' +
								'<p><strong>Name:</strong> ' + (neighbourhood.name || 'N/A') + '</p>' +
								'<p><strong>City:</strong> ' + (neighbourhood.city || 'N/A') + '</p>'
							);
						} else {
							$('#neighResults').html('<p>Error: ' + result.status.description + '</p>');
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$('#neighResults').html('<p>Error: ' + textStatus + '</p>');
					}
				});
			});
		
		
			$('#tzBtn').click(function() {
				var latitude = $('#tzLatitude').val();
				var longitude = $('#tzLongitude').val();
				var radius = $('#tzRadius').val();
				var lang = $('#tzLang').val();
				var date = $('#tzDate').val();
		
				// Validate input values
				if (latitude === '' || longitude === '') {
					$('#tzOutput').html('<p>Please enter both latitude and longitude.</p>');
					return;
				}
		
				$.ajax({
					url: 'libs/php/getTimezone.php',
					type: 'GET',
					dataType: 'json',
					data: {
						latitude: latitude,
						longitude: longitude,
						radius: radius,
						lang: lang,
						date: date
					},
					success: function(result) {
						if (result.status.code === "200") {
							var timezone = result.data;
							$('#tzOutput').html(
								'<h3>Timezone Information</h3>' +
								'<p><strong>Timezone Name:</strong> ' + (timezone.timezoneId || 'N/A') + '</p>' +
								'<p><strong>GMT Offset:</strong> ' + (timezone.gmtOffset || 'N/A') + '</p>' +
								'<p><strong>DST Offset:</strong> ' + (timezone.dstOffset || 'N/A') + '</p>'
							);
						} else {
							$('#tzOutput').html('<p>Error: ' + result.status.description + '</p>');
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$('#tzOutput').html('<p>Error: ' + textStatus + '</p>');
					}
				});
			});
	
		
<html>
	<body>
		<?php
		require_once '../krumo/class.krumo.php';
		if (!empty($_POST['latitude']) && !empty($_POST['longitude'])) {
			krumo($_POST);
		} elseif (!empty($_POST['street']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])){
			krumo($_POST);	
		} else{ krumo($_POST);}
		function soap($latitude, $longitude, $radius) {
			$client = new SoapClient('http://iaspub.epa.gov/WATERSWebServices/SpatialServices?WSDL', array('trace' => true, 'exceptions' => true));
			$args = array('latitude' => $latitude, 'longitude' => $longitude, 'searchRadiusMiles' => 10, 'programsList' => array('array' => array('303D')));

			try {
				$stuff = $client -> __soapCall('getEntitiesByLatLong', $args);
			} catch (SoapFault $e) {
				echo "SOAP Fault: " . $e -> getMessage() . "<br />\n";
			}
			//* DEBUG
			echo "<pre>\n\n";
			echo "Request :\n";
			echo htmlspecialchars($client -> __getLastRequest()) . "\n";
			echo "</pre>";
			//*/
			krumo($client -> __getTypes());
		}
		?>
	</body>
</html>
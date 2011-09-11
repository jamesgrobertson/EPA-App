<html>
	<body>
		<?php
		require_once '../krumo/class.krumo.php';
		if (is_numeric($_POST['latitude']) && is_numeric($_POST['longitude']) && is_numeric($_POST['radius'])) {
			$results = soap($_POST['latitude'], $_POST['longitude'], $_POST['radius']);
		} else{ krumo($_POST);}
		function soap($latitude, $longitude, $radius) {
			$client = new SoapClient('http://iaspub.epa.gov/WATERSWebServices/SpatialServices?WSDL', array('trace' => true, 'exceptions' => true));
			$args = array('latitude' => $latitude, 'longitude' => $longitude, 'searchRadiusMiles' => $radius, 'programsList' => array('array' => array('303D')));

			try {
				$stuff = $client -> __soapCall('getEntitiesByLatLong', $args);
				return $stuff;
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
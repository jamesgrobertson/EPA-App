<?php
require_once '../krumo/class.krumo.php';
$client = new SoapClient('http://iaspub.epa.gov/WATERSWebServices/SpatialServices?WSDL', array('trace' => true, 'exceptions' => true));
$args = array('latitude' => 32.654, 'longitude' => -79.939, 'searchRadiusMiles' => 10, 'programsList' => array('array' => array('303D')));

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
krumo($client->__getTypes());
?>

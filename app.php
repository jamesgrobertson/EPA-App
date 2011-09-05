<?php
$client = new SoapClient('http://iaspub.epa.gov/WATERSWebServices/SpatialServices?WSDL', array('trace' => true, 'exceptions' => true));
$arr = new SoapVar( array('string' => '303D'), SOAP_ENC_ARRAY, NULL, NULL, 'array');
$args = array('latitude' => 32.654, 'longitude' => -79.939, 'searchRadiusMiles' => 10, 'programsList' => array('array' => array('303D')));

try {
	$stuff = $client -> __soapCall('getEntitiesByLatLong', $args);
} catch (SoapFault $e) {
	echo "SOAP Fault: " . $e -> getMessage() . "<br />\n";
}

//print_r($client->__getTypes());
//* DEBUG
echo "<pre>\n\n";
echo "Request :\n";
echo htmlspecialchars($client -> __getLastRequest()) . "\n";
echo "</pre>";
//*/
?>

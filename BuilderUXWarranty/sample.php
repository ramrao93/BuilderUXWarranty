<?php
	
	$wsdl = "http://demo2.builderux.com:8080/interfaceService-0.0.1/BuilderUxImpl?wsdl";
	$opt = array();
	$vSoapClient = new SoapClient($wsdl,$opt);
	$vSoapClient->__setLocation('http://demo2.builderux.com:8080/interfaceService-0.0.1/BuilderUxImpl');


	$data[1]["optionCodes"] = "xxxx";
	$data[1]["qty"] = 1;

	$data[2]["optionCodes"] = "yyy";
	$data[2]["qty"] = 1;

	$arg = array("arg0" => 'SessionName',"arg1" => $data);
	$vSendCustomerObject = $vSoapClient->saveEhomeSession($arg);
	$resultx = $vSoapClient->__getLastResponse();
            

    print_r($resultx);


    //retrieve session
    $retrieveArg = array("arg0" => 'SessionName');
    $vSendCustomerObject = $vSoapClient->getEhomeSession($arg);
    $resultsResponse = $vSoapClient->__getLastResponse();

    print_r($resultsResponse);


?>
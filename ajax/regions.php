<?php
$response = [
    'success' => 0,
    'msg' => 'Error inésperado',
    'data' => ''
];
try{
    header('Content-type: application/json; charset=utf-8');
    require('../includes/getplaces.php');
    if(isset($_GET['parentId']) && !empty($_GET['parentId'])){
        $paramsCity['parentId'] = $_GET['parentId'];
        $params = $paramsCity;
    }else{
        $params = $paramsRegion;
    }
    $endpoint.= '?' . http_build_query($params);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if(curl_exec($ch) === false){
        throw new Exception('Curl error: ' . curl_error($ch));
    }
    $res = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($res);
    if(!is_array($res) || !count($res)){
        throw new Exception('Hay un problema con la comunicación con el servicio de regiones. Inténtelo de nuevo más tarde.');
    }
    $data = [];
    foreach($res as $region){
        $data[$region->Id] = $region->Name;
    }
    $response = [
        'success' => 1,
        'msg' => 'ok',
        'regions' => $data
    ];
}catch(Exception $e){
    $response['msg'] = $e->getMessage();
}
echo json_encode($response);
<?php
$response = [
    'success' => 0,
    'msg' => 'Error inésperado al guardar',
    'data' => ''
];
try{
    header('Content-type: application/json; charset=utf-8');
    require('../includes/mysql.php');
    $data = $_GET;
    if(!isset($data['region']) || empty($data['region'])){
        throw new Exception('La región es requerida');
    }
    if(!isset($data['city']) || empty($data['city'])){
        throw new Exception('La ciudad es requerida');
    }
    if(!isset($data['userid']) || empty($data['userid'])){
        throw new Exception('Número de usiario requerido');
    }
    $region = filter_var($data['region'], FILTER_SANITIZE_STRING);
    $city = filter_var($data['city'], FILTER_SANITIZE_STRING);
    $userid = filter_var($data['userid'], FILTER_SANITIZE_NUMBER_INT);

    //Verifica que el usuario existe
    $stmt = $mbd->prepare("SELECT e.* FROM employees as e WHERE e.emp_no = ?");
    $stmt->execute([$userid]); 
    $user = $stmt->fetch();
    if(!$user){
        throw new Exception("El usuario número '$emp' no existe");
    }
    //Si el usuario existe, pasa current = 0 a todas las direcciones que tenga existentes
    $stmt = $mbd->prepare("UPDATE location_emp SET is_current=? WHERE emp_no = ?");
    $stmt->execute([0, $userid]);
    //Agrega la nueva dirección
    $stmt = $mbd->prepare("INSERT INTO location_emp (emp_no, state, city, is_current) values (?, ?, ?, ?)");
    $stmt->execute([$userid, $region, $city, 1]);
    $response = [
        'success' => 1,
        'msg' => 'ok',
        'data' => 'ok'
    ];
}catch(Exception $e){
    $response['msg'] = $e->getMessage();
}
echo json_encode($response);
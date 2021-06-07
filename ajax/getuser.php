<?php
$response = [
    'success' => 0,
    'msg' => 'Error inésperado',
    'data' => ''
];
try{
    header('Content-type: application/json; charset=utf-8');
    require('../includes/mysql.php');
    $data = $_POST;
    
    //Verifica requerido
    if(!isset($data['emp'])){
        throw new Exception('Número de empleado es requerido');
    }
    
    //Sanitiza
    $emp = filter_var($data['emp'], FILTER_SANITIZE_NUMBER_INT);
    if(!$emp){
        throw new Exception('Número de empleado inválido');
    }

    //Consulta el usuario
    $stmt = $mbd->prepare("SELECT e.*, l.state, l.city FROM employees as e LEFT JOIN location_emp as l ON e.emp_no = l.emp_no  AND l.is_current = 1 WHERE e.emp_no = ?");
    $stmt->execute([$emp]); 
    $user = $stmt->fetch();
    if(!$user){
        throw new Exception("El usuario número '$emp' no existe");
    }
    $response = [
        'success' => 1,
        'msg' => 'ok',
        'data' => $user
    ];
}catch(Exception $e){
    $response['msg'] = $e->getMessage();
}
echo json_encode($response);
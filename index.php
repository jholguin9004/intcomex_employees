<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h2>Actualización de sede</h2>
            <form action="" id="form_consulta" method="post">
                <div class="consulta">
                    <div class="form-group" >
                        <label for="emp_no">Número de empleado:</label>
                        <input type="emp_no" class="form-control" id="emp_no" placeholder="Ingrese el número de empleado" name="emp_no">
                    </div>
                    <div class="alert alert-danger" role="alert" id="consulta_error" style="display:none">
                    </div>
                    <div class="spinner-border" role="status" id="consulta_spinner" style="display:none">
                        <span class="">Buscando...</span>
                    </div>
                    <button type="submit" id="btn_consultar" class="btn btn-default">Consultar</button>
                </div>
                <div class="result_info" style="display:none">
                    <div class="card">
                        <div class="card-header"></div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>Nombre</b>: <span id="user_name"></span></li>
                                <li class="list-group-item"><b>Fecha de contratación</b>: <span id="hire_date"></span></li>
                                <li class="list-group-item"><b>Género</b>: <span id="gender"></span></li>
                                <li class="list-group-item"><b>Fecha de nacimiento</b>: <span id="birth_date"></span></li>
                                <li class="list-group-item">
                                    <b>Sede actual</b>: <span id="location"></span>
                                    <button type="button" id="btn_showsede" class="btn btn-default">Asignar sede</button>
                                    <div class="city_form" style="display:none">
                                        <h3>Seleccione una sede</h3>
                                        <div class="spinner-border" role="status" id="sedes_spinner" style="display:none">
                                            <span class="sedes_spinner_meg">Buscando...</span>
                                        </div>
                                        <div class="form-group" >
                                            <label for="region">Región:</label>
                                            <select class="form-select" name="region" id="region" aria-label="Seleccione una región">
                                            </select>
                                        </div>
                                        <div class="form-group" >
                                            <label for="city">Ciudad:</label>
                                            <select class="form-select" name="city" id="city" aria-label="Seleccione una ciudad">
                                            </select>
                                        </div>
                                        <div class="alert alert-danger" role="alert" id="sedes_error" style="display:none">
                                        </div>
                                        <button type="button" id="btn_savesede" class="btn btn-default">Guardar sede</button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script src="js/functions.js"></script>
    </body>
</html>
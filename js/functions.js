//Click en consultar
var userId = null;

jQuery("#btn_consultar").on("click", function(e){
    e.preventDefault();
    resetPage();
    emp = jQuery('#emp_no').val();
    //requerido
    if(emp == ''){
        resultError('Ingrese el número de empleado.', 'consulta');
        return;
    }
    //debe ser número
    if(isNaN(emp)){
        resultError('Ingrese un número.', 'consulta');
        return;
    }
    //Consulta
    showSpinner('consulta');
    userId = null;
    jQuery.ajax({
        url: 'ajax/getuser.php',
        method: 'POST',
        data: {emp: emp},
        success: function(data) {
            if(data.success){
                data = data.data;
                jQuery('#user_name').html(data.first_name + ' ' + data.last_name);
                jQuery('#hire_date').html(data.hire_date);
                jQuery('#birth_date').html(data.birth_date);
                jQuery('#gender').html(data.gender);
                loc = (data.state) ? data.state + '/' + data.city : 'No asignada';
                jQuery('#location').html(loc);
                jQuery('.result_info').show();
                jQuery("#btn_showsede").show();
                userId = data.emp_no;
            }else{
                console.log(data);
                resultError(data.msg, 'consulta');    
            }
            resetSpinner('consulta');
        }, 
        error: function(err) {
            resultError(err, 'consulta');
            resetSpinner('consulta');
        }
    });
});

//Click en consultar
jQuery("#btn_showsede").on("click", function(e){
    e.preventDefault();
    jQuery('.city_form').show();
    //Consulta
    clearCities();
    clearRegions();
    showSpinner('sedes');
    jQuery.ajax({
        url: 'ajax/regions.php',
        method: 'GET',
        success: function(data) {
            if(data.success){
                jQuery.each(data.regions, function(key, value){
                    jQuery('#region').append($("<option></option>").attr("value", key).text(value));
               });
               jQuery('#region').prop('disabled', false);
               jQuery("#btn_showsede").hide();
            }else{
                console.log(data);
                resultError(data.msg, 'sedes');    
            }
            resetSpinner('sedes');
        }, 
        error: function(err) {
            resultError(err, 'sedes');
            resetSpinner('sedes');
        }
    });
});


//Click en consultar
jQuery("#btn_savesede").on("click", function(e){
    e.preventDefault();
    resetError('sedes');
    region = jQuery('#region').val();
    city = jQuery('#city').val();
    if(!region || region == '' || region == 0 || !city || city == '' || city == 0){
        resultError('Seleccione la sede', 'sedes');
        return;
    }
    //Consulta
    showSpinner('sedes');
    region = jQuery("#region :selected").text();
    city = jQuery("#city :selected").text();
    jQuery.ajax({
        url: 'ajax/save.php?region=' + region + '&city=' + city + '&userid=' + userId,
        method: 'GET',
        success: function(data) {
            if(data.success){
                resetPage();
                jQuery("#btn_consultar").trigger('click');
                alert('Actualizado correctamente');
            }else{
                console.log(data);
                resultError(data.msg, 'sedes');    
            }
            resetSpinner('sedes');
        }, 
        error: function(err) {
            resultError(err, 'sedes');
            resetSpinner('sedes');
        }
    });
});

jQuery("#region").on("change", function(e){
    val = jQuery(this).val();
    clearCities();
    if(!val || val == 0 || val == ''){
        return;
    }
    jQuery('#region').prop('disabled', true);
    showSpinner('sedes');
    jQuery.ajax({
        url: 'ajax/regions.php?parentId=' + val,
        method: 'GET',
        success: function(data) {
            if(data.success){
                jQuery.each(data.regions, function(key, value){
                    jQuery('#city').append($("<option></option>").attr("value", key).text(value));
               });
               jQuery('#city').prop('disabled', false);
            }else{
                console.log(data);
                resultError(data.msg, 'sedes');    
            }
            resetSpinner('sedes');
            jQuery('#region').prop('disabled', false);
        }, 
        error: function(err) {
            resultError(err, 'sedes');
            resetSpinner('sedes');
            jQuery('#region').prop('disabled', false);
        }
    });

});

function clearCities(){
    jQuery('#city').prop('disabled', true);
    jQuery('#city').find('option').remove().end();
    jQuery('#city').append($("<option></option>").attr("value", '0').text('Seleccione una'));
}

function clearRegions(){
    jQuery('#region').find('option').remove().end();
    jQuery('#region').append($("<option></option>").attr("value", '0').text('Seleccione una'));
}

function resetPage(){
    resetError('consulta');
    resetSpinner('consulta');
    resetError('sedes');
    resetSpinner('sedes');
    jQuery('.result_info').hide();
    jQuery('.city_form').hide();
}

//Limpia el mensaje de error
function resetError(type){
    jQuery('#' + type + '_error').html('').hide();
}

//Muestra el mensaje de error
function resultError(msg, type){
    jQuery('#' + type + '_error').html(msg).show();
}

//Limpia el mensaje de error
function resetSpinner(type){
    jQuery('#' + type + '_spinner').hide();
}

//Muestra el mensaje de error
function showSpinner(type){
    jQuery('#' + type + '_spinner').show();
}
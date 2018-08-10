
$("#form_ingresar_usuario").validate({



    submitHandler: function(form){
        var data = {};
        var valor_clase_formulario = $("#form_ingresar_usuario").attr("class");
        var ruta = $("#form_ingresar_usuario").attr("action");
        data.cedula = document.getElementById("cedula").value.trim();
        data.password = document.getElementById("change_password").value.trim();
        data.nombre = document.getElementById("nombre").value.trim();
        data.apellidos = document.getElementById("apellidos").value.trim();
        data.email = document.getElementById("email").value.trim();
        data.ingreso_admin = $("#validar_ingreso_admin").val();


        ajax(ruta,data,function(response){

            if(response.url != ""){
                window.location.href = response.url;
                return false;
            }


            heading = "Ingresado!";
            text = response.msg;
            icon = "info";

            if(response.res==0){
                heading = "Alerta";
                icon = "error";
            }

            if(response.res==2){
                dataTable.ajax.reload();
                $("#userModal").modal("hide");
            }
            

            return mensaje_toast(heading,text,icon);    
        });
    }
});


$(document).on('click', '.update', function(e){
    e.preventDefault();
    var data = {};
    data.id = $(this).attr("id");        
    ajax($BASE_URL + 'usuario/listar_id',data,function(response){
        $('#userModalupdate').modal('show');
        $(".title-modificar-usuario").text("¿ Desea modificar el usuario '" + response.nombre +  "' con la cédula '" + response.cedula + "' ?" );
        $("#nombre_update").val(response.nombre);
        $("#apellidos_update").val(response.apellidos);
        $("#correo_update").val(response.correo);
        $("#id_cedula_update").val(response.cedula);


    });
});

$(document).on('click', '.delete', function(e){
    e.preventDefault();
    var data = {};
    data.id = $(this).attr("id");        
    ajax($BASE_URL + 'usuario/listar_id',data,function(response){
        $('#userModaleliminar').modal('show');
        $(".eliminar-text-usuario").text("¿ Desea eliminar el usuario '" + response.nombre +  "' con la cédula '" + response.cedula + "' ?" );
        $("#id_cedula_eliminar").val(response.cedula);


    });
});

$("#form_usuario_eliminar").validate({

    submitHandler: function(form){
        var data = {};

        var ruta = $("#form_usuario_eliminar").attr("action");


        data.id = document.getElementById("id_cedula_eliminar").value.trim();

        ajax(ruta,data,function(response){
            heading = "Eliminar!";
            text = response.msg;
            icon = "info";

            if(response.res==0){
                heading = "Alerta";
                icon = "error";
            }

            if(response.res == 1){
                dataTable.ajax.reload();
                $("#userModaleliminar").modal("hide");
            }


            return mensaje_toast(heading,text,icon);    
        });
    }
});


$(".cambiar-contrasenia-general").click(function(){
    $("#userModalChangePasswordGeneral").modal("show");
});

 //Validate para cambiar la contraseña general por usuario
$("#form-change-password-general").validate({

    rules:{
        "change-password-repit-general":{
            equalTo:"#change-password-general",
        }
    },

    submitHandler: function(form){
        var data = {};
        data.password_actual = document.getElementById("change-password-general-actual").value.trim();
        data.password = document.getElementById("change-password-general").value.trim();

        ajax($BASE_URL + 'usuario/cambiar_contrasena_general',data,function(response){
            heading = "Alerta!";
            text = response.msg;
            icon = "error";
            
            if(response.res== 1)
            {
                $("#change-password-general-actual").val("");
                $("#change-password-general").val("");
                $("#change-password-repit-general").val("");
                heading = "Modificada!";
                icon = "success";
                $("#userModalChangePasswordGeneral").modal('hide');
            }          

            return mensaje_toast(heading,text,icon);
        });
    }
});

//Activar la ventana modal y sobre escribir el nombre del título de la ventana
$(document).on('click', '.change_password', function(e){
    var data = {};
    e.preventDefault();
    data.id = $(this).attr("id");
    
    ajax($BASE_URL + 'Usuario/listar_id',data,function(response){
        $('#userModalChangePassword').modal('show');
        $("#form_change_password > div > div > h4").html("Cambiar la contraseña al usuario '"+response.nombre+"'");
        $(".cedula_usuario_change").val(response.cedula);
    });
});

 //Validate para cambiar la contraseña
$("#form_change_password").validate({


    rules:{
        "change_password_repit":{
            equalTo:"#change_password_update",
        }
    },

    submitHandler: function(form){
        var data = {};
        data.password = document.getElementById("change_password_update").value.trim();
        data.cedula = document.getElementById("cedula_usuario_change").value.trim();

        ajax( $BASE_URL + 'Usuario/cambiar_contrasena',data,function(response){
            heading = "Alerta!";
            text = response.msg;
            icon = "error";
            $("input[type=text]").val("");
            $("input[type=password]").val("");
            if(response.res== 1)
            {
                heading = "Modificada!";
                icon = "success";
                $('#userModalChangePassword').modal('hide');
            }          

            return mensaje_toast(heading,text,icon);
        });
    }
});


$("#form_usuario_modificar").validate({

    submitHandler: function(form){
        var data = {};

        var ruta = $("#form_usuario_modificar").attr("action");


        data.nombre = document.getElementById("nombre_update").value.trim();
        data.apellidos = document.getElementById("apellidos_update").value.trim();
        data.correo = document.getElementById("correo_update").value.trim();
        data.modificar_admin = $("#validar_modificacion_admin").val();
        data.id_cedula_admin = $("#id_cedula_update").val();


        ajax(ruta,data,function(response){

            if(response.url != ""){
                window.location.href = response.url;
                return false;
            }


            heading = "Modificado!";
            text = response.msg;
            icon = "info";

            if(response.res==0){
                heading = "Alerta";
                icon = "error";
            }

            if(response.res == 1){

                $("#nombre").val(response.data.nombre);
                $("#apellidos").val(response.data.apellidos);
                $("#correo").val(response.data.correo);
                $("#enlace-nombre").text(response.data.nombre + " " + response.data.apellidos);
                dataTable.ajax.reload();
                $("#userModalupdate").modal("hide");
            }


            return mensaje_toast(heading,text,icon);    
        });
    }
});

//Creacion de la tabla usuario 
    var dataTable = $('#usuarios_activos').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url: $BASE_URL + "usuario/listar_usuarios",
            type:"POST"
        },
        "columnDefs":[
            {
                "orderable":false,
            },
        ],
    });
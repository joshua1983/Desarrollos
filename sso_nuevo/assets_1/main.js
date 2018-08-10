$(document).ready(function() {
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).attr('data-for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            //Completed slidetoggle
            if(idFor.is(':visible'))
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
            }
            else
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
            }
        })
    });

    $("#guardar").on('click', function(e){
        // actualizar datos del usuario
        let nombre = $("#nombre").val();
        let apelldios = $("#apellidos").val();
        let correo = $("#correo").val();


    });


    $('[data-toggle="tooltip"]').tooltip();


    moment.locale("es");
    var fecha = moment().format('MMMM Do YYYY');
    $("#div_fecha").html(fecha);
});
import {request} from '../request';


$(document).ready(function () {

    //Configuración datepicker
    $('.input-daterange input').each(function () {
        $(this).datepicker(
            {
                format: 'dd-mm-yyyy',
                language: 'es',
                todayHighlight: true,
                todayBtn: 'linked',
                autoclose: true
            });
    });

    $('.input-daterange .start').datepicker('setStartDate', '0d')
        .on('changeDate', function (e) {
            $('.end').datepicker('setStartDate', e.date)
        });

    $('.end').datepicker().on('changeDate', function (e) {
        $('.start').datepicker('setEndDate', e.date)
    })


    //Llamada http
    $('#room_seeker').submit(function (event) {
        event.preventDefault();

        $('.room-seeker-results').empty();

        let $form = $(this);
        let data = $form.serialize()
        console.log(data);

        let result = request(
            $form.attr('url'),
            $form.attr('method'),
            $form.serialize(),
            '.room-seeker-results'
        );
    })

    // Modal
    $('#exampleModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })




});

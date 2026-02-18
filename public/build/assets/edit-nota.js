$(document).ready(function() {
    //ESTADISTICAS PARA NOTAS Y FOROS

    $('#btn-add-stat').on('click',function(e){
        stat_title = $('#stat_title').val();
        stat_value = $('#stat_value').val();
        /* stat_comparative = $('#stat_comparative').val(); */
        
        if(stat_title != "" && stat_value != ""){
            element = '<li class="list-group-item d-flex justify-content-between">';
            element += '<div>';
            element += '<h5 class="mt-2">'+stat_title+'</h5>';
            element += '<p>Valor: '+stat_value+'<br>';
            /* element += 'Comparativa: '+stat_comparative+'%</p>'; */
            element += '</div>';
            element += '<div class="text-right ">';
            element += '<a href="javascript:void(0)" class="btn-delete-stat btn btn-link text-danger">Eliminar</a>';
            element += '</div>';
            element += '<input type="hidden" name="stat_id[]" value="0">';
            element += '<input type="hidden" name="stat_title[]" value="'+stat_title+'">';
            element += '<input type="hidden" name="stat_value[]" value="'+stat_value+'">';
            element += '<input type="hidden" name="stat_comparative[]" value="0">';
            element += '</li>';
            $('#estadisticas-container').prepend(element);

            $('#stat_title,#stat_value').val('');
        }else{
            alert('Los campos de estadísticas son todos requeridos.');
        }
    });
    $('#estadisticas-container').on('click','.btn-delete-stat',function(e){
        var deleteID = $(this).data('id');
        if(deleteID){
            $('.items-to-delete-container').append('<input type="hidden" name="items_to_delete[]" value="'+deleteID+'" />')
        }
        $(this).parent('div').parent('.list-group-item').remove();
    });
});











/* 
 */
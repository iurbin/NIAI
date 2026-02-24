$(document).ready(function(){
    $('.btn-foro-item').on('click', function(e){
        e.preventDefault();
        id = $(this).data('id');
        url = $(this).attr('href');

        $.ajax({
            url: url + '?id='+id, // URL to the resource
            success: function(result){

                
                $("#forum-stats-container").html(result);
                
            }
        });
    });
});
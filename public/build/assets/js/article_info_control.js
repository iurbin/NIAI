$(document).ready(function(){
    $('.btn-article-info').on('click', function(e){
        e.preventDefault();
        id = $(this).data('id');
        url = $(this).attr('href');

        $.ajax({
            url: url + '?id='+id, // URL to the resource
            success: function(result){

                $('#article_info').modal('show');
                $(".article_info").html(result);
                
            }
        });
    });
})
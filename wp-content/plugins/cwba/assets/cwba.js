window.onload = function () {
    
    $('#access').DataTable( {
        "ordering": false,
        pageLength : 25,
      } );
    
    var url = window.location.href;    
    var teste = /informacoes/.test(url);
    /* CSS
    #postdivrich.postarea, .page-title-action{
    display: none;
    }
    */
    if(teste){
        $('.page-title-action').hide();
        $('#postdivrich.postarea').show();
    }
    else if($('#informacoes_icone_id .postmeta-informacoes').length > 0){
        $('.page-title-action').hide();
        $('#postdivrich.postarea').show();
    }
    else if($('#post_descricao_id .postmeta-post').length > 0){
        $('#postdivrich.postarea').hide();
        $('#postimagediv.postbox').addClass('postbox-full');
    }else{
        $('.page-title-action').show();
        $('#postdivrich.postarea').show();
    }

    $("#adminmenu #toplevel_page_cwba ul li.wp-first-item a").html("Sobre"); 
}

function upload_image(type, val) {
    aw_uploader = wp.media({
        title: 'Upload File',
        library: {
            uploadedTo: wp.media.view.settings.post.id
        },
        button: {
            text: 'Use this File'
        },
        multiple: false
    }).on('select', function () {
        var attachment = aw_uploader.state().get('selection').first().toJSON();
        var url = attachment.url.replace(window.location.origin, '').trim();
        if (type == 1) { //settings            
            $('#portal_input_' + val).val(url);
            $('#preview_portal_input_' + val).attr('src', url);
        }       
    }).open();
}
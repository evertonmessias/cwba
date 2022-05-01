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
        var url = attachment.url.split('/').splice(3, 6);
        url = url.join('/');
        if (type == 1) { //home
            $('#home_input_' + val).val("/" + url);  
            $('#preview_home_input_' + val).attr('src', "/" + url);          
        }
        if (type == 2) { //product
            $('#curso_pdf_' + val).val("/" + url);
            $('#curso_pdf_prev_' + val).attr('href', "/" + url);  
            $('#curso_pdf_prev_' + val).html('PDF');          
        }        
    }).open();   

}
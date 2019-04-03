/**
 * 
 * Rsr Images
 */ 
$.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
});

//var base_url = '';
var photo_counter = 0;
Dropzone.options.realDropzone = {

    uploadMultiple: false,
    parallelUploads: 100,
    maxFilesize: 1,
    acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
    previewsContainer: '#dropzonePreview',
    previewTemplate: document.querySelector('#preview-template').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'Remove',
    dictFileTooBig: 'Image is bigger than 8MB',

    // The setting up of the dropzone
    init:function() {

        var rsrId = $('#rsr_id').val();
        
        var myDropzone = this;

        $.get('rsr-getServerImages/'+rsrId, function(data) {    
            $.each(data.images, function (key, value) {   
                var mockFile = { name: value.original, size: value.size };
                myDropzone.emit("addedfile", mockFile);
                myDropzone.options.thumbnail.call(myDropzone, mockFile, value.server);
                myDropzone.emit("complete", mockFile);
        
                $('.serverfilename', mockFile.previewElement).val(value.server);
                photo_counter++;
                $("#photoCounter").text( "รูปภาพ (" + photo_counter + ")");
            });
        });

        this.on("removedfile", function(file) {
            $.ajax({
                type: 'POST',
                url: 'delete',
                data: {id: file.name, rsr_id: rsrId},
                dataType: 'html',
                success: function(data){
                    var rep = JSON.parse(data);
                    if(rep.code == 200)
                    {
                        photo_counter--;
                        $("#photoCounter").text( "รูปภาพ (" + photo_counter + ")");
                    }
                }
            });

        } );
    },
    error: function(file, response) {
        if($.type(response) === "string")
            var message = response; //dropzone sends it's own error messages in string
        else
            var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
        }
        return _results;
    },
    success: function(file,done) {
        photo_counter++;
        $("#photoCounter").text( "รูปภาพ (" + photo_counter + ")");
    }
}
"use strict";
var urlTo = '/observer/upload-tour-files';
var urlRemove = '/observer/remove-tour-file';

KTUtil.onDOMContentLoaded(function () {
    new Dropzone("#kt_tour_img", {
        url: projectBaseUrl+urlTo, // Set the url for your upload script location
        method: "post",
        maxFiles: 10,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        acceptedFiles: "image/*",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function() {
            this.on("sending", function(file, xhr, formData) {
                formData.append("fileType", "img");
                formData.append("tour_id", $('#tour_id').val());
            });
        },
        accept: function(file, done) {
            if (file.name == "wow.jpg") {
                done("Naha, you don't.");
            } else {
                done();
            }
        }
    });

    new Dropzone("#kt_tour_video", {
        url: projectBaseUrl+urlTo, // Set the url for your upload script location
        method: "post",
        maxFiles: 10,
        maxFilesize: 500, // MB
        addRemoveLinks: true,
        acceptedFiles: "video/*",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function() {
            this.on("sending", function(file, xhr, formData) {
                formData.append("fileType", "video");
                formData.append("tour_id", $('#tour_id').val());
            });
        },
        accept: function(file, done) {
            if (file.name == "wow.jpg") {
                done("Naha, you don't.");
            } else {
                done();
            }
        }
    });

    new Dropzone("#kt_tour_file", {
        url: projectBaseUrl+urlTo, // Set the url for your upload script location
        method: "post",
        maxFiles: 10,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        acceptedFiles: "application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function() {
            this.on("sending", function(file, xhr, formData) {
                formData.append("fileType", "file");
                formData.append("tour_id", $('#tour_id').val());
            });
            this.on("removedfile", function(file) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: projectBaseUrl+urlRemove,
                    dataType: "json",
                    data: {
                        'id': $('#file_id').val()
                    },
                });
            });
        },
        accept: function(file, done) {
            if (file.name == "wow.jpg") {
                done("Naha, you don't.");
            } else {
                done();
            }
        }
    });

    $("#kt_edit_tour_cancel").click(function () {
        window.location = projectBaseUrl+'/observer/projects/tour';
    });
});

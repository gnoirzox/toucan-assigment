  $(document).ready(function() {
    $('#create-student-form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                        stringLength: {
                        min: 2,
                    },
                        notEmpty: {
                        message: 'Please supply your full name'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            },
            school: {
                validators: {
                    notEmpty: {
                        message: 'Please select your school'
                    }
                }
            }
        }
    });

    $('#select-school-form').submit(function() {
        event.preventDefault()

        var action = $('select-school-form').attr("action").toLowerCase();
        var values = $('select-school-form').serialize().split("&");

        for (var i = 0; i < values.length; i++) {
            var tokens = values[i].split("=");
            action = action.replace("{" + tokens[0].toLowerCase() + "}", tokens[1]);
        }

        window.location.href = action;
    });
});

$(document).ready(function(){

    $('.input-daterange').datepicker({
        format:"dd/mm/yyyy",
        startDate:"+0d"
    });

    $('#roomBookForm').validate({
        rules : {
            'customer-name' : {
                required: true,
            },
            'customer-email' : {
                required: true,
                email : true
            },
            'customer-phone' : {
                required: true,
                minlength:6,
            },
            'person-count' : {
                required: true,
                range: [0, 100]
            },
            'date-start' : {
                required: true,
            },
            'date-end' : {
                required: true,
            },
        },
        onfocusout: function(element) {
            $(element).valid();
        },
        submitHandler: function(form) {
            $form = $(form); 
            $loader = $(".result .loader");      
            $success = $(".result .alert-success");
            
            $loader.show();
            $form.hide();
            var jqxhr = $.post( "api/confirm_booking.php", $form.serialize(), function(result) {
                if(result == 'success'){
                    $success.show();                  
                }
                else{
                    console.log(result);
                    $form.show();
                    $form.find(".alert-danger").show();
                }
            })
            .fail(function() {
                $form.show();
                $form.find(".alert-danger").slideDown();
            })
            .always(function() {
                $loader.hide();
            });
        }

    });
        
    
});
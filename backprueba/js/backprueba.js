// backprueba drupal
jQuery("#edit-submit").on("click", function()
   {
    /* Validar el formulario */
    jQuery("#registrodata-form").validate
         ({
             rules: 
             {
               nombre: {
               	required: true,
               	minlength: 2, 
               	maxlength: 50
               },
               identificacion: {
               	required: true,
      			step: 10,
      			email: true,
               },

               

             },
             messages: 
             {
               nombre: {
               	required: 'El campo es requerido', 
               	minlength: 'El mínimo permitido son 2 caracteres', 
               	maxlength: 'El máximo permitido son 50 caracteres'
               },
               identificacion: 'El campo correo no es correcto y es requerido',
             }
         });
 });
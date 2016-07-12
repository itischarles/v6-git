/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


 $( "a.manageRolesPermissions" ).on( "click", function(e) {
      
     // return false;
     // e.preventDefault();
      var uri = $(this).attr('href');
     
     $.ajax({
	   // type : form.attr("method"),
	    url : uri,
	    data : {},
	    success : function(response) {

	    }
    }).fail(function() { //change the error handler to use ajax callback because of the async nature of Ajax
        alert("there was error adding this item");

    }).done(function(response) {
        if(response.error == 1){
            $('#feedback_msg').html("<div class='alert alert-danger'> "+response.error_msg+" </div>");

            return false;
         }
         else{
            // dialog.dialog( "close" );
             //  window.location.reload();
             //invoice_reloadInvoiceTheme(); 
         }
    });
      
      
      
     
});
    

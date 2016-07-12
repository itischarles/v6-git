/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */






$(function(){
    
    $('.ls-modal').on('click', function(e){
     e.preventDefault();
     $('#manageRolesPermissions').modal('show').find('.modal-body').load($(this).attr('href'));
   });
   
   
   $('#updateUserRoles form').on('submit', function(e){
       e.preventDefault();
        var form = $('#updateUserRoles form');       
        $.ajax({
            type : 'POST',
            url : form.attr("action"),
            data : form.serialize(),
            dataType: "json",
            success : function(response) {
                console.log(response);
        }
        }).fail(function(response) { //change the error handler to use ajax callback because of the async nature of Ajax
           // alert("there was error adding this item"+ response);

        }).done(function(response) {
            if(response.error == 1){
                $('#feedback_msg').html("<div class='alert alert-danger'> "+response.message+" </div>");

                return false;
             }
             else{
                $('#feedback_msg').html("<div class='alert alert-success'> "+response.message+" </div>");
             }
        });
       
   });

  return false;
});





 function manageRolePermForm(formID){
     
  
    var form = $('#formID_'+formID);       
    $.ajax({
        type : 'POST',
        url : form.attr("action"),
        data : form.serialize(),
        dataType: "json",
        success : function(response) {
            console.log(response);
    }
    }).fail(function() { //change the error handler to use ajax callback because of the async nature of Ajax
            alert("there was error adding this item");

    }).done(function(response) {
        if(response.error == 1){
            $('#feedback_msg').html("<div class='alert alert-danger'> "+response.message+" </div>");

            return false;
         }
         else{
            $('#feedback_msg').html("<div class='alert alert-success'> "+response.message+" </div>");
         }
    });
      
           
            
     return false;

 }

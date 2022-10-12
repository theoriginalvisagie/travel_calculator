function updateUserDetails(value){
    var formData = $("#userDetaislForm_"+value).serialize();

    $.ajax({  
        type: 'POST',  
        url: '/Immortal/admin/Modules/Users/ajax/getUsersAjax.php', 
        data: {action:'updateUserDetails', formData:formData,value:value},
        success: function(response) {
            if(response == "success"){
                Swal.fire({
                    title: 'Updated',
                    text: 'Your profile was successfully updated',
                    icon: 'success',
                    confirmButtonColor: '#00D1FF',
                    confirmButtonText: 'Okay'
                })
            } 
        }
    }); 
}
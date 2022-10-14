function updateValue(value, table, id, column){
    $.ajax({  
        type: 'POST',  
        url: rootDirectory +'/admin/Modules/EmployeesClass/Ajax/getAjax.php', 
        data: {action:'updateValue', value:value, table:table, id:id, column:column},
        success: function(response) {
            console.log(response);
            if(response == "true"){
                document.getElementById("saveDiv").style.display = "block";
                setTimeout(function() {
                    document.getElementById("saveDiv").style.display = "none";
                }, 1000);
            }else{

            }
        }   
    });
}

function getSwalMessage(){
    Swal.fire({
        title: 'Up To Date',
        text: 'The data is up to date!',
        icon: 'success',
        confirmButtonColor: '#00D1FF',
        confirmButtonText: 'Okay'
    })
}
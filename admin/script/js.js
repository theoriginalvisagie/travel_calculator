function openModal(id,table,action){
    if(action == "Add"){
        $.ajax({  
            type: 'POST',  
            url: '/Immortal/admin/Ajax/ajax.php', 
            data: {action:'addNewEntry', table:table},
            dateType: "html",
            success: function(html) {
                if(html != ""){
                    document.getElementById("actionButton").innerHTML = "<button class='button go' onclick='saveEntry(\""+table+"\")'>Save</button>";
                    document.getElementById("modalBody").innerHTML = html;
                    document.getElementById("modalHeader").innerHTML = action + " Entry";
                    $("#exampleModal").modal('show');
                }
            }
        }); 
    }else if(action == "Edit"){
        $.ajax({  
            type: 'POST',  
            url: '/Immortal/admin/Ajax/ajax.php', 
            data: {action:'getModalContentEdit', table:table, id:id},
            dateType: "html",
            success: function(html) {
                if(html != ""){
                    if(action == "Edit"){
                        document.getElementById("actionButton").innerHTML = "<button class='button go' onclick='saveEntry(\""+table+"\",\""+action+"\")'>Update</button>";
                    }
                    document.getElementById("modalBody").innerHTML = html;
                    document.getElementById("modalHeader").innerHTML = action + " Entry";
                    $("#exampleModal").modal('show');
                }
            }
        }); 
    }
    
}

function removeEntry(id,table,action){
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this entry?",
        icon: 'warning',
        iconColor: 'red',
        showCancelButton: true,
        confirmButtonColor: '#00D1FF',
        cancelButtonColor: '#F52323',
        confirmButtonText: 'Yes, Delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({  
                type: 'POST',  
                url: '/Immortal/admin/Ajax/ajax.php', 
                data: {action:'removeEntry', table:table, id:id},
                success: function(response) {
                    if(response == "true"){
                        Swal.fire({
                            title: 'Removed!',
                            text: 'Your entry was successfully removed',
                            icon: 'success',
                            confirmButtonColor: '#00D1FF',
                            confirmButtonText: 'Okay'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                }
            });
        }else{
            location.reload();
        }
    })

}

function saveEntry(table, action = ""){
    if(action == "Edit"){
        var formData = $('#editEntryForm').serialize();
        $.ajax({  
            type: 'POST',  
            url: '/Immortal/admin/Ajax/ajax.php', 
            data: {action:'updateEntry', table:table, formData:formData},
            success: function(response) {
                if(response == "true"){
                    Swal.fire({
                        title: 'Saved!',
                        text: 'Your entry was successfully updated',
                        icon: 'success',
                        confirmButtonColor: '#00D1FF',
                        confirmButtonText: 'Okay'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }else{
    
                }
            }
        });
    }else{
        var formData = $('#newEntryForm').serialize();
        $.ajax({  
            type: 'POST',  
            url: '/Immortal/admin/Ajax/ajax.php', 
            data: {action:'saveNewEntry', table:table, formData:formData},
            success: function(response) {
                console.log(response);
                if(response == "true"){
                    Swal.fire({
                        title: 'Saved!',
                        text: 'Your entry was successfully added',
                        icon: 'success',
                        confirmButtonColor: '#00D1FF',
                        confirmButtonText: 'Okay'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }else{
    
                }
            }
        });
    }
    
}

function openSearch(table){
    var search = document.getElementById("tableSearch_"+table);
    if(search.style.display === "none"){
        search.style.display = "table-row";
    }else{
        search.style.display = "none";
    }
   
}

function closeModal(table){
    $("#exampleModal").modal('hide');
}

function getOppositeIcon(iconID,name){
    $("#"+iconID+"_"+name+"_icon").toggleClass("fa-circle-arrow-down fa-circle-arrow-up");

    // $.ajax({  
    //     type: 'POST',  
    //     url: '/Immortal/admin/Ajax/ajax.php', 
    //     data: {action:'sortTable', table:table, formData:formData},
    //     dateType: "html",
    //     success: function(html) {
    //         console.log(response);
    //         if(response == "true"){
               
    //         }
    //     }
    // });
}

function getnextTablePage(pageNo,table){
    $.ajax({  
        type: 'POST',  
        url: rootDirectory +'/admin/Ajax/ajax.php', 
        data: {action:'getnextTablePage', pageNo:pageNo,table:table},
        success: function(response) {
            location.reload();
        }   
    });
}


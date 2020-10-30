$(document).ready(function(){
  $.ajax({
      url:'Processes.php',
      type:'GET',
      success:function(response){
        $("#large").html(response);
      }
  });
  $('#show_all').click(function(){
    $('.completed').show();
    $('.uncompleted').show();
  });
  $('#show_active').click(function(){
    $('.completed').hide();
    $('.uncompleted').show();
  });
  $('#show_completed').click(function(){
    $('.uncompleted').hide();
    $('.completed').show();
  });

  $("#record_add_form").submit(function(e){

    $.ajax({
      type: "POST",
      url: "Processes.php",
      data: $("#record_add_form").serialize(),
      success: function(response){
        $('#record_add_form')[0].reset();
        location.reload();
        alert(response);
      }
    })
    e.preventDefault();
  });
  
  $('#delete').click(function(e){
    e.preventDefault();
    if(confirm("Are you sure you want to delete this?")){

      var id_for_deletion = [];

      $(':checkbox:checked').each(function(i){
        id_for_deletion[i] = $(this).val();
      });

      if(id_for_deletion.length === 0){
        alert("Please select at least one record!");
      }
      else{
        var operation = 'delete';
        $.ajax({
          type: "POST",
          url: "Processes.php",
          data: $("#record_delete_form").serialize() + "&operation="+ operation,
          success: function(data){
            console.log(data);
            for(var i = 0; i<id_for_deletion.length; i++){
              $('#'+id_for_deletion[i]).fadeOut('slow');
            }
            $('#record_delete_form')[0].reset(); 
            location.reload();
            alert('Deleted successfully!');
          },
          error:function(){
            alert('Error deleting');
          }
        })
      }
    }
  }); 
  
  $('#mark').click(function(){

    var id = [];
    var operation = 'mark';

    $(':checkbox:checked').each(function(k){
      id[k] = $(this).val();
    });

    $.ajax({
      url:'Processes.php',
      type:'POST',
      data: $("#record_delete_form").serialize() + "&operation="+ operation,
      success:function(data){
        for(var i = 0; i<id.length; i++){
          $('#'+id[i]).removeClass('uncompleted');
          $('#'+id[i]).addClass('completed');
        }
        $('#record_delete_form')[0].reset(); 
      }
  });
  })

  $('#clear').click(function(){

    if(confirm('Are you sure you want to clear the completed?')){

      var completed = [];
      var operation = 'clear';
    
      $(".completed").each(function(){
      completed.push($(this).attr("id"));
      });

      $.ajax({
        url:'Processes.php',
        type:'POST',
        data: {completed, operation},
        success:function(){
          $('.completed').fadeOut('slow');
          location.reload();
        }
      });
    }
  })

  $('#edit').click(function(){

    var id = [];

    $(':checkbox:checked').each(function(k){
      id[k] = $(this).val();
    });

    if(id.length === 0 || id.length > 1){
      alert('You must select one item for editing!');
      $('#record_delete_form')[0].reset(); 
    }
    else if($('#'+ id[0]).hasClass("completed")){
      alert('You cannot edit already completed task!');
      $('#record_delete_form')[0].reset();
    }
    else{
      var editing_form = ('<div id = "'+ iD +'" class = "bloks uncompleted" style = "background-color: rgb(186, 202, 245)"><div class = "bloks2"><div class = "form"><form class = "ajax" id = "record_edit_form" action="Edit_record.php" method = "post"><div class="md-form"><input id = "edit" type="text" name = "edit_record" class="form-control" placeholder = "Edit record"><input id = "submit2" type = "submit" value = "Edit" name = "editRecord"></div></form></div><br><br></div></div>');
      var iD = id[0];

      alert('Now edit the record!');
      
      $('#'+ iD).replaceWith(editing_form);
      $("#record_edit_form").submit(function(e){

        var iD = id[0];
        $.ajax({
          type: "POST",
          url: "Processes.php",
          data: $("#record_edit_form").serialize() + "&iD="+iD,
          success: function(data){
            alert(data);    
            $('#record_edit_form')[0].reset();
            location.reload();
          }
        })
        e.preventDefault();
      });
    }
  })
})
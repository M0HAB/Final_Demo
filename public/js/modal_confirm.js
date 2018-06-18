//bind some data to the opened modal from the create post button
$('#confirm').on('show.bs.modal', function (event) {
  var reply_id;
  var button = $(event.relatedTarget);
  var type = button.data('type');
  if (type == "comment"){
    reply_id = button.data('reply');
  }
  var id = button.data('id');
  var modal = $(this);
  if(button.data('keep') == 2){
      modal.find('#modal_title').html('Are you sure you want to restore this?');
      modal.find('#delete').html('Restore');
      modal.find('#delete').removeClass('btn-danger');
      modal.find('#delete').addClass('btn-info');
  }else{
      modal.find('#modal_title').html('Are you sure you want to delete this?');
      modal.find('#delete').html('Delete');
      modal.find('#delete').removeClass('btn-info');
      modal.find('#delete').addClass('btn-danger');
  }
  modal.find('#delete').off('click').on("click", function (event) {
    payload = {
      api_token: api_token,
      id: id,
      _method: "delete"
    };
    headers = {
      headers: {
          'X-Requested-With': 'XMLHttpRequest'
      }
    };
    if(type == 'depspec'){
        payload['dep_id'] = button.data('depid');
    }
    axios.post('/api/'+type+'/'+id+'/delete',payload,headers)
    .then( (response) => {
        if(response.data){
          if(button.data('redirect')){
            window.location.href = '/user/dashboard';
          }
          if(type == "comment"){
            comments = $('#reply_container_'+reply_id+' .comments');
            comments.text(comments.text()-1);
          }
          if(!button.data('keep')){
              $("#"+type+"_container_"+id).remove();
              if(type == "depspec"){
                  toastr.success("Department Updated Successfully");
              }else{
                  toastr.success(type+ " deleted successfully");
              }
          }else{
              if(button.data('keep') == 2){
                  button.removeClass('btn-info');
                  button.addClass('btn-danger');
                  button.html('<span class="fas fa-trash"></span>');
                  button.data('keep', "3");
                  toastr.success("User Restored Successfully");

              }else{
                  button.removeClass('btn-danger');
                  button.addClass('btn-info');
                  button.html('<span class="fas fa-undo"></span>');
                  button.data('keep', "2");
                  toastr.success("User Deleted Successfully");
              }
          }
          $("#confirm #close").click();

        }else{
          toastr.warning("Something went Wrong");

        }

    })
    .catch(function (error) {
        console.log(error);
      toastr.warning("Something went Wroaang");
    });

  })
});

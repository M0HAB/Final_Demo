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
          $("#"+type+"_container_"+id).remove();
          $("#confirm #close").click();
          if(type == "depspec"){
              toastr.success("Department Updated Successfully");
          }else{
              toastr.success(type+ " deleted successfully");
          }
        }else{
          toastr.warning("Something went Wrong");

        }

    })
    .catch(function (error) {
      toastr.warning("Something went Wrong");
    });

  })
});

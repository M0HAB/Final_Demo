//bind some data to the opened modal from the create post button
$('#confirm').on('show.bs.modal', function (event) {
  var post_id;
  var button = $(event.relatedTarget);
  var type = button.data('type');
  if (type == "reply"){
    post_id = button.data('post');
  }
  var id = button.data('id');
  var modal = $(this);
  modal.find('#delete').off('click').on("click", function (event) {
    payload = {
      api_token: api_token,
      id: id
    };
    headers = {
      headers: {
          'X-Requested-With': 'XMLHttpRequest'
      }
    };
    axios.post('/api/'+type+'/delete',payload,headers)
    .then( (response) => {
        if(response.data){
          if(type == "reply"){
            $('#post_footer_'+post_id).html(response.data);
          }else{
            $("#"+type+"_container_"+id).remove();
          }
          $("#confirm #close").click();
          toastr.success(type+ " deleted successfully");
        }else{
          toastr.warning("Something went Wrong");

        }

    })
    .catch(function (error) {
      console.log(error);
    });

  })
});

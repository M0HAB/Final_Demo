//define toolbarOptions for quill WYSIWYG text editor

var allowedtypes = ['jpg', 'jpeg', 'png', 'pdf'];
var unknowSrc = "/images/file.png";
var dropZone = new dropBoxInput('list','drop_zone',allowedtypes,unknowSrc);


//function applied onClick of Vote button in discussion, make ajax call to save vote and receive new reply data
//id: reply id
function vote(id){
  approvebtn = $('#reply_container_'+id+' .approve');
  votebtn = $('#reply_container_'+id+' .vote');
  badge = $('#reply_container_'+id+' .lbl');
  frame = $('#reply_container_'+id);
  reply_msg = $('#reply_container_'+id+' .reply_msg');
  votes = $('#reply_container_'+id+' .votes');
  comments = $('#reply_container_'+id+' .comments');
  vote_tooltip = $('#reply_container_'+id+' .vote_link');
  comments_tooltip = $('#reply_container_'+id+' .comment_link');
  axios.post('/api/vote/'+id+'/set',{
    id: id,
    api_token : api_token
  })
  .then( (response) => {
    frame.find('#reply-'+id).html(response.data.comments_body);
    reply = response.data.reply;
    reply_msg = reply.body;
    votes.text(response.data.votes);
    comments.text(response.data.comments);
    if(response.data.voters){
      vote_tooltip.attr('title','');
      response.data.voters.forEach((element,idx,array)=>{
        old = vote_tooltip.attr('title');
        if (idx === array.length - 1){
          vote_tooltip.attr('title', old+element);
          return;
        }
        vote_tooltip.attr('title', old+element+"\n");
      });
    }else{
      vote_tooltip.attr('title', "");
    }

    if(reply.approved == 1){
      (frame.hasClass('best-solution') || frame.addClass('best-solution'));
      (badge.hasClass('best-solution-show-lbl') || badge.addClass('best-solution-show-lbl'));
      (!badge.hasClass('best-solution-hide-lbl') || badge.removeClass('best-solution-hide-lbl'));
    }else{
      (!frame.hasClass('best-solution') || frame.removeClass('best-solution'));
      (!badge.hasClass('best-solution-show-lbl') || badge.removeClass('best-solution-show-lbl'));
      (badge.hasClass('best-solution-hide-lbl') || badge.addClass('best-solution-hide-lbl'));
    }
    if(response.data.btn){
      if(response.data.approve){
        (approvebtn.hasClass('btn-success active') || approvebtn.addClass('btn-success active'));
        (!approvebtn.hasClass('btn-light') || approvebtn.removeClass('btn-light'));
      }else{
        (votebtn.hasClass('btn-primary active') || votebtn.addClass('btn-primary active'));
        (!votebtn.hasClass('btn-light') || votebtn.removeClass('btn-light'));
      }
    }else{
      if(response.data.approve){
        (!approvebtn.hasClass('btn-success active') || approvebtn.removeClass('btn-success active'));
        (approvebtn.hasClass('btn-light') || approvebtn.addClass('btn-light'));
      }else{
        (!votebtn.hasClass('btn-primary active') || votebtn.removeClass('btn-primary active'));
        (votebtn.hasClass('btn-light') || votebtn.addClass('btn-light'));
      }
    }

  })
  .catch(function (error) {
    console.log(error);
    toastr.warning("Something went Wrong");
  });
}

$('#comment').on('show.bs.modal', function (event) {


});
//bind some data to the opened modal from the create post button
$('#req').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget),//button that triggered the event
      type = button.data('type'),//type of request that will be used in modal
      mode = button.data('mode'),//
      modal = $(this),//hook modal variable to this instance
      title_area = modal.find("#req_title_area");//hook title_area variable to div inside modal

  //Delete Input data on clicking close button
  modal.find('#close').off('click').on("click", function (event) {
    modal.find("#req_title").val("");
    $('#req_body').val("");
    dropZone.clearBox();
  });

  //populating fields and setting requestURL
  if(mode == "edit"){
    requestURL = "/api/editRecord";
    modal.find('#modal_title').text("Edit "+type);
    modal.find('#submit_req').text("Confirm edit");
    id = button.data("id");
    body = $('#'+type+'_container_'+id+' .edit_body').text();
    files = $('#'+type+'_container_'+id+' .edit_image').text().split(",").filter(function(e){return e;});
    dropZone.clearBox();
    files.forEach((element)=>{
      dropZone.listPut({
            name:element.split('/').pop(),
            type:element.split(';')[0],
            src:element.split(';').pop()
      });
    })
    console.log("editing");
    modal.find('#req_body').val(body);
    if(type == "post"){
      title_area.show();
      title = $('#post_container_'+id+' .edit_title').text();
      modal.find('#req_title').val(title);
    }else if (type == "reply") {
      title_area.hide();
    }

  }else{
    if(type == "reply"){
      title_area.hide();
      id = button.data("id");
    }else if (type == "post") {
      title_area.show();
    }
    requestURL = '/api/newRecord';
    modal.find('#modal_title').text("Create new "+type);
    modal.find('.btn-text-modal').text("Submit "+type);
  }

  //on clicking submit assign values and prepare payload,headers then send ajax request
  modal.find('#submit_req').off('click').on("click", function (event) {
    body = $('#req_body').val();
    if(!body){
      console.log(body);
      toastr.warning("All Text fields are required");
      return 0;
    }
    headers = {
      headers: {
          'X-Requested-With': 'XMLHttpRequest'
      }
    };
    payload = {
      api_token: api_token,
      type: type,
      body: body,
    };
    if(type == "post"){
      title = $("#req_title").val();
      payload["file_list"]= dropZone.list;
      if(!title){
        toastr.warning("All fields are required");
        return 0;
      }
      payload["title"] = title;
      if (mode == "edit"){
        payload["delete_list"]= dropZone.deleteList;
        payload["id"] = id;
      }else{
        payload["discussion_id"] = discussion_id;
        payload["module_id"] = module_id;
      }

    }else if (type == "reply") {
      payload["file_list"]= dropZone.list;
      if (mode == "edit"){
        payload["delete_list"]= dropZone.deleteList;
        payload["id"] = id;
      }else{
        payload["post_id"] = id;
      }
    }
    //send ajax request with url and payload assigned previously
    axios.post(requestURL,payload,headers)
    .then( (response) => {
      if(response.data.error){
        toastr.warning(response.data.message);
      }else{
        $('#req_body').text("");
        $("#req .close").click();
        modal.find("#req_title").val("");
        $('#req_body').val("");
        dropZone.clearBox();
        dropZone.deleteList=[];
        if (type == "post"){
          $("#req_title").val("");
          if (mode == "edit"){
            $('#post_container_'+id+' .edit_title').text(response.data.record.title);
            $('#'+type+'_container_'+id+' .edit_body').html(response.data.record.body);
            $('#'+type+'_container_'+id+' .edit_image').text("");
            $('#post_container_'+id+' .carousel-indicators').html('');
            $('#post_container_'+id+' .carousel-inner').html('');
            let counter=0;
            response.data.srcs.forEach((element)=>{
              if(element.type == "image"){
                $('#post_container_'+id+' .carousel-indicators').append('<li data-target="#carouselExampleIndicators" data-slide-to="'+counter+'" '+((counter==0)? 'class="active"':'')+' ></li>');
                $('#post_container_'+id+' .carousel-inner').append(
                  '<div class="carousel-item'+
                  ((counter==0)? ' active':'') +'"><a href="'+element.filename+'" data-lightbox="test">'+
                  '<img class="d-block w-100" src="'+element.filename+'" alt="slide '+counter+'"></a></div>'
                );
                  counter++;
              }
              $('#'+type+'_container_'+id+' .edit_image').append(element.type+";"+element.filename+",");
            });
            //edit srcs display
            toastr.success("Post Edited Successfully");
          }else{
            $("#posts").prepend(response.data.body);
            toastr.success("Post Submitted Successfully");
          }
        }else if (type == "reply") {
          if (mode == "edit"){
            $('#'+type+'_container_'+id+' .edit_body').html(response.data.record.body);
            $('#'+type+'_container_'+id+' .edit_image').text("");
            response.data.srcs.forEach((element)=>{
              $('#'+type+'_container_'+id+' .edit_image').append(element.type+";"+element.filename+",");
            });
            toastr.success("Reply Edited Successfully");
          }else{
            $('#reply_container').prepend(response.data.body);
            toastr.success("Reply Submitted Successfully");
          }

        }
      }


    })
    .catch(function (error) {
      console.log(error);
      toastr.warning("Something went Wrong");
    });
  })


});


$('#search').keyup(function (key) {
  if($(this).val().length > 0 && key.keyCode == 13){
    axios.get('/api/'+discussion_id+'/search',
    {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      params:{
        api_token: api_token,
        q: $(this).val(),
      }
    })
    .then( (response) => {
      $('#search_body').html(response.data.body);
    })
    .catch(function (error) {
      toastr.warning("Something went Wrong");
    });
  }
});

function view_replies(id) {
  axios.get('/api/'+id+'/replies',{
    params:{api_token: api_token}
  })
  .then( (response) => {
    $('#post_footer_'+id).html(response.data);

  })
  .catch(function (error) {
    toastr.warning("Something went Wrong");
  });
}

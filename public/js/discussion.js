//define toolbarOptions for quill WYSIWYG text editor
var toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  ['blockquote', 'code-block'],
  ['image'],
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction
  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'align': [] }],
  ['clean']                                         // remove formatting button
];

//init quill WYSIWYG text editor and bind to div ("post_body") with toolbar and theme snow['added in CSS']
var quill = new Quill('#req_body', {
    modules: {
      toolbar: toolbarOptions
    },
    placeholder: "Type here...",
    bounds: document.body,
    theme: 'snow'
});

//function applied onClick of Vote button in discussion, make ajax call to save vote and receive new reply data
//id: reply id, post_id: post id
function vote(id,post_id){
  axios.post('/api/vote/'+id+'/set',{
    id: id,
    api_token : api_token
  })
  .then( (response) => {
    $('#post_footer_'+post_id).html(response.data);
  })
  .catch(function (error) {
    console.log(error);
  });
}

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
    quill.container.firstChild.innerHTML = "";
    quill.container.lastChild.innerHTML = "";
  });

  //populating fields and setting requestURL
  if(mode == "edit"){
    requestURL = "/api/editRecord";
    modal.find('#modal_title').text("Edit "+type);
    modal.find('#submit_req').text("Confirm edit");
    id = button.data("id");
    body = $('#'+type+'_container_'+id+' .edit_body').html();
    quill.container.firstChild.innerHTML = body;

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
    modal.find('#submit_req').text("Submit "+type);
  }

  //on clicking submit assign values and prepare payload,headers then send ajax request
  modal.find('#submit_req').off('click').on("click", function (event) {
    body = quill.container.firstChild.innerHTML;
    headers = {
      headers: {
          'X-Requested-With': 'XMLHttpRequest'
      }
    };
    payload = {
      api_token: api_token,
      type: type,
      body: body
    };
    if(type == "post"){
      title = $("#req_title").val();
      payload["title"] = title;
      if (mode == "edit"){
        payload["id"] = id;
      }else{
        payload["discussion_id"] = discussion_id;
        payload["module_id"] = module_id;
      }

    }else if (type == "reply") {
      if (mode == "edit"){
        payload["id"] = id;
      }else{
        payload["post_id"] = id;
      }
    }
    //send ajax request with url and payload assigned previously
    axios.post(requestURL,payload,headers)
    .then( (response) => {
      if(response.data == "0"){
        alert("max image size is 1MB");
      }else{
        quill.container.firstChild.innerHTML = "";
        quill.container.lastChild.innerHTML = "";
        $("#req .close").click();
        if (type == "post"){
          $("#req_title").val("");
          if (mode == "edit"){
            $('#post_container_'+id+' .edit_title').text(response.data.title);
            $('#'+type+'_container_'+id+' .edit_body').html(response.data.body);
            toastr.success("Post Edited Successfully");
          }else{
            $("#posts").append(response.data.body);
            toastr.success("Post Submitted Successfully");
          }
        }else if (type == "reply") {
          if (mode == "edit"){
            $('#'+type+'_container_'+id+' .edit_body').html(response.data.body);
            toastr.success("Reply Edited Successfully");
          }else{
            $('#post_footer_'+id).html(response.data.body);
            toastr.success("Reply Submitted Successfully");
          }

        }
      }


    })
    .catch(function (error) {
      console.log(error);
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
      console.log(error);
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
    console.log(error);
  });
}

//define toolbarOptions for quill WYSIWYG text editor
var toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  ['blockquote', 'code-block'],
  ['link', 'image'],
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown

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
});

//function appliend onClick of Vote button in discussion, make ajax call to save vote and receive new reply data
//id: reply id
function vote(id){
  axios.post('/api/vote/'+id+'/set',{
    id: id,
    api_token : api_token
  })
  .then( (response) => {
    $('#reply_body_'+id).html(response.data);
  })
  .catch(function (error) {
    console.log(error);
  });
}
//bind some data to the opened modal from the create post button
$('#req').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var type = button.data('type');
  if(type == "Reply"){
    $("#req_title_area").hide();
  }else{
    $("#req_title_area").show();
  }
  var modal = $(this);
  modal.find('#modal_title').text("Create new "+type);
  modal.find('#submit_req').on("click", function () {

    if(type == "Post"){
      var post_body = quill.container.firstChild.innerHTML;
      var title = $("#req_title").val();
      axios.post('/api/newRecord',{
        api_token: api_token,
        type: "post",
        discussion_id: discussion_id,
        module_id: module_id,
        title: title,
        body: post_body
      })
      .then( (response) => {
        if(response.data == "0"){
          alert("max size is 1MB");
        }else{
          $("#req_title").val("");
          quill.container.firstChild.innerHTML = "";
          quill.container.lastChild.innerHTML = "";
          $("#posts").append(response.data);
        }

      })
      .catch(function (error) {
        console.log(error);
      });
    }else if (type == "Reply") {
      var reply_body = quill.container.firstChild.innerHTML;
      var id = button.data("id");
      axios.post('/api/newRecord',{
        api_token: api_token,
        type: "reply",
        post_id: id,
        body: reply_body
      })
      .then( (response) => {
        if(response.data == "0"){
          alert("max size is 1MB");
        }else{
          quill.container.firstChild.innerHTML = "";
          quill.container.lastChild.innerHTML = "";
          $('#replies_'+id).html(response.data);
        }

      })
      .catch(function (error) {
        console.log(error);
      });
    }

  })
});


function view_replies(id) {
  //change to get lama el net yege we shof el auth ezay
  axios.post('/api/'+id+'/replies',{
    api_token: api_token,
  })
  .then( (response) => {
    $('#replies_'+id).html(response.data);
    $('#btn_replies_'+id).removeClass("btn-primary");
    $('#btn_replies_'+id).addClass("btn-dark");
    $('#btn_replies_'+id).text("Add Reply");
    $('#btn_replies_'+id).val("add");
    $('#btn_replies_'+id).attr({
      "data-toggle":"modal",
      "data-target":"#req",
      "data-type":"Reply",
      "data-id":id
    });
    $('#btn_replies_'+id).removeAttr("onclick");

  })
  .catch(function (error) {
    console.log(error);
  });
}

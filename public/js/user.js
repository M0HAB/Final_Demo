
$('select#type').on('change', function () {
    if($(this).val() != 2){
        $('#levelGrp').hide();
    }else{
        $('#levelGrp').show();
    }
});
var oldQuery="";
var typingTimer;
var doneTypingInterval = 100;
var $input = $('#search');
$input.on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
});
$input.on('keydown', function () {
  clearTimeout(typingTimer);
});
function doneTyping () {
    let value = $('#search').val();
    if(value != oldQuery){
        oldQuery=value;
        let params = {
            api_token: api_token,
            name: $('#search').val(),
            type: $('select#type').val(),
            dep: $('select#dep').val()
        }
        if($('select#type').val() == 2){
            params['level'] = $('select#level').val();
        }
        axios.get('/api/search',
        {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
          params
        })
        .then( (response) => {
            $('#users_body').html(response.data.body);
        })
        .catch(function (error) {
            console.log(error);
        });
    }
}
$('#search').keyup(function (key) {


});


$('select#type').on('change', function () {
    console.log($(this).val() == 2);
    if($(this).val() != 2){
        $('#levelGrp').hide();
    }else{
        $('#levelGrp').show();
    }
});
$('#search').keyup(function (key) {
    let value = $(this).val();
    let params = {
        api_token: api_token,
        name: $(this).val(),
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
        $('#users_body').html('');
        let showLvl = true;
        $('#level_table').show();
        if(!response.data.users[0].level){
            $('#level_table').hide();
            showLvl = false;
        }
        response.data.users.forEach(function(element) {
            $('#users_body').append('<tr>');
            $('#users_body').append('<td><a href="'+profileRoute+'?id='+element.id+'">'+element.fname+' '+element.lname+'</a></td>');
            $('#users_body').append('<td>'+element.dep_id+'</td>');
            if(showLvl){
                $('#users_body').append('<td>'+element.level+'</td>');
            }
            $('#users_body').append('<td>'+element.email+'</td>');
            $('#users_body').append('</tr>');

        });
    })
    .catch(function (error) {
        console.log('asd');
    });
});

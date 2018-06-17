$( document ).ready(function(){
    $('#overlay').hide();
});


$('select#type').on('change', function () {
    if($(this).val() != 2){
        $('#levelGrp').hide();
    }else{
        $('#levelGrp').show();
    }
});
var oldQuery="";
$('#search').keyup(function (key) {
    let value = $(this).val();
    if(value != oldQuery){
        oldQuery=value;
        $('#overlay').show();
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
            if(response.data.users.length > 0){
                let showLvl = true;
                $('#level_table').show();
                if(!response.data.users[0].level){
                    $('#level_table').hide();
                    showLvl = false;
                }
                response.data.users.forEach(function(element) {
                    let btn;
                    if(element.trashed){
                        btn = '<button class="btn btn-info" type="submit" data-toggle="modal" data-target="#confirm" data-id="'+element.id+'" data-type="user" data-keep="2" title="UnDelete"><i class="fas fa-undo"></i></button>';
                    }else{
                        btn = '<button class="btn btn-danger" type="submit" data-toggle="modal" data-target="#confirm" data-id="'+element.id+'" data-type="user" data-keep="3" title="Delete"><i class="fas fa-trash"></i></button>';
                    }
                    $('#users_body').append('<tr>');
                    $('#users_body').append('<td><a href="'+profileRoute+'?id='+element.id+'">'+element.fname+' '+element.lname+'</a></td>');
                    $('#users_body').append('<td>'+element.dep_id+'</td>');
                    if(showLvl){
                        $('#users_body').append('<td>'+element.level+'</td>');
                    }
                    $('#users_body').append('<td>'+element.email+'</td>');
                    $('#users_body').append('<td>'+
                    '<a href="'+editRoute+'?id='+element.id+'"><button class="btn btn-success" title="Edit"><i class="fas fa-edit"></i></button></a> '+
                    btn+'</td>')
                    $('#users_body').append('</tr>');
                });

            }
            $('#overlay').hide();

        })
        .catch(function (error) {
            $('#overlay').hide();
            console.log(error);
        });
    }

});

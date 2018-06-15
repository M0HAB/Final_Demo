$('#search').keyup(function (key) {
    let value = $(this).val();
    axios.get('/api/search',
    {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      params:{
        api_token: api_token,
        name: $(this).val(),
      }
    })
    .then( (response) => {
        $('#users_body').html('');
        response.data.users.forEach(function(element) {
            $('#users_body').append('<tr>');
            $('#users_body').append('<td>'+element.fname+' '+element.lname+'</td>');
            $('#users_body').append('<td>'+element.dep_id+'</td>');
            $('#users_body').append('<td>'+element.level+'</td>');
            $('#users_body').append('<td>'+element.email+'</td>');
            $('#users_body').append('</tr>');

        });
    })
    .catch(function (error) {
      // toastr.warning("Something went Wrong");
    });
});

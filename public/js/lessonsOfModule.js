/*var url = "https://www.youtube.com/watch?v=jdqsiFw74Jk";
var video_id = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
if(video_id != null) {
    console.log("video id = ",video_id[1]);

} else {
    console.log("The youtube url is not valid.");
}*/

getVideo = function(url, title, description, recap){
    console.log(typeof(title));
    $.getJSON('https://noembed.com/embed',
        {format: 'json', url: url}, function (data, title, description) {
            $('#my-video').html(data.html);
            $('iframe').css('width', '100%');
            $('iframe').css('height', '400px');
        });
    $('#lesson-details').html('<h4 class="card-title text-muted" id="lesson-title">' + title +'</h4> <p id="lesson-description">' + description +'</p>');
    $('#lesson-recap').text(recap);


    /* $.ajax({
         url: 'https://www.googleapis.com/youtube/v3/videos?part=id%2Csnippet&id=5vY8EWokf40&key={YOUR_API_KEY}',
         format: 'json',
         success: function(){
             console.log('all is ok');
         },
         error: function(){
             console.log('error');
         }
     })*/
};

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


loadData = function(course_id, module_id){

    $.ajax({
        url:  module_id + '/lessons',
        method: 'POST',
        success: function(response){
            console.log(response.data.length);
            if(response.data.length > 0){
                var i = 0;
                for(i; i < response.data.length; i++){
                    $('#module-lessons').append('<tr><td><button  style="border: none;background-color: transparent;cursor: pointer" class="font-weight-bold forum-nav text-success lesson-btn" onClick="getVideo(\'' + response.data[i].url  + '\', \'' + response.data[i].title  + '\', \'' + response.data[i].description  + '\', \'' + response.data[i].recap  + '\')">' + response.data[i].title  + '</button></td></tr>');
                }
                var url = response.data[0].url;
                var title = response.data[0].title;
                var description = response.data[0].description;
                var recap = response.data[0].recap;
                $.getJSON('https://noembed.com/embed',
                    {format: 'json', url: url}, function (data) {
                        $('#my-video').html(data.html);
                        $('iframe').css('width', '100%').css('height', '400px');

                    });
                $('#lesson-details').html('<h4 class="card-title text-muted" id="lesson-title">' + title +'</h4> <p id="lesson-description">' + description +'</p>');
                $('#lesson-recap').text(recap);
                console.log(response.data[0].url);
            }else{
                $('#module-lessons').append('<p class="font-weight-bold text-muted ml-2 px-2 py-3">The module has not lessons yet</p>');

            }
        },
        error: function(){
            console.log('error')
        },
    });
};
$('body').load(loadData(courseID, moduleID));





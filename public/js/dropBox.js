function dropBoxInput(listdiv,dropZoneDivId,allowedTypes,unknowSrc){
    this.listdiv=listdiv;
    this.dropZoneDivId=dropZoneDivId;
    this.list = [];
    this.deleteList = [];
    this.allowedTypes=allowedTypes;
    this.dropZone = document.getElementById(this.dropZoneDivId);
    this.unknowSrc = unknowSrc;
    var that=this;

    this.clearBox = function(){
      that.list = [];
      document.getElementById(that.listdiv).innerHTML="";
    }
    this.disable = function(){
      $('#'+that.listdiv).hide();
      $('#'+that.dropZoneDivId).hide();
    }
    this.enable = function(){
      $('#'+that.listdiv).show();
      $('#'+that.dropZoneDivId).show();
    }
    this.listPut = function(file){
        that.list.push({
            name:file.name,
            type:file.type,
            src:file.src,
        });
        if(that.list.length == 1){
            that.list[0].id=0;
        }else{
            that.list[that.list.length-1].id = that.list[that.list.length-2].id+1;
        }
        thumb = (file.type.match('image.*'))? file.src:unknowSrc;
        var span = document.createElement('span');
        span.setAttribute('id', 'file-'+that.list[that.list.length-1].id);
        span.innerHTML = '<div class="card float-left ml-2 mb-1 " style="width: 5rem;" id="div-1">'+
            '<img class="card-img-top" width="70px" height="70px" src="'+
            thumb
            +'" title="'+
            escape(file.name)
            +'"><div id="div-1a" data-role="fieldcontain" data-id="del-'+that.list[that.list.length-1].id+'">'+
            '<button class="btn btn-danger btn-sm rounded-0  delete-dropZoneImg"><i class="fas fa-times"></i></button></div></div>';
        document.getElementById(that.listdiv).insertBefore(span, null);
        classname = document.getElementsByClassName("delete-dropZoneImg");
        Array.from(classname).forEach(function(element) {
            element.addEventListener('click', that.listDel);
        });

    }

    this.listDel = function (){
        let id = $(this).closest('div').attr('data-id');
        let index;
        id = id.split("-").pop();
        that.list.forEach(function(element, i){
            if(element.id == id){
                index = i;
                return false;
            }
        });
        if (that.list[index].src.split(',')[0].split(';').pop() != "base64"){
          that.deleteList.push(that.list[index]);
        }
        that.list.splice(index, 1);
        $("#"+that.listdiv+" #file-"+id).remove();
        console.log(that.deleteList,that.list)
    }

    this.handleFileSelect = function (evt) {
        evt.stopPropagation();
        evt.preventDefault();
        var files = evt.dataTransfer.files; // FileList object
        var error = false;
        var msg="";
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {
            if((f.size/1024) > 2048){
                error=true;
                msg = "Cant Upload Files Bigger Than 2MB";
                continue;
            }
            if(!that.allowedTypes.includes(f.type.split("/").pop())){
                console.log(f.type);
                error=true;
                msg = "File Type Not Allowed";
                continue;
            }
            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // Render thumbnail.
                    skip = false;
                    that.list.forEach(function(element){
                        if(element.src == e.target.result){
                            skip = true;
                            return false;
                        }
                    });
                    if(!skip){
                        that.list.push({
                            name:theFile.name,
                            type:theFile.type.split('/')[0],
                            src:e.target.result,
                            ext:theFile.name.split('.').pop()
                        });
                        if(that.list.length == 1){
                            that.list[0].id=0;
                        }else{
                            that.list[that.list.length-1].id = that.list[that.list.length-2].id+1;
                        }
                        thumb = (theFile.type.match('image.*'))? e.target.result:unknowSrc;
                        var span = document.createElement('span');
                        span.setAttribute('id', 'file-'+that.list[that.list.length-1].id);
                        span.innerHTML = '<div class="card float-left ml-2 mb-1 " style="width: 5rem;" id="div-1">'+
                            '<img class="card-img-top" width="70px" height="70px" src="'+
                            thumb
                            +'" title="'+
                            escape(theFile.name)
                            +'"><div id="div-1a" data-role="fieldcontain" data-id="del-'+that.list[that.list.length-1].id+'">'+
                            '<button class="btn btn-danger btn-sm rounded-0 delete-dropZoneImg"><i class="fas fa-times"></i></button></div></div>';
                        document.getElementById(that.listdiv).insertBefore(span, null);
                        classname = document.getElementsByClassName("delete-dropZoneImg");
                        Array.from(classname).forEach(function(element) {
                            element.addEventListener('click', that.listDel);
                        });
                    }

                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
        (error)?alert(msg):null;
    }

    this.handleDragOver = function(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
    }
    this.dropZone.addEventListener('dragover', this.handleDragOver, false);
    this.dropZone.addEventListener('drop', this.handleFileSelect, false);
}

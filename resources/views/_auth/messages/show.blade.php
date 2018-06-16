@extends('_layouts.app')
@section('title', 'Messages - '.$friend->fname)

@section('content')
	<!-- Start: Dashboard -->
  <div class="row">
    <div class="offset-lg-2 col-lg-8 col-sm-12 mb-4">
  <div class="row" id="app">
    <div class="col-lg-12 col-sm-12 mb-4">
      <div class="card">
        <h5 class="card-header chat-header">{{$friend->fname . ' ' . $friend->lname}}</h5>
        <div class="card-body" style="overflow-y: scroll;height:350px" v-chat-scroll>
            @foreach ($messages as $msg)
            <div class="row">
              <div class="container">
                <div class="alert col-auto {{ ($msg->sender->id != Auth::user()->id)? 'alert-primary text-left rounded-box float-left':'alert-light text-right float-right' }} " style="max-width:65%" role="alert" title="{{$msg->created_at}}">
                  {{$msg->body}}
                </div>

              </div>
            </div>
            @endforeach
            <message
              v-for="value,index in chat.message"
              :key=value.index
              v-bind:data="value"
              v-bind:title="chat.created_at[index]"
              :color="chat.color[index]"
              v-cloak
            >
              @{{value}}
          </message>
        </div>
        <div class="card-footer text-muted">
          <span class="badge badge-secondary">@{{ typing }}</span>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Enter Your message Here" v-model="message" v-on:keyup.enter="send">
            <div class="input-group-append">
              <button class="btn  btn-success" type="button" v-on:click="send">Submit</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
  <script type="text/javascript">
  var app = new Vue({
    el: '#app',
    data: {
      message: '',
      channel: '{{$channel}}',
      recipent: {{$friend->id}},
      recipentName: '{{$friend->fname}}',
      user: '{{Auth::user()->fname}}',
      api_token: '{{Auth::user()->api_token}}',
      typing: '',
      chat: {
        message: [],
        created_at:[],
        color:[]
      }
    },
    watch: {
      message(){
        Echo.private('msg.'+this.channel)
            .whisper('typing', {
              message: this.message,
        });
      }
    },
    methods: {
      markRead(){
        //mark received as read
        axios.post('/api/messages/'+this.recipent+'/read',{
          api_token : this.api_token
        })
        .then( (response) => {
        })
        .catch(function (error) {
          console.log(error);
        });
      },
      send(){
        if(this.message.length != 0){
          axios.post('/api/messages/'+this.recipent+'/send', {
            message: this.message,
            api_token : this.api_token
          })
          .then( (response) => {
            this.chat.message.push(response.data.body);
            this.chat.color.push("light text-right float-right");
            this.chat.created_at.push(response.data.created_at);
            this.message='';
          })
          .catch(function (error) {
            console.log(error);
          });
        }


      },
      listen(){
        Echo.private('msg.'+this.channel)
            .listen('MessageEvent', (e) => {
              this.chat.message.push(e.message.body);
              this.chat.created_at.push(e.message.created_at);
              this.chat.color.push("primary text-left float-left")
              this.markRead();

            })
            .listenForWhisper('typing', (e) => {
              if(e.message != ''){
                this.typing = this.recipentName+' is typing..';
              }else{
                this.typing = '';
              }
            });
      }
    },
    mounted(){
      this.listen();
    }
  })

  </script>
@endsection

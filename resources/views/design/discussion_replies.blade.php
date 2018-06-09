@extends('_layouts.app')
@section('title', 'discussion form')

@section('content')
    <div class="row disscusion">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-1 col-sm-12">
                    <a href="" class="btn go-back-btn mb-4"><i class="fas fa-arrow-left fa-1x"></i></a>        
                </div>
                <div class="col-lg-11 mb-3">
                    {{-- Post --}}                    
                    <div class="discussion-container">
                        <div class="row">
                            <div class="col-lg-11">
                                <h3 class="post-title font-weight-bold">First post created about javascript</h3>
                            </div>
                            <div class="col-lg-1">
                                <div class="dropdown float-right">
                                    <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v font-weight-bold browse-icon"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right text-left">
                                        <a class="dropdown-item" href="#">Send Message</a>
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-muted"><strong>21 minute ago by <span class="text-success">Mohab Hamdy</span></strong></p>
                        <div class="user-content my-4">
                            <p class="discussion-body-content mb-4">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias doloremque esse ut veritatis et delectus odit fugiat rem cupiditate, voluptatum earum corporis repudiandae saepe fugit nesciunt accusantium possimus dolore eligendi!Corporis, porro! Praesentium accusamus odit nostrum culpa suscipit voluptatem, enim accusantium eaque iusto? Modi dolorem ad temporibus quisquam necessitatibus aspernatur aliquam incidunt voluptatibus nam expedita. Praesentium tempore nemo quaerat odio?
                            </p>
                            <div id="carouselExampleIndicators" class="carousel slide" data-interval="false" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    {{-- image counter indicator --}}
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner">
                                    {{-- First image displayed as default --}}
                                    <div class="carousel-item active">
                                        <a href="https://hdwallsource.com/img/2014/5/best-hd-wallpapers-8324-8657-hd-wallpapers.jpg" data-lightbox="test"> 
                                            <img class="d-block w-100" src="https://hdwallsource.com/img/2014/5/best-hd-wallpapers-8324-8657-hd-wallpapers.jpg" alt="First slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a href="https://hdwallsource.com/img/2014/5/best-hd-wallpapers-8324-8657-hd-wallpapers.jpg" data-lightbox="test"> 
                                            <img class="d-block w-100" src="https://hdwallsource.com/img/2014/5/best-hd-wallpapers-8324-8657-hd-wallpapers.jpg" alt="First slide">
                                        </a>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Replies --}}
            <div class="row reply-form">
                <div class="offset-lg-1 col-lg-11 mb-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <button id="add-reply-btn" class="btn btn-light btn-block" data-toggle="modal" data-target="#add-reply-modal"><i class="fas fa-reply mr-2"></i> Reply</button>
                        </div>
                    </div>
                    <div class="modal fade modal-custom" id="add-reply-modal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <a href="#">First Post Created</a>
                                    </h5>
                                    <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="exampleTextarea">Whats on your mind...</label>
                                        <textarea class="form-control text-area-reply" id="exampleTextarea" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer modal-footer-custom">
                                    <div class="modal-left-btns">
                                        <button class="btn btn-light on-small mb-2"><i class="fas fa-plus mr-2"></i>Add</button>
                                        <button class="btn btn-light on-small mb-2"><i class="fas fa-upload mr-2"></i> Upload</button>
                                        <button type="button" class="btn btn-dark float-right on-small mb-2" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="row replies">
                <div class="offset-lg-1 col-lg-11">
                    {{-- default Reply --}}
                    <div class="card mb-4">
                        <div class="card-header reply-header">
                            <span class="username-post">Mohab Hamdy<span></span></span>
                            <div class="dropdown float-right">
                                <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                                    <i class="fas fa-chevron-down font-weight-bold browse-icon"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right text-left">
                                    <a class="dropdown-item" href="#">Send Message</a>
                                    <a class="dropdown-item" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                            <span class="lb"><small>Created at: 2018-07-06</small></span>
                        </div>
                        <div class="card-body pb-1">
                            <p>
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eveniet iusto nisi, magni incidunt accusamus ratione rem distinctio repudiandae aperiam saepe sunt voluptatibus, laudantium obcaecati facere repellendus explicabo totam in sequi.
                            </p>
                            <div class="row">
                                <div class="col-lg-12 mt-2 mb-3">
                                    <p class="best-solution-hide-lbl"><strong><span class="badge badge-success badge-pill"><i class="fas fa-check mr-1"></i>  BEST SOLUTION</span></strong></p>
                                </div>
                                <div class="col-lg-12 mb-1 pb-3" >
                                    <a href="#" class="btn btn-light mr-2"><i class="fas fa-thumbs-up mr-1"></i> Like</a>
                                    <a href="#" class="btn btn-light mr-2"><i class="fas fa-comment-alt mr-1"></i> Comment</a>
                                    <a href="#" class="btn btn-light"><i class="fas fa-check mr-1"></i> Approve</a>
                                    <span class="float-right interactive-likes-comments">
                                        <a href="" class="btn-link text-primary coll-btn rm-td mr-2"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Mohab Hamdy">
                                            <span class="badge badge-dark badge-pill mr-1">100</span> Like
                                        </a>
                                        <a class="btn-link text-primary coll-btn rm-td" data-toggle="collapse" href="#reply-1" role="button" aria-expanded="false" aria-controls="reply-1">
                                            <span class="badge badge-dark badge-pill">87</span> Comments
                                        </a>
                                    </span>
                                </div>
                                {{-- Comments --}}
                                <div class="col-lg-12">
                                    <div class="collapse comments-block" id="reply-1">
                                        {{-- First comment --}}
                                        <div class="card my-3 comment">
                                            <div class="card-header comment-header">
                                                <span class="username-post">
                                                    <i class="fas fa-reply mr-2"></i>
                                                    Mohab Hamdy
                                                    <span class="ml-2"><small>2018-07-06</small></span>
                                                </span>
                                                <div class="dropdown float-right">
                                                    <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v font-weight-bold browse-icon"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right text-left">
                                                        <a class="dropdown-item" href="#">Send Message</a>
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body py-2">
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Best solution --}}
                    <div class="card mb-4 best-solution">
                        <div class="card-header reply-header">
                            <span class="username-post">Mohab Hamdy<span></span></span>
                            <div class="dropdown float-right">
                                <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                                    <i class="fas fa-chevron-down font-weight-bold browse-icon"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right text-left">
                                    <a class="dropdown-item" href="#">Send Message</a>
                                    <a class="dropdown-item" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                            <span class="lb"><small>Created at: 2018-07-06</small></span>
                        </div>
                        <div class="card-body pb-1">
                            <p>
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eveniet iusto nisi, magni incidunt accusamus ratione rem distinctio repudiandae aperiam saepe sunt voluptatibus, laudantium obcaecati facere repellendus explicabo totam in sequi.
                            </p>
                            <div class="row">
                                <div class="col-lg-12 mt-2 mb-3">
                                    <p class="best-solution-show-lbl"><strong><span class="badge badge-success badge-pill"><i class="fas fa-check mr-1"></i>  BEST SOLUTION</span></strong></p>
                                </div>
                                <div class="col-lg-12 mb-1 pb-3" >
                                    <a href="#" class="btn btn-light mr-2"><i class="fas fa-thumbs-up mr-1"></i> Like</a>
                                    <a href="#" class="btn btn-light mr-2"><i class="fas fa-comment-alt mr-1"></i> Comment</a>
                                    <a href="#" class="btn btn-success active"><i class="fas fa-check mr-1"></i> Approved</a>
                                    <span class="float-right interactive-likes-comments">
                                        <a href="" class="btn-link text-primary coll-btn rm-td mr-2"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Mohab Hamdy">
                                            <span class="badge badge-dark badge-pill mr-1">100</span> Like
                                        </a>
                                        <a class="btn-link text-primary coll-btn rm-td" data-toggle="collapse" href="#reply-2" role="button" aria-expanded="false" aria-controls="reply2">
                                            <span class="badge badge-dark badge-pill">87</span> Comments
                                        </a>
                                    </span>
                                </div>
                                {{-- Comments --}}
                                <div class="col-lg-12">
                                    <div class="collapse comments-block" id="reply-2">
                                        {{-- First comment --}}
                                        <div class="card my-3 comment">
                                            <div class="card-header comment-header">
                                                <span class="username-post">
                                                    <i class="fas fa-reply mr-2"></i>
                                                    Mohab Hamdy
                                                    <span class="ml-2"><small>2018-07-06</small></span>
                                                </span>
                                                <div class="dropdown float-right">
                                                    <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v font-weight-bold browse-icon"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right text-left">
                                                        <a class="dropdown-item" href="#">Send Message</a>
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body py-2">
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- default Reply --}}
                    <div class="card mb-4">
                        <div class="card-header reply-header">
                            <span class="username-post">Mohab Hamdy<span></span></span>
                            <div class="dropdown float-right">
                                <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                                    <i class="fas fa-chevron-down font-weight-bold browse-icon"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right text-left">
                                    <a class="dropdown-item" href="#">Send Message</a>
                                    <a class="dropdown-item" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                            <span class="lb"><small>Created at: 2018-07-06</small></span>
                        </div>
                        <div class="card-body pb-1">
                            <p>
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eveniet iusto nisi, magni incidunt accusamus ratione rem distinctio repudiandae aperiam saepe sunt voluptatibus, laudantium obcaecati facere repellendus explicabo totam in sequi.
                            </p>
                            <div class="row">
                                <div class="col-lg-12 mt-2 mb-3">
                                    <p class="best-solution-hide-lbl"><strong><span class="badge badge-success badge-pill"><i class="fas fa-check mr-1"></i>  BEST SOLUTION</span></strong></p>
                                </div>
                                <div class="col-lg-12 mb-1 pb-3" >
                                    <a href="#" class="btn btn-light mr-2"><i class="fas fa-thumbs-up mr-1"></i> Like</a>
                                    <a href="#" class="btn btn-light mr-2"><i class="fas fa-comment-alt mr-1"></i> Comment</a>
                                    <a href="#" class="btn btn-light"><i class="fas fa-check mr-1"></i> Approve</a>
                                    <span class="float-right interactive-likes-comments">
                                        <a href="" class="btn-link text-primary coll-btn rm-td mr-2"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Mohab Hamdy">
                                            <span class="badge badge-dark badge-pill mr-1">100</span> Like
                                        </a>
                                        <a class="btn-link text-primary coll-btn rm-td" data-toggle="collapse" href="#reply-3" role="button" aria-expanded="false" aria-controls="reply-3">
                                            <span class="badge badge-dark badge-pill">87</span> Comments
                                        </a>
                                    </span>
                                </div>
                                {{-- Comments --}}
                                <div class="col-lg-12">
                                    <div class="collapse comments-block" id="reply-3">
                                        {{-- First comment --}}
                                        <div class="card my-3 comment">
                                            <div class="card-header comment-header">
                                                <span class="username-post">
                                                    <i class="fas fa-reply mr-2"></i>
                                                    Mohab Hamdy
                                                    <span class="ml-2"><small>2018-07-06</small></span>
                                                </span>
                                                <div class="dropdown float-right">
                                                    <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v font-weight-bold browse-icon"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right text-left">
                                                        <a class="dropdown-item" href="#">Send Message</a>
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body py-2">
                                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">

        </div>
    </div>
@endsection
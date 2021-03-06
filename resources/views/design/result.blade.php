@extends('_layouts.app')
@section('title', 'discussion form')

@section('content')
    <div class="row">
        {{--  left-side  --}}
        <div class="col-lg-4 col-sm-12 mb-4" style="box-sizing:border-box;">
            <div class="card mb-3 left-side-card">
                <div class="card-header left-side-card-header">
                    <div class="mb-3">
                        <i class="fas fa-search left-side-h-search-icon"></i>
                        <span class="pl-2 left-side-search-title">Search for a post</span>
                    </div>
                    <input type="text" class="my-2 form-control" name="search" id="search-btn" placeholder="Search for posts here...">
                </div>
            </div>
        </div>

        {{--  Result  --}}
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-dismissible alert-danger">
                        <strong>Result Not Found!</strong> Please try again
                    </div>
                    <div class="alert alert-dismissible alert-success">
                        <strong>Result Found: <span class="badge badge-light badge-pill" style="font-size:14px">5</span></strong>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-light mb-3">
                        <div class="card-header right-side-posts-header">
                            <span class="username-post">Mohab Hamdy</span>
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
                            <span class="lb"><small>Created at: 2018-07-06</small></span>
                        </div>
                        <div class="card-body right-side-post-body">
                            <h4 class="card-title right-side-post-btitle">
                                <a href="http://">First post created</a>
                            </h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content...</p>
                        </div>
                        <div class="card-footer right-side-footer-card">
                            <div class="row">
                                <div class="col-lg-3 pl-3 mt-1">
                                    <span class="reply-lbl">Reply</span>
                                    <span class="badge badge-dark badge-pill reply-lbl-counter">1000</span>
                                </div>
                                <div class="col-lg-9">
                                        <button id="add-reply-btn" class="btn btn-light float-right" data-toggle="modal" data-target="#add-reply-modal"><i class="fas fa-reply mr-2"></i> Reply</button>
                                </div>
                                <div class="modal fade modal-custom" id="add-reply-modal">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <a href="http://">First Post Created</a>
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
                    </div>       
                </div>    
            </div>         
        </div>
    </div>
@endsection
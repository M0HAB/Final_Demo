@extends('_layouts.app')

@section('title')
    Update {{ $module->title }}
@endsection

@section('styles')
    <style>

        /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
        .modal {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            url('{{ asset('course_images/ajax-loader2.gif') }}')
            50% 50%
            no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading .modal {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal {
            display: block;
        }

    </style>
@endsection

@section('content')
    <div class=" mt-5 text-left" style="font-size: large">
        <a href="{{ route('course.displayLessonsOfModules',['course_id' => $course->id, 'module_id'=> $module->id]) }}" class="btn go-back-btn mb-1"><i class="fas fa-arrow-left fa-1x"></i> Back</a> 
    </div>
    <div id="response-message-success" class="alert alert-success mt-2" style="display: none"></div>
    <fieldset>
        <div class="reg-log-form p-3 my-3">
            <legend><i class="fa fa-edit mr-1"></i>Update <span id="form-module-title-parent"><span id="form-module-title-child">{{ $module->title }}</span></span></legend>
            <hr>
            <form id="submit-update-module">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputTitle">Module Title</label>
                            <input type="text" name="title" class="form-control" id="inputTitle" value="{{ $module->title }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputCommitment">Commitment</label>
                            <input type="text" name="commitment" class="form-control" id="inputCommitment" value="{{ $module->commitment }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputOrder">Module Order</label>
                            <input type="text" name="module_order" class="form-control" id="inputOrder" value="{{ $module->module_order }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputModuleIntroduction">Module Introduction</label>
                            <textarea name="introduction" class="form-control" id="inputModuleIntroduction">{{ $module->introduction }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <br>
                        <button  class="btn btn-primary">Update Module</button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
<div class="modal"><!-- Place at bottom of page --></div>
@endsection

@section('scripts')
    <script>
        var courseID = {!! json_encode($course->id) !!};
        var moduleID = {!! json_encode($module->id) !!};
    </script>
    <script src="{{ asset('js/updateModuleForm.js') }}"></script>
    <script>
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading"); },
            ajaxStop: function() { $body.removeClass("loading"); }
        });
    </script>
@endsection
<!-- The Modal -->
<div class="modal fade" id="req" tabindex="-1" role="dialog" aria-labelledby="post" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group" id="req_title_area">
            <label for="post_title" class="col-form-label">Title:</label>
            <input type="text" class="form-control" id="req_title">
          </div>
          <div class="form-group">
            <label class="col-form-label">Body:</label>
            <div id="req_body"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="submit_req" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal-->

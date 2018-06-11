<!-- newRecord Modal -->
<div class="modal fade modal-custom" id="req" tabindex="-1" role="dialog" aria-labelledby="post" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group" id="req_title_area">
            <label for="post_title" class="col-form-label">Title:</label>
            <input type="text" class="form-control" id="req_title">
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Body</label>
            <textarea class="form-control" id="req_body" rows="3"></textarea>
          </div>
          <div class="card text-center" id="drop_zone">
              <div class="card-body" style="border-style: dashed;">
                  <div>Drop files here</div>
              </div>
              <div class="card-footer text-muted" id="list" style="height:120px;overflow-y: auto">

              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="submit_req" class="btn btn-light on-small mb-2">
          <i class="fas fa-plus mr-2"></i><span class="btn-text-modal"></span>
        </button>
        <button type="button" id="close" class="btn btn-dark on-small mb-2" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal-->

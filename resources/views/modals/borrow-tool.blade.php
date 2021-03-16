<div class="modal fade" id="borrow">
  <div class="modal-dialog modal-default">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-uppercase"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="request-form" id="request-form">
          <div class="form-group row header-hide">
            <div class="col">
              <label for="form-group">Select a Room</label>
              <input type="hidden" id="lhofhidden" name="lhofhidden" value="">
              <input type="hidden" id="lhofid" name="lhofid" value="">
              <input type="hidden" id="borrower" name="borrower" value="">
              <input type="hidden" id="course" name="course" value="">
              <select class="form-control" name="room" id="room" style="width: 100%;">
              </select>
            </div>
            <div class="col">
              <label for="inputEmail3">LHOF No.</label>
              <input type="text" class="form-control" id="lhof" name="lhof" value="" readonly="">
            </div>
          </div>
          <div class="search">
            <input type="text" class="search__input search-item" id="search-item" name="search_item" max="15" placeholder="Enter Fixed Asset Code" autocomplete="off">
            <input type="hidden" id="hiddendesc" name="hiddendesc" value="">
            <!-- <button class="search__button">
              <svg class="search__icon"><use xlink:href="client/img/sprite.svg#icon-magnifying-glass"></use></svg>
            </button> -->
            <input type="hidden" id="action" value="">
          </div>
        </form>
        <div class="item-result">
          <div class="borrowed__list" id="borrowed-item"></div>
        </div>
      </div>
    </div>
  </div>
</div>
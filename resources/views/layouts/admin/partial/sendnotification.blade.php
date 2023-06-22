<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        @if(count($usersReceiverID) != 0){
        <form action="{{ route('admin.report.user.send-notification') }}" method="Post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارسال نوتیفیکیشن</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">* عنوان</label>
                        <input type="text" class="form-control" name="title" id="exampleFormControlInput1" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect2">نوع</label>
                        <select class="form-control" name="type" id="exampleFormControlSelect2">
                            <option value="sms">sms</option>
                            <option value="pushe">پوشه</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">توضیحات</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </div>
                @foreach($usersReceiverID as $key => $userReceiverID)
                    <input type="hidden" name="users[{{ $key }}]" value="{{ $userReceiverID }}">
                @endforeach

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary small" data-dismiss="modal">بستن</button>
                    <button type="submit" class="btn btn-primary mr-1 small">ارسال</button>
                </div>
            </div>
        </form>
        @else
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارسال نوتیفیکیشن</h5>
                </div>
                <div class="modal-body">
                    <p>هیچ کاربر انتخاب نشده است</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary small" data-dismiss="modal">بستن</button>
                </div>
            </div>
        @endif
    </div>
</div>

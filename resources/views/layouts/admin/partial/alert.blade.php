@if (session()->has('alert'))
    <div class="alert alert-{{ session('alert')['type'] }} alert-block my-2">
        <button type="button" class="close mx-2" data-dismiss="alert">×</button>
        <strong>{{ session('alert')['message'] }}</strong>
    </div>
@endif
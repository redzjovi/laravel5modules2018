@if ($errors->any())
    <div class="alert alert-danger alert-important" role="alert">
        <button aria-hidden="true" class="close" data-dismiss="alert" type="button">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

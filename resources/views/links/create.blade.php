<div class="panel panel-default">
    <div class="panel-heading">Create a short link</div>
    <div class="panel-body">
        <form class="form-inline" action="{{ route('links.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}" style="width: 100%">
                <input type="text" name="link" class="form-control" placeholder="Past a link to shorten link" style="width: calc(100% - 90px)">
                <button type="submit" class="btn btn-success form-control">Shorten</button>
            </div>
            <span class="help-block">{{ $errors->first('link') }}</span>
        </form>
    </div>
</div>
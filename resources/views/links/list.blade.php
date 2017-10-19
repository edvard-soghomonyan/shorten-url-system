@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('links.create')
            </div>
            <div class="col-md-12">
                @if (isset($shortenLink))
                    <div class="alert alert-success">
                        <span id="shorten-link" style="padding: 0 10px">{{ $shortenLink }}</span>
                        <button id="copy-shorten-link" class="btn btn-warning btn-sm" style="margin-left: 15px;">Copy</button>
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Links created by You</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Url</th>
                        <th>Shorten</th>
                        <th>Clicks</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($links as $link)
                            <tr>
                                <td style="word-break: break-word;">{{ $link->url }}</td>
                                <td>{{ url(\App\Helpers\UrlShortener::toBase($link->id)) }}</td>
                                <td>{{ $link->tracking['count'] }}</td>
                                <td class="text-center">
                                    <form action="{{ route('links.destroy', $link->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">No Links</td></tr>
                        @endforelse
                    </tbody>
                </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var btn = document.getElementById('copy-shorten-link');

            if (!btn)
                return;

            btn.addEventListener('click', function (e) {
                var  link = document.getElementById('shorten-link'),
                    range,
                    selection;

                if (document.body.createTextRange) {
                    range = document.body.createTextRange();
                    range.moveToElementText(link);
                    range.select();
                } else if (window.getSelection) {
                    selection = window.getSelection();
                    range = document.createRange();
                    range.selectNodeContents(link);
                    selection.removeAllRanges();
                    selection.addRange(range);
                }

                document.execCommand('copy');
            })
        })
    </script>
@endsection
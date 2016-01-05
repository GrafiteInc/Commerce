@extends('quarx::quarx.layouts.dashboard')

@section('content')

<div class="col-sm-3 col-md-2 sidebar">
    <div class="raw100 raw-left raw-margin-bottom-90">
        @include('quarx::quarx.dashboard.panel')
    </div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Dashboard</h1>

    <div class="row placeholders">
        <div class="col-xs-6 col-sm-3 placeholder">
            <img src="http://lorempixel.com/400/400/technics/" class="img-responsive" alt="Generic placeholder thumbnail">
            <h4>Label</h4>
            <span class="text-muted">Something else</span>
        </div>
        <div class="col-xs-6 col-sm-3 placeholder">
            <img src="http://lorempixel.com/400/400/technics/" class="img-responsive" alt="Generic placeholder thumbnail">
            <h4>Label</h4>
            <span class="text-muted">Something else</span>
        </div>
        <div class="col-xs-6 col-sm-3 placeholder">
            <img src="http://lorempixel.com/400/400/technics/" class="img-responsive" alt="Generic placeholder thumbnail">
            <h4>Label</h4>
            <span class="text-muted">Something else</span>
        </div>
        <div class="col-xs-6 col-sm-3 placeholder">
            <img src="http://lorempixel.com/400/400/technics/" class="img-responsive" alt="Generic placeholder thumbnail">
            <h4>Label</h4>
            <span class="text-muted">Something else</span>
        </div>
    </div>

    <h2 class="sub-header">Section title</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Header</th>
                    <th>Header</th>
                    <th>Header</th>
                    <th>Header</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                    <td>item</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@stop
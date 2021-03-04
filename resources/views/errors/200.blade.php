<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title }}</title>
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">错了</div>
                <a href="{{ url('/') }}">
                        <button class="button button-primary button-circle button-giant button-longshadow">Go to home page</button></a>
                <a href="{{ url()->previous() }}">
                        <button class="button button-highlight button-circle button-giant button-longshadow">Back to previous page</button></a>
                <p>{!! $msg !!}</p>
            </div>
        </div>
    </body>
</html>

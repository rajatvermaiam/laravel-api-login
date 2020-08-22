<html lang="en">
<title itemprop="name">Preview Bootstrap snippets. messages chat widget</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<meta name="viewport" content="width=device-width">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.Laravel = {!! json_encode([
        'user' => auth()->check() ? auth()->user()->id : null,
    ]) !!};
</script>
</head>
<body>
<div id="snippetContent">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="col-md-12 col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <div class="btn-group">
                            <button class="btn btn-default" type="button" data-toggle="collapse"
                                    data-target="#demo-chat-body"><i class="fa fa-chevron-down"></i></button>
                        </div>
                    </div>
                    <h3 class="panel-title">Chat</h3>
                </div>
                <div id="demo-chat-body" class="collapse in">
                    <div class="nano has-scrollbar" style="height:510px" id="nano">
                        <div class="nano-content pad-all" tabindex="0" style="right: -17px;">
                            <ul class="list-unstyled media-block" id="messages">

                                @foreach($messages as $message)
                                    @if($message['from']==Auth::id())
                                        <li class="mar-btm">
                                            <div class="media-right"><img
                                                    src="{{$message->user['profile_pic']}}"
                                                    class="img-circle img-sm" alt="Profile Picture"></div>
                                            <div class="media-body pad-hor speech-right">
                                                <div class="speech">
                                                    <a href="#" class="media-heading">{{$message->user['name']}}</a>
                                                    <p>{{$message->message}}</p>
                                                    <p class="speech-time"><i
                                                            class="fa fa-clock-o fa-fw"></i>{{$message->created_at}}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @else
                                        <li class="mar-btm">
                                            <div class="media-left"><img
                                                    src="{{$message->user['profile_pic']}}"
                                                    class="img-circle img-sm" alt="Profile Picture"></div>
                                            <div class="media-body pad-hor">
                                                <div class="speech">
                                                    <a href="#" class="media-heading">{{$message->user['name']}}</a>
                                                    <p>{{$message->message}}</p>
                                                    <p class="speech-time"><i
                                                            class="fa fa-clock-o fa-fw"></i>{{$message->created_at}}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                @endforeach


                            </ul>
                        </div>
                        <div class="nano-pane">
                            <div class="nano-slider" style="height: 141px; transform: translate(0px, 0px);"></div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-xs-10">
                                <input type="text" id="message" name="message" placeholder="Enter your text"
                                       class="form-control chat-input" style="height:70px;" required>
                                <input type="hidden" id="to" value="{{ Request::segment(2)}}">
                            </div>
                            <div class="col-xs-2">
                                <button class="btn btn-primary btn-block" id="send" type="submit">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">body {

            background: #ebeef0;
        }

        .panel {
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.075);
            border-radius: 0;
            border: 0;
            margin-bottom: 24px;
        }

        .panel .panel-heading, .panel > :first-child {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .panel-heading {
            position: relative;
            height: 50px;
            padding: 0;
            border-bottom: 1px solid #eee;
        }

        .panel-control {
            height: 100%;
            position: relative;
            float: right;
            padding: 0 15px;
        }

        .panel-title {
            font-weight: normal;
            padding: 0 20px 0 20px;
            font-size: 1.416em;
            line-height: 50px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .panel-control > .btn:last-child, .panel-control > .btn-group:last-child > .btn:first-child {
            border-bottom-right-radius: 0;
        }

        .panel-control .btn, .panel-control .dropdown-toggle.btn {
            border: 0;
        }

        .nano {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .nano > .nano-content {
            position: absolute;
            overflow: scroll;
            overflow-x: hidden;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .pad-all {
            padding: 15px;
        }

        .mar-btm {
            margin-bottom: 15px;
        }

        .media-block .media-left {
            display: block;
            float: left;
        }

        .img-sm {
            width: 46px;
            height: 46px;
        }

        .media-block .media-body {
            display: block;
            overflow: hidden;
            width: auto;
        }

        .pad-hor {
            padding-left: 15px;
            padding-right: 15px;
        }

        .speech {
            position: relative;
            background: #b7dcfe;
            color: #317787;
            display: inline-block;
            border-radius: 0;
            padding: 12px 20px;
        }

        .speech:before {
            content: "";
            display: block;
            position: absolute;
            width: 0;
            height: 0;
            left: 0;
            top: 0;
            border-top: 7px solid transparent;
            border-bottom: 7px solid transparent;
            border-right: 7px solid #b7dcfe;
            margin: 15px 0 0 -6px;
        }

        .speech-right > .speech:before {
            left: auto;
            right: 0;
            border-top: 7px solid transparent;
            border-bottom: 7px solid transparent;
            border-left: 7px solid #ffdc91;
            border-right: 0;
            margin: 15px -6px 0 0;
        }

        .speech .media-heading {
            font-size: 1.2em;
            color: #317787;
            display: block;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            padding-bottom: 5px;
            font-weight: 300;
        }

        .speech-time {
            margin-bottom: 0;
            font-size: .8em;
            font-weight: 300;
        }

        .media-block .media-right {
            float: right;
        }

        .speech-right {
            text-align: right;
        }

        .pad-hor {
            padding-left: 15px;
            padding-right: 15px;
        }

        .speech-right > .speech {
            background: #ffda87;
            color: #a07617;
            text-align: right;
        }

        .speech-right > .speech .media-heading {
            color: #a07617;
        }

        .btn-primary, .btn-primary:focus, .btn-hover-primary:hover, .btn-hover-primary:active, .btn-hover-primary.active, .btn.btn-active-primary:active, .btn.btn-active-primary.active, .dropdown.open > .btn.btn-active-primary, .btn-group.open .dropdown-toggle.btn.btn-active-primary {
            background-color: #579ddb;
            border-color: #5fa2dd;
            color: #fff !important;
        }

        .btn {
            cursor: pointer;
            /* background-color: transparent; */
            color: inherit;
            padding: 6px 12px;
            border-radius: 0;
            border: 1px solid 0;
            font-size: 11px;
            line-height: 1.42857;
            vertical-align: middle;
            -webkit-transition: all .25s;
            transition: all .25s;
        }

        .form-control {
            font-size: 11px;
            height: 100%;
            border-radius: 0;
            box-shadow: none;
            border: 1px solid #e9e9e9;
            transition-duration: .5s;
        }

        .nano > .nano-pane {
            background-color: rgba(0, 0, 0, 0.1);
            position: absolute;
            width: 5px;
            right: 0;
            top: 0;
            bottom: 0;
            opacity: 0;
            -webkit-transition: all .7s;
            transition: all .7s;
        }
    </style>
    <script type="text/javascript"></script>
</div>
</body>

<script>
    function sendMessage() {
        message = $("#message").val();
        if (message == '')
            return false;
        to = $("#to").val();
        $.ajax({
            type: "POST",
            url: "{{url('send')}}",
            data: {
                message: message,
                to: to,
                _token: "{{ csrf_token() }}",
            },
            beforeSend: function () {
                $("#message").val('');
                $("#send").prop("disabled", true);
            },
            success: function (data) {
                $("#send").prop("disabled", false);
                $("#messages").append(`
                    <li class="mar-btm">
                    <div class="media-right">
                    <img src="` + data.user.profile_pic + `" class="img-circle img-sm" alt="Profile Picture"></div>
                    <div class="media-body pad-hor speech-right">
                    <div class="speech">
                    <a href="#" class="media-heading">` + data.user.name + `</a>
                    <p>` + data.message + `</p>
                    <p class="speech-time">
                    <i class="fa fa-clock-o fa-fw"></i>` + data.created_at + `
                    </p>
                    </div>
                    </div>
                    </li>
                `);
                $(".nano .nano-content").scrollTop(1E10);
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        $(".nano .nano-content").scrollTop(1E10);
        $("#message").keypress(function (e) {
            if (e.which == 13) {
                e.preventDefault();
                sendMessage();
            }
        });
        $("#send").click(function (e) {
            sendMessage();
        });
    });
</script>
</html>

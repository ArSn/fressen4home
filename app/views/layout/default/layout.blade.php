
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Fressen 4 Home</title>

	<!-- libs -->
	<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
	<link href="{{ asset('assets/libs/twitterbootstrap3/css/bootstrap.min.css') }}" rel="stylesheet">
	<script src="{{ asset('assets/libs/twitterbootstrap3/js/bootstrap.min.js') }}"></script>

    @if (Auth::check() && Config::get('pusher.enabled'))
        <script type="text/javascript">
            var PusherData = {
                user: "{{ Auth::user()->email }}",
                app_key: "{{ Config::get('pusher.app_key') }}",
                channel: "{{ Config::get('pusher.channel') }}",
                close_in: {{ Config::get('pusher.close_in') }},
                notifications: {
                   created: {{ Auth::user()->notify_created }},
                   incoming: {{ Auth::user()->notify_incoming }}
                },
                deliveries: [{{ implode(",", Auth::user()->deliveries_today) }}]
            };
        </script>
        <script src="//js.pusher.com/2.2/pusher.min.js" type="text/javascript"></script>
        <script src="{{ asset('assets/js/notifications.js') }}"></script>
    @endif

	<!-- css -->
	<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

	@yield('header')

</head>

<body>

<div class="container">

	<!-- Static navbar -->
	@include('layout.' . Config::get('app.layout') . '.navigation')

	<!-- error messages / notifications -->
	@include('layout.' . Config::get('app.layout') . '.messages', ['messages' => Session::get('messages'), 'type' => 'success'])
	@include('layout.' . Config::get('app.layout') . '.messages', ['messages' => Session::get('errors'), 'type' => 'danger'])

	<!-- content container -->
	<div class="row">
		@yield('content')
	</div>

</div> <!-- /container -->

</body>
</html>

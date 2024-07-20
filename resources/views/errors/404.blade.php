<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Page not found · WebStarts</title>
<link rel="stylesheet" type="text/css" href="https://cdn.secure.website/ws/1706017555/css/error.css">
</head>
<body>
	<img alt="WebStarts Logo" class="branding" src="https://cdn.secure.website/base/v-1.0.0/img2/ws-logo.png">

	<div class="container center-container fade">
		<h1>404</h1>
		<p>
            @if(isset($exception))
                {{ $exception->getMessage() }}
            @else
                The page you requested does not exist.
            @endif
        </p>
	</div>

	<script type="text/javascript">
		setTimeout(function(){
			document.getElementsByClassName('fade')[0].className += ' in';
		}, 10);
	</script>
</body>
</html>
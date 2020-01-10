<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="All-in-One Fantasy Calendar Generator - Creation of calendars and time-tracking in your homebrew or pre-made campaign worlds have never been easier!">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(Auth::check())
        <meta name='api-token' content="{{ Auth::user()->api_token }}">
    @endif

    <title>
        {!! ($title ?? $calendar->name ?? "Fantasy Calendar") . ' -' !!} Fantasy Calendar
    </title>

    <link rel="apple-touch-icon" sizes="180x180" href="/resources/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/resources/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/resources/favicon-16x16.png">
    <link rel="manifest" href="/resources/site.webmanifest">
    <link rel="mask-icon" href="/resources/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    @if(getenv('APP_ENV') == "production")
        <script src="//d2wy8f7a9ursnm.cloudfront.net/v6/bugsnag.min.js"></script>
        <script>window.bugsnagClient = bugsnag('98440cbeef759631f3d987ab45b26a79')</script>
    @endif

    <script src="{{ mix('/js/app.js') }}"></script>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
    <script src="https://rawgit.com/notifyjs/notifyjs/master/dist/notify.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css">

    <link
        rel="stylesheet"
        href="https://unpkg.com/simplebar@latest/dist/simplebar.css"
    />
    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>

    <script>

    window.baseurl = '{{ getenv('WEBADDRESS') }}';
    window.apiurl = '{{ getenv('WEBADDRESS') }}'+'api/calendar';

    function isMobile() {
        try{ document.createEvent("TouchEvent"); return true; }
        catch(e){ return false; }
    }

    function deviceType() {
        var width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
        var height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0),screenType;
        if (isMobile()){
            if ((width <= 650 && height <= 900) || (width <= 900 && height <= 650))
                screenType = "Mobile Phone";
            else
                screenType = "Tablet";
        }
        else
            screenType = "Desktop";
        return screenType;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Authorization': 'Bearer '+$('meta[name="api-token"]').attr('content')
        }
    });

    $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
        $.notify(thrownError + " (F12 to see more detail)");
    });

    $(document).ready(function(){
        window.onerror = function(error, url, line) {
            $.notify("Error:\n "+error+" \nin file "+url+" \non line "+line);
        }

        $.protip({
            defaults: {
                "delay-in": 2000,
                position: 'bottom',
                scheme: 'leaf',
                classes: 'box-shadow accent-bg-color',
                animate: 'bounceIn',
                target: '#protip_container'
            }
        });

        $.trumbowyg.svgPath = '/images/icons.svg';

        if( deviceType() == "Mobile Phone" ) {
            $("#input_container").toggleClass('inputs_collapsed');
            $("#calendar_container").toggleClass('inputs_collapsed');

            $("#input_collapse_btn").toggleClass('is-active');
            evaluate_error_background_size();
        }
        
        if(window.navigator.userAgent.indexOf("LM-G850") > 0) {
            $("#input_container").addClass('sidebar-mobile-half');
        }
    });

    </script>

    <script src="/js/login.js"></script>

    <script src="/js/vendor/sortable/jquery-sortable-min.js"></script>
    <script src="/js/vendor/spectrum/spectrum.js"></script>

    <script src="{{ mix('/js/calendar/header.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_ajax_functions.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_event_ui.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_functions.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_variables.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_weather_layout.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_season_generator.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_layout_builder.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_inputs_visitor.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_inputs_view.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_inputs_edit.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_manager.js') }}"></script>
    <script src="{{ mix('/js/calendar/calendar_presets.js') }}"></script>

    @if(Auth::check() && Auth::user()->setting('dark_theme'))
        <link rel="stylesheet" href="{{ mix('/css/app-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @endif
    <link rel="stylesheet" href="/js/vendor/spectrum/spectrum.css">

    @stack('head')
</head>

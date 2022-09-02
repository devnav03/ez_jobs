<!DOCTYPE html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<title>ez-job.co</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Custom Admin Theme Design" />
<meta name="csrf-token" content="{!! csrf_token() !!}" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
{!! Html::style('css/bootstrap.css') !!}
<!-- //bootstrap-css -->
<!-- Custom CSS -->
{!! HTML::style('css/style.css') !!}
<!-- font CSS -->
{!! HTML::style('http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic') !!}
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
{!! HTML::style('css/font.css') !!}
{!! HTML::style('css/font-awesome.css') !!}

<!-- //font-awesome icons -->
{!! HTML::script('js/jquery2.0.3.min.js') !!}
{!! HTML::script('js/modernizr.js') !!}
{!! HTML::script('js/jquery.cookie.js') !!}
{!! HTML::script('js/screenfull.js') !!}

@yield('css')
    <script>
    $(function () {
        $('#supported').text('Supported/allowed: ' + !!screenfull.enabled);
        if (!screenfull.enabled) {
            return false;
        }            
        $('#toggle').click(function () {
            screenfull.toggle($('#container')[0]);
        }); 
    });
    </script>
<!-- charts -->
{!! HTML::script('js/raphael-min.js') !!}
{!! HTML::script('js/morris.js') !!}
{!! HTML::script('js/morris.js') !!}
{!! HTML::style('css/morris.css') !!}
{!! HTML::style('css/template.css') !!}
<!-- //charts -->
<!--skycons-icons-->
{!! HTML::script('js/skycons.js') !!}

<!--//skycons-icons-->
</head>
<body class="dashboard-page">
    @include('admin.layouts.sidebar')    
    <section class="wrapper scrollable">
        <nav class="user-menu noPrint">
            <a href="javascript:;" class="main-menu-access">
            <i class="icon-proton-logo"></i>
            <i class="icon-reorder"></i>
            </a>
        </nav>
        @include('admin.layouts.header')
        <div class="main-grid">
            @yield('content')
        </div>
        @include('admin.layouts.footer')       
    </section>

<script src="https://kit.fontawesome.com/4fa1165109.js" crossorigin="anonymous"></script>   
<script type="text/javascript">
    
function getSubcategory(val) {
  $.ajax({
    type: "GET",
    url: "{{ route('getSubcategory') }}",
    data: {'main_id' : val},
    success: function(data){
        $("#category-list").html(data);
    }
  });
}

function getState(val) {
  $.ajax({
    type: "GET",
    url: "{{ route('getState') }}",
    data: {'country_id' : val},
    success: function(data){
        $("#state").html(data);
    }
  });
}

function getCity(val) {
  $.ajax({
    type: "GET",
    url: "{{ route('getCity') }}",
    data: {'state_id' : val},
    success: function(data){
        $("#city").html(data);
    }
  });
}

</script>
</body>
</html>

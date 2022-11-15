<!DOCTYPE html>
<head class="wide wow-animation" lang="en">
<!-- Site Title-->
@if(isset($keyword))   
        @if(isset($keyword->title))
        <title>{{$keyword->title}}</title>
        <meta name="description" content="{{$keyword->description}}"/>
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="website" />
        @else
        <title>{{$keyword->meta_title}}</title>
        <meta name="description" content="{{$keyword->meta_description}}"/>
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{$keyword->meta_title}}" />
        <meta property="og:description" content="{{$keyword->meta_description}}" /> 
        <meta property="og:image" content="{{ route('home') }}/{{ str_replace( ' ', '%20', $keyword->featured_image) }}" />
        <meta property="og:image:width" content="1000" />
        <meta property="og:image:height" content="1000" />
        @endif
        @if(isset($keyword->keyword))
        <meta property="og:title" content="{{$keyword->keyword}}" />
        @else
        <meta property="og:title" content="{{$keyword->meta_tag}}" />
        @endif
        @if(isset($keyword->description))
        <meta property="og:description" content="{{$keyword->description}}" />
        @else
        <meta property="og:description" content="{{$keyword->meta_description}}" />
        @endif
        @if(isset($keyword->keyword))
        <meta name="twitter:title" content="{{$keyword->keyword}}" />
        @else
        <meta name="twitter:title" content="{{$keyword->meta_tag}}" />
        @endif
    @else
<title>ez-job.co</title>
@endif
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<meta name="csrf-token" content="{!! csrf_token() !!}" />
    <link rel="icon" href="{!! asset('assets/frontend/images/favicon.png') !!}" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <!--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 -->    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"/>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/956568d106.js" crossorigin="anonymous"></script>
{!! Html::style('assets/frontend/css/stellarnav.min.css') !!}
<!-- {!! HTML::style('assets/frontend/css/bootstrap.min1.css') !!} -->
{!! HTML::style('assets/frontend/css/style.css') !!}
@yield('css')
</head>
<body class="content-pages">
    <!-- Page-->
    <div class="page">
        <!-- Header -->
        @include('frontend.layouts.header')      
        <!-- Main Content -->
        @yield('content')
        @include('frontend.layouts.footer') 
    </div> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
        {!! HTML::script('assets/frontend/js/stellarnav.min.js') !!}
        <!-- {!! HTML::script('assets/frontend/js/custom.js') !!} -->

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
    $('#table').dataTable();
    } );
</script>
@php
    $route  = \Route::currentRouteName();    
@endphp
<script type="text/javascript">

function SaveJob(job_id) {
    $.ajax({
        type: "GET",
        url: "{{ route('saveJob') }}",
        data: {'job_id' : job_id},
        success: function(data){
            $("#message"+data.job_id).html(data.message);
            $("#button"+data.job_id).html(data.button);
            $("#message"+data.job_id).show(); 
            $("#message"+data.job_id).delay(7200).fadeOut(300);
        }
    });
} 

function saveCandidate(candidate_id) {
    $.ajax({
        type: "GET",
        url: "{{ route('saveCandidate') }}",
        data: {'candidate_id' : candidate_id},
        success: function(data){
            $("#message"+data.candidate_id).html(data.message);
            $("#button"+data.candidate_id).html(data.button);
            $("#message"+data.candidate_id).show(); 
            $("#message"+data.candidate_id).delay(7200).fadeOut(300);
     
        }
    });
} 

function ApplyJob(job_id) {
    $.ajax({
        type: "GET",
        url: "{{ route('applyjob') }}",
        data: {'job_id' : job_id},
        success: function(data){
  
        if(data.plan == 1){
          // window.location = "/membership-plan";
           location.href="/membership-plan";
        } else {
            $("#message"+data.job_id).html(data.message);
            $("#apply_button"+data.job_id).html(data.apply_button);
            $("#message"+data.job_id).show(); 
            $("#message"+data.job_id).delay(7200).fadeOut(300);
        }
        }
    });
} 


const counters = document.querySelectorAll('.counters');

counters.forEach(counter => {
  let count = 0;
  const updateCounter = () => {
    const countTarget = parseInt(counter.getAttribute('data-counttarget'));
    count++;
    if (count < countTarget) {
      counter.innerHTML = count;
      setTimeout(updateCounter, 1);
    } else {
      counter.innerHTML = countTarget;
    }
  };
  updateCounter();
});


$('#col-slide-test').owlCarousel({
    autoplay: true,
    smartSpeed: 900,
    loop: true,
    margin: 20,
    nav: false,
    center:false,
    autoplay:true,
    autoplayHoverPause:true,
    navText: ['<img src="assets/frontend/images/left.png">','<img src="assets/frontend/images/right.png">'],
    dots: false,
    responsive:{
        0:{
            items:2,
            nav: false
        },
        575:{
            items:2,
            nav: false
        },
        768:{
            items:2,
            nav: false
        },
        992:{
            items:3
        },
        1200:{
            items:3
        }
    }
});

$('#main-slide').owlCarousel({
    autoplay: true,
    smartSpeed: 900,
    loop: true,
    margin: 20,
    nav: false,
    center:false,
    autoplay:true,
    autoplayHoverPause:true,
    navText: ['<img src="assets/frontend/images/left.png">','<img src="assets/frontend/images/right.png">'],
    dots: false,
    responsive:{
        0:{
            items:1,
            nav: false
        },
        575:{
            items:1,
            nav: false
        },
        768:{
            items:1,
            nav: false
        },
        992:{
            items:1
        },
        1200:{
            items:1
        }
    }
});

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

@if($route != 'home' && $route != 'candidates')
<script type="text/javascript">
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
} 
</script>
@endif
<script type="text/javascript">
function yesnoCheckEmployer(that) {
    if (that.value == "2") {
        $(".employer_name").show();
    } 
    else {
        $(".employer_name").hide();
    }
}


$(document).ready(function(){
 fetch_customer_data();
 function fetch_customer_data(query = '', country_id)
{
  $.ajax({
   url:"{{ route('live_search') }}",
   method:'GET',
   data:{query:query, country_id:country_id},
   dataType:'json',
   success:function(data) {
    $('#total_records1').html(data.table_data);
   }
  })
 }

 $(document).on('keyup', '.main-search', function(){
  var query = $(this).val();
  var country_id = $( "#cont_id" ).val();

if(query){
    fetch_customer_data(query, country_id);
}

 });
});


$(document).ready(function(){
 fetch_customer_data();
 function fetch_customer_data(query = '', country_id)
{
  $.ajax({
   url:"{{ route('live_search') }}",
   method:'GET',
   data:{query:query, country_id:country_id},
   dataType:'json',
   success:function(data) {
    $('#total_records').html(data.table_data);
   }
  })
 }

 $(document).on('keyup', '.main-search1', function(){
  var query = $(this).val();
  var country_id = $( "#count_id" ).val();

if(query){
    fetch_customer_data(query, country_id);
}

 });
});

function getJobFilter(country_id) {
  var query = $( ".main-search" ).val();
  if(query){
  $.ajax({
    url:"{{ route('live_search') }}",
    method:'GET',
    data:{query:query, country_id:country_id},
    dataType:'json',
    success: function(data){
       $('#total_records1').html(data.table_data);
    }
  });
  }
}

function getJobFilter1(country_id) {
  var query = $( ".main-search1" ).val();
  if(query){
  $.ajax({
    url:"{{ route('live_search') }}",
    method:'GET',
    data:{query:query, country_id:country_id},
    dataType:'json',
    success: function(data){
       $('#total_records').html(data.table_data);
    }
  });
  }
}


function JobFilter(val) {
    var keyword = $("input[name=keyword]").val();
    var country = $("select[name=country_name]").val();
    var state = $("select[name=state]").val();
    var city = $("select[name=city]").val();
    var category = $("select[name=category]").val();
    var sub_category = $("select[name=sub_category]").val();

    $.ajax({
        type: "GET",
        url: "{{ route('job-filter') }}",
        data: {'keyword' : keyword, 'country' : country, 'state' : state, 'city' : city, 'category' : category, 'sub_category' : sub_category},
        success: function(data){
            $("#jobs-list").html(data);
        }
    });
} 


function CompanyFilter(val) {
    var company_name = $("input[name=company_name]").val();
    var country = $("select[name=country_name]").val();
    var state = $("select[name=state]").val();
    var city = $("select[name=city]").val();
    $.ajax({
        type: "GET",
        url: "{{ route('company-filter') }}",
        data: {'company_name' : company_name, 'country' : country, 'state' : state, 'city' : city},
        success: function(data){
            $("#company-list").html(data);
        }
    });
}


function CandidateFilter(val) {
    var country = $("select[name=country_name]").val();
    var state = $("select[name=state]").val();
    var category = $("select[name=category]").val();
    var sub_category = $("select[name=sub_category]").val();

    $.ajax({
        type: "GET",
        url: "{{ route('candidate-filter') }}",
        data: {'country' : country, 'state' : state, 'category' : category, 'sub_category' : sub_category},
        success: function(data){
            $("#candidate-list").html(data);
        }
    });
} 



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
</script>

@if($route == 'membership-plan')
<script type="text/javascript">
function getQuantity1(val) {
   var price = $('.price1').val(); 
  // alert(price);
    $.ajax({
        type: "GET",
        url: "{{ route('getQuantity') }}",
        data: {'qty' : val, 'price': price},
        success: function(data){
          //  alert(data);
           // console.log(data);
            $("#price1").html(data);
        }
    });
}

function getQuantity2(val) {
   var price = $('.price2').val(); 
  // alert(price);
    $.ajax({
        type: "GET",
        url: "{{ route('getQuantity') }}",
        data: {'qty' : val, 'price': price},
        success: function(data){
          //  alert(data);
           // console.log(data);
            $("#price2").html(data);
        }
    });
}

function getQuantity3(val) {
   var price = $('.price3').val(); 
  // alert(price);
    $.ajax({
        type: "GET",
        url: "{{ route('getQuantity') }}",
        data: {'qty' : val, 'price': price},
        success: function(data){
          //  alert(data);
           // console.log(data);
            $("#price3").html(data);
        }
    });
}

function getQuantity4(val) {
   var price = $('.price4').val(); 
  // alert(price);
    $.ajax({
        type: "GET",
        url: "{{ route('getQuantity') }}",
        data: {'qty' : val, 'price': price},
        success: function(data){
          //  alert(data);
           // console.log(data);
            $("#price4").html(data);
        }
    });
}




</script>
@endif
</body>
</html>

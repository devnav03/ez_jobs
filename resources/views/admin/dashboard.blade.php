@extends('admin.layouts.master')
@section('content')
@section('css')
<style>
.canvasjs-chart-credit{
    display: none !important;
}    
#timeToRender {
    position:absolute; 
    top: 10px; 
    font-size: 20px; 
    font-weight: bold; 
    background-color: #d85757;
    padding: 0px 4px;
    color: #ffffff;
}
.remove_marker{
    background: #fff;
    position: absolute;
    width: 76px;
    height: 9px;
    left: 0px;
    z-index: 1;
    content: "";
    top: 68px;
}

</style>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>


window.onload = function () {
    
var data = [{
        type: "line",                
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }];
    
//Better to construct options first and then pass it as a parameter
var options = {
    zoomEnabled: true,
    animationEnabled: true,
    title: {
        text: ""
    },
    axisY: {
        lineThickness: 1
    },
    data: data  // random data
};
 
var chart = new CanvasJS.Chart("chartContainer", options);
var startTime = new Date();
chart.render();

var data1 = [{
        type: "line",                
        dataPoints: <?php echo json_encode($dataPoints_rev, JSON_NUMERIC_CHECK); ?>
    }];
    

var options = {
    zoomEnabled: true,
    animationEnabled: true,
    title: {
        text: ""
    },
    axisY: {
        lineThickness: 1
    },
    data: data1 
};
 
var chart1 = new CanvasJS.Chart("revContainer", options);
var startTime = new Date();
chart1.render();

}

</script>
@endsection
  <div class="social grid">
    <div class="grid-info">

        <div class="col-md-3 top-comment-grid">
            <a href="{!! route('job-seekers.index') !!}">
            <div class="comments likes">
                <div class="comments-icon">
                    <i class="fa fa-users" style="color: #fff;font-size:4em !important;"></i>
                </div>
                <div class="comments-info likes-info">
                <h3>{{ $job_seekers_count }}</h3>
                <a href="{!! route('job-seekers.index') !!}" style="color: #fff !important;">Total Candidates</a>
                </div>
                <div class="clearfix"> </div>
            </div>
            </a>
        </div>
        <div class="col-md-3 top-comment-grid">
          <a href="{!! route('employer.index') !!}">
            <div class="comments likes">
                <div class="comments-icon">
                    <i class="fa fa-users" style="color: #fff;font-size:4em !important;"></i>
                </div>
                <div class="comments-info likes-info">
                    <h3>{!! $Employer_count !!}</h3>
                    <a href="{!! route('employer.index') !!}" style="color: #fff !important;"> Total Employers  </a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div>
       
     <!--    <div class="col-md-3 top-comment-grid" style="margin-top: 1rem;">
          <a href="#">
            <div class="comments tweets">
                <div class="comments-icon">
                    <img src="{{ url('/') }}/images/product_ic.png" class="side_icon">
                </div>
                <div class="comments-info tweets-info">
                    <h3>0</h3>
                    <a href="#">Total Plan</a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div> -->
       <!--  <div class="col-md-3 top-comment-grid">
          <a href="#">
            <div class="comments tweets">
                <div class="comments-icon">
                    <img src="{{ url('/') }}/images/product_ic.png" class="side_icon">
                </div>
                <div class="comments-info tweets-info">
                    <h3>0</h3>
                    <a href="#">New Plan</a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div> -->

        <div class="col-md-3 top-comment-grid">
          <a href="{!! route('jobs-list.index') !!}">
            <div class="comments views">
                <div class="comments-icon">
                    <i class="fa fa-briefcase" style="color: #fff; font-size: 4em !important;margin: 0;padding: 0;"></i>

                </div>
                <div class="comments-info views-info">
                    <h3>{{ $total_job_count->total }}</h3>
                    <a href="{!! route('jobs-list.index') !!}" style="color: #fff !important;">Total Jobs</a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div> 

        <div class="col-md-3 top-comment-grid">
          <a href="{!! route('jobs-list.index') !!}">
            <div class="comments views">
                <div class="comments-icon">
                    <i class="fa fa-briefcase" style="color: #fff; font-size: 4em !important;margin: 0;padding: 0;"></i>

                </div>
                <div class="comments-info views-info">
                    <h3>{{ $active_jobs }}</h3>
                    <a href="{!! route('jobs-list.index') !!}" style="color: #fff !important;">Active Jobs</a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div> 
        
        <div class="clearfix"> </div>
    </div>
    </div>

    <div class="social grid col-md-12">
    <div class="grid-info row">
        <div class="col-md-6" style="padding-left: 0px;">
            <h5 style="text-align: center; margin-top: 30px; font-weight: 600; font-size: 18px;">Employers Registration</h5>
            <div id="chartContainer" style="height: 370px; width: 100%;margin-top:20px;"></div>
            <div class="remove_marker"></div>
        </div>
        <div class="col-md-6" style="padding-right: 0px;">
            <h5 style="text-align: center; margin-top: 30px; font-weight: 600; font-size: 18px;">Candidates Registration</h5>
           <div id="revContainer" style="height: 370px; width: 100%;margin-top:20px;"></div>
           <div class="remove_marker"></div>
        </div>


   
    </div>
  </div>

  
@endsection
<html>
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body style=" margin: 0;
    background: #FEFEFE;
    color: #585858;
    ">

    <span class="preheader" style="display: none !important; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;border-collapse: collapse;border: 0px;"></span>
    <!-- Carpool logo -->
    <table align="center" border="0" cellspacing="0" cellpadding="0" style="font-size: 15px; line-height: 23px; max-width: 500px; min-width: 460px; text-align: center;">
      <tbody>
        <tr>
          <td style=" font-family: -apple-system, BlinkMacSystemFont, Roboto, sans-serif; vertical-align: top;
            border: none !important;">
            <img src="{{route('home')}}/assets/frontend/images/logo.svg" class="carpool_logo" width="200" style="display: block; margin: 0 auto; margin: 30px auto;">
          </td>
        </tr>
        <!-- Header -->
        <tr>
          <td class="sectionlike imageless_section" style=" font-family: -apple-system, BlinkMacSystemFont, Roboto, sans-serif; vertical-align: top; border: none !important; background: #C9F9E9; padding-bottom: 10px; padding-bottom: 20px;"></td>
        </tr>
        <!-- Content -->
        <tr>
          <td class="section" style=" font-family: -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            vertical-align: top; border: none !important; background: #C9F9E9; padding: 0px 20px 20px 20px; ">
            <table border="0" cellspacing="0" cellpadding="0" class="section_content" style=" font-size: 15px;
              line-height: 23px; max-width: 600px; min-width: 460px; text-align: center; width: 100%; background: #fff;">
              <tbody>
                <tr>
                  <td class="section_content_padded" style="  font-family: -apple-system, BlinkMacSystemFont, Roboto, sans-serif; vertical-align: top; border: none !important; padding: 0 15px 40px;">
                    <h1 style=" font-size: 20px; font-weight: 500; margin-top: 40px; margin-bottom: 0;">New Plan Purchase</h1>
                    <table>
                      <tr>
                        <td style="font-size: 15px;"><b>Employer Name</b></td>
                        <td style="font-size: 15px;">{{ $employer_name }}</td>
                      </tr>
                      <tr>
                        <td style="font-size: 15px;"><b>Member Name</b></td>
                        <td style="font-size: 15px;">{{ $name }}</b></td>
                      </tr>
                      <tr>
                        <td style="font-size: 15px;"><b>Plan Name</b></td>
                        <td style="font-size: 15px;">{{ $plan->name }}</td>
                      </tr>
                      @if($plan->category == 1)
                      <tr>
                        <td style="font-size: 15px;"><b>Job Post</b></td>
                        <td style="font-size: 15px;">{{ $plan->quantity }}</td>
                      </tr>
                      @if($plan->job_description == 1)
                      <tr>
                        <td style="font-size: 15px;" colspan="2">Detailed Job Description</td>
                      </tr>
                      @else
                      <tr>
                        <td style="font-size: 15px;" colspan="2">250 Characters in Job Description</td>
                      </tr>  
                      @endif

                      @if($plan->city == 1)
                      <tr>
                        <td style="font-size: 15px;" colspan="2">All Cities</td>
                      </tr>
                      @else
                      <tr>
                        <td style="font-size: 15px;" colspan="2">Non-Metro Cities</td>
                      </tr>  
                      @endif

                      @if($plan->job_search == 1)
                      <tr>
                        <td style="font-size: 15px;" colspan="2">Boost on Job Search Page</td>
                      </tr>
                      @endif

                      @if($plan->job_branding == 1)
                      <tr>
                        <td style="font-size: 15px;" colspan="2">Job Branding</td>
                      </tr>
                      @endif

                      @else
                      <tr>
                        <td style="font-size: 15px;"><b>Profile View</b></td>
                        <td style="font-size: 15px;">{{ $plan->profile_view }}</td>
                      </tr>
                      <tr>
                        <td style="font-size: 15px;"><b>Duration</b></td>
                        <td style="font-size: 15px;">{{ $plan->duration }} Days</td>
                      </tr>
                      @endif
                      <tr>
                        <td style="font-size: 15px;"><b>Transaction ID</b></td>
                        <td style="font-size: 15px;">{{ $payment_id }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <!-- Legal footer -->
        <tr>
          <td style=" font-family: -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            vertical-align: top;
            border: none !important;
            ">
            <p class="footer_legal" style=" padding: 20px 0 40px;
              margin: 0;
              font-size: 12px;
              color: #A5A5A5;
              line-height: 1.5;
              ">
              All Rights Reserved © Copyright 2022 ez-job.co.
            </p>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
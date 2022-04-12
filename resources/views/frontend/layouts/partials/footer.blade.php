<!-- Start of footer area
    ============================================= -->
   {{--
@php
    $footer_data = json_decode(config('footer_data'));
@endphp
@if($footer_data != "")
<footer>
    <section id="footer-area" class="footer-area-section">
        <div class="container">
            <div class="footer-content pb10">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-widget ">
                            <div class="footer-logo mb35">
                                <img src="{{asset("storage/logos/".config('logo_b_image'))}}" alt="logo">
                            </div>
                            @if($footer_data->short_description->status == 1)
                                <div class="footer-about-text">
                                    <p>{!! $footer_data->short_description->text !!} </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            @if($footer_data->section1->status == 1)
                                @php
                                    $section_data = section_filter($footer_data->section1)
                                @endphp

                                @include('frontend.layouts.partials.footer_section',['section_data' => $section_data])
                            @endif

                            @if($footer_data->section2->status == 1)
                                @php
                                    $section_data = section_filter($footer_data->section2)
                                @endphp

                                @include('frontend.layouts.partials.footer_section',['section_data' => $section_data])
                            @endif

                            @if($footer_data->section3->status == 1)
                                @php
                                    $section_data = section_filter($footer_data->section3)
                                @endphp

                                @include('frontend.layouts.partials.footer_section',['section_data' => $section_data])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /footer-widget-content -->
            <div class="footer-social-subscribe mb65">
                <div class="row">
                    @if(($footer_data->social_links->status == 1) && (count($footer_data->social_links->links) > 0))
                        <div class="col-md-4">
                            <div class="footer-social ul-li ">
                                <h2 class="widget-title">@lang('labels.frontend.layouts.partials.social_network')</h2>
                                <ul>
                                    @foreach($footer_data->social_links->links as $item)
                                        <li><a href="{{$item->link}}"><i class="{{$item->icon}}"></i></a></li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    @endif

                    @if($footer_data->newsletter_form->status == 1)
                        <div class="col-md-8">
                            <div class="subscribe-form ml-0 ">
                                <h2 class="widget-title">@lang('labels.frontend.layouts.partials.subscribe_newsletter')</h2>

                                <div class="subs-form relative-position">
                                    <form action="{{route("subscribe")}}" method="post">
                                        @csrf
                                        <input class="email" required name="subs_email" type="email" placeholder="@lang('labels.frontend.layouts.partials.email_address').">
                                        <div class="nws-button text-center  gradient-bg text-uppercase">
                                            <button type="submit" value="Submit">@lang('labels.frontend.layouts.partials.subscribe_now')</button>
                                        </div>
                                        @if($errors->has('email'))
                                            <p class="text-danger text-left">{{$errors->first('email')}}</p>
                                        @endif
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($footer_data->bottom_footer->status == 1)
            <div class="copy-right-menu">
                <div class="row">
                    @if($footer_data->copyright_text->status == 1)
                    <div class="col-md-6">
                        <div class="copy-right-text">
                            <p>Powered By <a href="https://www.neonlms.com/" target="_blank" class="mr-4"> NeonLMS</a>  {!!  $footer_data->copyright_text->text !!}</p>
                        </div>
                    </div>
                    @endif
                    @if(($footer_data->bottom_footer_links->status == 1) && (count($footer_data->bottom_footer_links->links) > 0))
                    <div class="col-md-6">
                        <div class="copy-right-menu-item float-right ul-li">
                            <ul>
                                @foreach($footer_data->bottom_footer_links->links as $item)
                                <li><a href="{{$item->link}}">{{$item->label}}</a></li>
                                @endforeach
                                @if(config('show_offers'))
                                    <li><a href="{{route('frontend.offers')}}">@lang('labels.frontend.layouts.partials.offers')</a> </li>
                                @endif
                                <li><a href="{{route('frontend.certificates.getVerificationForm')}}">@lang('labels.frontend.layouts.partials.certificate_verification')</a></li>
                            </ul>
                        </div>
                    </div>
                     @endif
                </div>
            </div>
            @endif
        </div>
    </section>
</footer>
@endif

-->
<footer class="site-footer">
  <div class="footer-top bg-dark text-white-0_6 pt-5 paddingBottom-100">
    <div class="container"> 
      <div class="row">

        <div class="col-lg-3 col-md-6 mt-5">
         <img src="assets/img/small-logo-blue.png" alt="Logo">
         <div class="margin-y-40">
           <p>
            Nunc placerat mi id nisi interdm they mtolis. Praesient is haretra justo ught scel erisque placer.
          </p>
         </div>
          <ul class="list-inline"> 
            <li class="list-inline-item"><a class="iconbox bg-white-0_2 hover:primary" href=""><i class="ti-facebook"> </i></a></li>
            <li class="list-inline-item"><a class="iconbox bg-white-0_2 hover:primary" href=""><i class="ti-twitter"> </i></a></li>
            <li class="list-inline-item"><a class="iconbox bg-white-0_2 hover:primary" href=""><i class="ti-linkedin"> </i></a></li>
            <li class="list-inline-item"><a class="iconbox bg-white-0_2 hover:primary" href=""><i class="ti-pinterest"></i></a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 mt-5">
          <h4 class="h5 text-white">Contact Us</h4>
          <div class="width-3rem bg-primary height-3 mt-3"></div>
          <ul class="list-unstyled marginTop-40">
            <li class="mb-3"><i class="ti-headphone mr-3"></i><a href="tel:+8801740411513">570.580.4121 </a></li>
            <li class="mb-3"><i class="ti-email mr-3"></i><a href="mailto:support@educati.com">support@dotcomlesson.com</a></li>
            <li class="mb-3">
             <div class="media">
              <i class="ti-location-pin mt-2 mr-3"></i>
              <div class="media-body">
                <span> 560 Main Street <br>Stroudsburg, PA 18360 <br>United States</span>
              </div>
             </div>
            </li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-6 mt-5">
          <h4 class="h5 text-white">Quick links</h4>
          <div class="width-3rem bg-primary height-3 mt-3"></div>
          <ul class="list-unstyled marginTop-40">
            <li class="mb-2"><a href="about">About Us</a></li>
            <li class="mb-2"><a href="contact_us">Contact Us</a></li>
            <li class="mb-2"><a href="terms">Terms and Conditions</a></li>
            <li class="mb-2"><a href="privacy">Privacy Policy</a></li>
           
          </ul>
        </div>

        
      </div> <!-- END row-->
    </div> <!-- END container-->
  </div> <!-- END footer-top-->

  <div class="footer-bottom bg-black-0_9 py-5 text-center">
    <div class="container">
      <p class="text-white-0_5 mb-0">( Dotcom Lesson LLC ) Powered by Dotcom Lessons LLC</p>
    </div>
  </div>  <!-- END footer-bottom-->
</footer>--}}
<!-- End of footer area
============================================= -->
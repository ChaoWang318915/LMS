@include('header')
@extends('frontend.layouts.app'.config('theme_layout'))
@section('title', trans('labels.frontend.course.courses').' | '. app_name() )

@push('after-styles')
    <style>
        .couse-pagination li.active {
            color: #333333 !important;
            font-weight: 700;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color: white;
            border: none;

        }
     .listing-filter-form select{
            height:50px!important;
        }

        ul.pagination {
            display: inline;
            text-align: center;
        }
        #course-page > div > div > div.col-md-3 > div > div:nth-child(2) {
    display: none;
}

.col-xl-7.col-lg-7.col-md-7.col-sm-7.nav_grid {
    margin: 0;
}
    </style>
@endpush

    <!-- Start of breadcrumb section
        ============================================= -->
        <header>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 top_grid">

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 offset-md-8">
      @if(!auth()->check())

       <a href="/registration_user"> <button class="top_grid_button_reg"><i class="fa fa-user" aria-hidden="true"></i>
register</button></a>

@else
 <a href="/logout"> <button class="top_grid_button_reg"><i class="fas fa-sign-out-alt"></i>
logout</button></a>

@endif


@if(!auth()->check())
<button class="top_grid_button_log" data-toggle="modal" data-target="#myModal"><i class="fas fa-sign-in-alt"></i>
Log In</button>
@else
<a href="/wallet"><button class="top_grid_button_log" data-toggle="modal" data-target="#myModal" style="width:120px"><i class="fas fa-tachometer-alt"></i>
dashboard</button></a>

@endif
    </div>
    </div>
        <!-- header inner -->
        <div class="header">
            <div class="container-fluid pages_breadcrumb_header">
               
            <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 logo_grid">
             <div class="logo"><a href="/"><img src="{{asset('homeassets/images/logo.jpg')}}" alt=""></a></div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 nav_grid">
            <div class="menu-area">
                            <div class="limit-box">
                                <nav class="main-menu">
                                    <ul class="menu-area-main">
                                        @if($menu_item != "")
                                            @foreach($menu_item as $menu)
                                               <li class="active"> <a href="{{$menu->link}}">{{$menu->label}}</a></li>
                                            @endforeach
                                       @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                  </div>
            </div>
            
        
        <!-- end header inner -->
    </header>
    @include('frontend.layouts.modals.loginModal')

    <!-- End of breadcrumb section
        ============================================= -->


    <!-- Start of course section
        ============================================= -->
    <section id="course-page" class="course-page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif
                    
                    
                     @if(session()->has('error'))
                        <div class="alert alert-dismissable alert-danger fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('error')}}
                        </div>
                    @endif
                    <div class="short-filter-tab">
                        <div class="shorting-filter w-50 d-inline float-left mr-3">
                            <span>@lang('labels.frontend.course.sort_by')</span>
                            <select id="sortBy" class="form-control d-inline w-50">
                                <option value="">@lang('labels.frontend.course.none')</option>
                                <option value="popular">@lang('labels.frontend.course.popular')</option>
                                <option value="trending">@lang('labels.frontend.course.trending')</option>
                                <option value="featured">@lang('labels.frontend.course.featured')</option>
                            </select>
                        </div>

                        <div class="tab-button blog-button ul-li text-center float-right">
                            <ul class="product-tab">
                                <li class="active" rel="tab1"><i class="fas fa-th"></i></li>
                                <li rel="tab2"><i class="fas fa-list"></i></li>
                            </ul>
                        </div>

                    </div>

                    <div class="genius-post-item">
                        <div class="tab-container">
                            <div id="tab1" class="tab-content-1 pt35">
                                <div class="best-course-area best-course-v2">
                                    <div class="row">
                                        @if($courses->count() > 0)

                                            @foreach($courses as $course)
                                                <div class="col-md-4">
                                                    <div class="best-course-pic-text relative-position">
                                                        <div class="best-course-pic relative-position"
                                                             @if($course->course_image != "") style="background-image: url('{{asset('storage/uploads/'.$course->course_image)}}')" @endif>

                                                            @if($course->trending == 1)
                                                                <div class="trend-badge-2 text-center text-uppercase">
                                                                    <i class="fas fa-bolt"></i>
                                                                    <span>@lang('labels.frontend.badges.trending')</span>
                                                                </div>
                                                            @endif
                                                                @if($course->free == 1)
                                                                    <div class="trend-badge-3 text-center text-uppercase">
                                                                        <i class="fas fa-bolt"></i>
                                                                        <span>@lang('labels.backend.courses.fields.free')</span>
                                                                    </div>
                                                                @endif
                                                            <div class="course-price text-center gradient-bg">
                                                                @if($course->free == 1)
                                                                    <span>{{trans('labels.backend.courses.fields.free')}}</span>
                                                                @else
                                                                    <span> {{$appCurrency['symbol'].' '.$course->price}}</span>
                                                                @endif
                                                            </div>

                                                            <div class="course-rate ul-li">
                                                                <ul>
                                                                    @for($i=1; $i<=(int)$course->rating; $i++)
                                                                        <li><i class="fas fa-star"></i></li>
                                                                    @endfor
                                                                </ul>
                                                            </div>
                                                            <div class="course-details-btn">
                                                                <a href="{{ route('courses.show', [$course->slug]) }}">@lang('labels.frontend.course.course_detail')
                                                                    <i class="fas fa-arrow-right"></i></a>
                                                            </div>
                                                            <div class="blakish-overlay"></div>
                                                        </div>
                                                        <div class="best-course-text">
                                                            <div class="course-title mb20 headline relative-position">
                                                                <h3>
                                                                    <a href="{{ route('courses.show', [$course->slug]) }}">{{$course->title}}</a>
                                                                </h3>
                                                            </div>
                                                            <!--<div class="course-meta">-->
                                                            <!--    <span class="course-category"><a-->
                                                            <!--                href="{{route('courses.category',['category'=>$course->category->slug])}}">{{$course->category->name}}</a></span>-->
                                                            <!--    <span class="course-author"><a href="#">{{ $course->students()->count() }}-->
                                                            <!--            @lang('labels.frontend.course.students')</a></span>-->
                                                            <!--</div>-->
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        @else
                                            <h3>@lang('labels.general.no_data_available')</h3>
                                    @endif

                                    <!-- /course -->

                                    </div>
                                </div>
                            </div><!-- /tab-1 -->

                            <div id="tab2" class="tab-content-1">
                                <div class="course-list-view">
                                    <table>
                                        <tr class="list-head">
                                            <th>@lang('labels.frontend.course.course_name')</th>
                                            <th>@lang('labels.frontend.course.course_type')</th>
                                            <!--<th>@lang('labels.frontend.course.starts')</th>-->
                                        </tr>
                                        @if($courses->count() > 0)
                                            @foreach($courses as $course)
                                                <tr>
                                                    <td>
                                                        <div class="course-list-img-text">
                                                            <div class="course-list-img"
                                                                 @if($course->course_image != "") style="background-image: url({{asset('storage/uploads/'.$course->course_image)}})" @endif >
                                                            </div>
                                                            <div class="course-list-text">
                                                                <h3>
                                                                    <a href="{{ route('courses.show', [$course->slug]) }}">{{$course->title}}</a>
                                                                </h3>
                                                                <div class="course-meta">
                                                                <span class="course-category bold-font"><a
                                                                            href="{{ route('courses.show', [$course->slug]) }}">
                                                                        @if($course->free == 1)
                                                                            {{trans('labels.backend.courses.fields.free')}}
                                                                        @else
                                                                            {{$appCurrency['symbol'].' '.$course->price}}
                                                                        @endif
                                                                    </a></span>

                                                                    <div class="course-rate ul-li">
                                                                        <ul>
                                                                            @for($i=1; $i<=(int)$course->rating; $i++)
                                                                                <li><i class="fas fa-star"></i></li>
                                                                            @endfor
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="course-type-list">
                                                            <span><a href="{{route('courses.category',['category'=>$course->category->slug])}}">{{$course->category->name}}</a></span>
                                                        </div>
                                                    </td>
                                                    <!--<td>{{\Carbon\Carbon::parse($course->start_date)->format('d M Y')}}</td>-->
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">
                                                    <h3>@lang('labels.general.no_data_available')</h3>

                                                </td>
                                            </tr>
                                        @endif

                                    </table>
                                </div>
                            </div><!-- /tab-2 -->
                        </div>
                        <div class="couse-pagination text-center ul-li">
                            {{ $courses->links() }}
                        </div>
                    </div>


                </div>

                <div class="col-md-3">
                    <div class="side-bar">

                        <div class="side-bar-widget  first-widget">
                            <h2 class="widget-title text-capitalize">@lang('labels.frontend.course.find_your_course')</h2>
                            <div class="listing-filter-form pb30">
                                <form action="{{route('search-course')}}" method="get">

                                    <div class="filter-search mb20">
                                        <label class="text-uppercase">@lang('labels.frontend.course.category')</label>
                                        <select name="category" class="form-control listing-filter-form select">
                                            <option value="">@lang('labels.frontend.course.select_category')</option>
                                            @if(count($categories) > 0)
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>

                                                @endforeach
                                            @endif

                                        </select>
                                    </div>


                                    <div class="filter-search mb20">
                                        <label>@lang('labels.frontend.course.full_text')</label>
                                        <input type="text" class="" name="q" placeholder="{{trans('labels.frontend.course.looking_for')}}">
                                    </div>
                                    <button class="genius-btn gradient-bg text-center text-uppercase btn-block text-white font-weight-bold"
                                            type="submit">@lang('labels.frontend.course.find_courses') <i
                                                class="fas fa-caret-right"></i></button>
                                </form>

                            </div>
                        </div>

                        @if($recent_news->count() > 0)
                            <div class="side-bar-widget">
                                <h2 class="widget-title text-capitalize">@lang('labels.frontend.course.recent_news')</h2>
                                <div class="latest-news-posts">
                                    @foreach($recent_news as $item)
                                        <div class="latest-news-area">

                                            @if($item->image != "")
                                                <div class="latest-news-thumbnile relative-position"
                                                     style="background-image: url({{asset('storage/uploads/'.$item->image)}})">
                                                    <div class="blakish-overlay"></div>
                                                </div>
                                            @endif
                                            <div class="date-meta">
                                                <i class="fas fa-calendar-alt"></i> {{$item->created_at->format('d M Y')}}
                                            </div>
                                            <h3 class="latest-title bold-font"><a
                                                        href="{{route('blogs.index',['slug'=>$item->slug.'-'.$item->id])}}">{{$item->title}}</a>
                                            </h3>
                                        </div>
                                        <!-- /post -->
                                    @endforeach


                                    <div class="view-all-btn bold-font">
                                        <a href="{{route('blogs.index')}}">@lang('labels.frontend.course.view_all_news')
                                            <i class="fas fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>

                        @endif


                        @if($global_featured_course != "")
                            <div class="side-bar-widget">
                                <h2 class="widget-title text-capitalize">@lang('labels.frontend.course.featured_course')</h2>
                                <div class="featured-course">
                                    <div class="best-course-pic-text relative-position pt-0">
                                        <div class="best-course-pic relative-position "
                                             @if($global_featured_course->course_image != "") style="background-image: url({{asset('storage/uploads/'.$global_featured_course->course_image)}})" @endif>

                                            @if($global_featured_course->trending == 1)
                                                <div class="trend-badge-2 text-center text-uppercase">
                                                    <i class="fas fa-bolt"></i>
                                                    <span>@lang('labels.frontend.badges.trending')</span>
                                                </div>
                                            @endif
                                                @if($global_featured_course->free == 1)
                                                    <div class="trend-badge-3 text-center text-uppercase">
                                                        <i class="fas fa-bolt"></i>
                                                        <span>@lang('labels.backend.courses.fields.free')</span>
                                                    </div>
                                                @endif

                                        </div>
                                        <div class="best-course-text" style="left: 0;right: 0;">
                                            <div class="course-title mb20 headline relative-position">
                                                <h3>
                                                    <a href="{{ route('courses.show', [$global_featured_course->slug]) }}">{{$global_featured_course->title}}</a>
                                                </h3>
                                            </div>
                                            <!--<div class="course-meta">-->
                                            <!--    <span class="course-category"><a-->
                                            <!--                href="{{route('courses.category',['category'=>$global_featured_course->category->slug])}}">{{$global_featured_course->category->name}}</a></span>-->
                                            <!--    <span class="course-author">{{ $global_featured_course->students()->count() }}</span>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End of course section
        ============================================= -->

    <!-- Start of best course
   =============================================  -->
    @include('frontend.layouts.partials.browse_courses')
    <!-- End of best course
            ============================================= -->



@push('after-scripts')
    <script>
   
        $(document).ready(function () {
            $(document).on('change', '#sortBy', function () {
                if ($(this).val() != "") {
                    location.href = '{{url()->current()}}?type=' + $(this).val();
                } else {
                    location.href = '{{route('courses.all')}}';
                }
            })

            @if(request('type') != "")
            $('#sortBy').find('option[value="' + "{{request('type')}}" + '"]').attr('selected', true);
            @endif
        });

    </script>
@endpush
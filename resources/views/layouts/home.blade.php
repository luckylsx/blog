<!doctype html>
<html>
<head>
<meta charset="utf-8">
@yield('info')
<link href="{{asset('home/css/base.css')}}" rel="stylesheet">
<link href="{{asset('home/css/style.css')}}" rel="stylesheet">
<link href="{{asset('home/css/index.css')}}" rel="stylesheet">
<link href="{{asset('home/css/new.css')}}" rel="stylesheet">
<!--[if lt IE 9]>
<script src="{{asset('home/js/modernizr.js')}}"></script>
<![endif]-->
</head>
<body>
<header>
  <div id="logo"><a href="/"></a></div>
  <nav class="topnav" id="topnav">
    @foreach($navs as $nav)
      <a href="index.html"><span>{{$nav->nav_name}}</span><span class="en">{{$nav->nav_alias}}</span></a>
    @endforeach
  </nav>
</header>
@section('content')
    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($hot as $h)
            <li><a href="{{url('a/'.$h->art_id)}}" title="{{$h->art_title}}" target="_blank">{{$h->art_title}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($asort as $sort)
            <li><a href="{{url('a/'.$sort->art_id)}}" title="{{$sort->art_title}}" target="_blank">{{$sort->art_title}}</a></li>
        @endforeach
    </ul>
@show
<footer>
  <p>{{Config::get('web.CopyRight')}}　<a href="{{Config::get('web.CopyRight_url')}}" target="_blank">http://www.houdunwang.com</a> <a href="/">网站统计</a></p>
</footer>
<script src="{{asset('home/js/silder.js')}}"></script>
</body>
</html>

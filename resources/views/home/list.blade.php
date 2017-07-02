@extends("layouts.home")
@section('content')
<article class="blogs">
<h1 class="t_nav"><span>“慢生活”不是懒惰，放慢速度不是拖延时间，而是让我们在生活中寻找到平衡。</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$cate->cate_id)}}" class="n2">{{$cate->cate_name}}</a></h1>
<div class="newblog left">
    @foreach($articles as $art)
   <h2>{{$art->art_title}}</h2>
   <p class="dateview"><span>　发布时间：{{date('Y-m-d',$art->art_time)}}</span><span>作者：{{$art->art_editor}}</span><span>分类：[<a href="{{url('cate/'.$cate->cate_id)}}">{{$cate->cate_name}}</a>]</span></p>
    <figure><img src="{{url('uploads/' . $art->art_thumb)}}"></figure>
    <ul class="nlist">
      <p>{{$art->art_description}}</p>
        <a title="{{$art->art_title}}" href="{{url('a/'.$art->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <div class="line"></div>
    @endforeach
    <div class="page">
        {{$articles->links()}}
    </div>
</div>
<aside class="right">
    <div class="rnav">
        @if($submenu->all())
          <ul>
              @foreach($submenu as $key=>$s)
                <li class="rnav{{$key+1}}"><a href={{url('cate/'.$s->cate_id)}} target="_blank">{{$s->cate_name}}</a></li>
              @endforeach
         </ul>
        @endif
        <!-- Baidu Button BEGIN -->
        <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
        <script type="text/javascript" id="bdshell_js"></script>
        <script type="text/javascript">
            document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
        </script>
        <!-- Baidu Button END -->
    </div>
<div class="news">
    @parent
    </div>
</aside>
</article>
@endsection
@php
    $title = isset($metas['meta_title'])? strip_tags($metas['meta_title']):'GIRIYA TRI DHARMA SAKTI';
    $description = isset($metas['meta_description'])? strip_tags($metas['meta_description']):'Membantu Umat Dalam Melaksanakan Yadnya Dengan Kosep Sederhana, Namun Tidak mengurangi Makna';
    $logo = isset($metas['logo'])? '/storage/full/'.strip_tags($metas['logo']):'favicon.ico';
    $feature_image = isset($metas['meta_image'])? '/storage/full/'.strip_tags($metas['meta_image']):'/img/logo.jpg';

@endphp
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">

<link rel="icon" href="{{ $logo }}" type="image/x-icon" />
<link rel="canonical" href="{{ url()->current() }}" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $title  }}" />
<meta property="og:description" content="{{ $description}}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{isset($metas['nama_aplikasi'])? strip_tags($metas['nama_aplikasi']):''}}" />
<meta property="article:publisher" content="{{isset($metas['facebook_url'])? strip_tags($metas['facebook_url']):'https://www.facebook.com/'}}" />
<meta property="article:modified_time" content="{{ date('Y-m-d\TH:i:s+00:00') }}" />
<meta property="og:image" content="{{ env('APP_URL') }}{{ $feature_image}}" />
<meta property="og:image:width" content="1600" />
<meta property="og:image:height" content="1060" />
<meta property="og:image:type" content="image/jpeg" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $title  }}" />
<meta name="twitter:description" content="{{ $description}}" />
<meta name="twitter:image" content="{{ env('APP_URL') }}{{ $feature_image}}" />
<meta name="twitter:label1" content="Est. reading time" />
<meta name="twitter:data1" content="5 minutes" />

@extends('layouts.main')

@section('title')
<h1> Homepage <br /> </h1>
@endsection

@section('content')
<section id="banner">
    <div class="content">
        <header>
		<h1> Witam na stronie głównej <br /> </h1>
		<p>Aby rozpocząć, naciśnij przycisk: "menu"</p>
	</header>
        
	<ul class="actions">
            <li><a href=""  class="button big">menu</a></li>
	</ul>
    </div>
    
    <span class="image object">
	<img src="/project/resources/images/pic10.jpg" alt="" />
    </span>
</section>

@endsection



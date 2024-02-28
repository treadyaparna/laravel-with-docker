
@foreach ($data as $d)
    <div class="post">
        <h2>{{ $d['title'] }}</h2>
        <p>{{ $d['content'] }}</p>
    </div>
@endforeach

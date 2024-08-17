<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
</head>
<body>
    <h1>All Posts</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($posts as $post)
        <div style="margin-bottom: 20px;">
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->description }}</p>
            <a href="{{ url('/posts', $post->id) }}">Read More</a>
            <a href="{{ url('/blog/' . $post->id  ) }}">Edit</a>

            <form action="{{ url('/blog', $post->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" style="color: red;">Delete</button>
            </form>
        </div>
    @endforeach
</body>
</html>

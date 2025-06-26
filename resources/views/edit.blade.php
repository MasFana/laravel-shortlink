<!DOCTYPE html>
<html>
<head>
    <title>Edit ShortLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit ShortLink</h1>
        
        <form method="POST" action="{{ route('shorten.link.update', $shortLink->id) }}">
            @csrf
            @method('PUT')
            <div class="input-group mb-3">
                <input type="text" name="url" class="form-control" value="{{ $shortLink->url }}">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
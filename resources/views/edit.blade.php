<!DOCTYPE html>
<html>

    <head>
        <title>Edit ShortLink</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link type="image/x-icon" href="https://raw.githubusercontent.com/MasFana/laravel-shortlink/refs/heads/master/public/favicon.ico" rel="shortcut icon">
        <style>
            body {
                background-color: #212529;
                color: #fff;
            }

            .card {
                background-color: #2c3034;
                border-color: #373b3e;
                color: #fff;
            }

            .form-control {
                background-color: #2c3034;
                border-color: #373b3e;
                color: #fff;
            }

            .form-control:focus {
                background-color: #2c3034;
                border-color: #4d5154;
                color: #fff;
                box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
            }

            .form-label {
                color: #fff;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h1 class="mb-4 text-center">Edit ShortLink</h1>

            <div class="card p-4">
                <form method="POST" action="{{ route('shorten.link.update', $shortLink->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" for="url">URL</label>
                        <input class="form-control" id="url" name="url" type="url"
                            value="{{ $shortLink->url }}" required>
                        @error('url')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="code">Custom Code</label>
                        <input class="form-control" id="code" name="code" type="text"
                            value="{{ $shortLink->code }}" required>
                        @error('code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-secondary" href="{{ route('shorten.link.index') }}">Back</a>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </body>

</html>

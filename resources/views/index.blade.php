<!DOCTYPE html>
<html>

    <head>
        <title>MasFana's ShortLink</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #212529;
                color: #fff;
            }

            .table {
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
                box-shadow: 0 0 0 0.1rem rgba(255, 255, 255, 0.1);
            }

            .form-control::placeholder {
                color: #6c757d;
            }

            .form-label {
                color: #fff;
            }

            .alert-success {
                background-color: #1a472a;
                border-color: #2c5840;
                color: #fff;
            }

            .text-truncate {
                color: #fff;
            }

            .btn-outline-info {
                color: #0dcaf0;
            }

            .btn-outline-danger {
                color: #dc3545;
            }

            .btn-outline-secondary {
                color: #6c757d;
                border-color: #6c757d;
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }

            .btn-outline-secondary:hover {
                color: #fff;
                background-color: #6c757d;
            }
        </style>
        <script>
            function copyToClipboard(code) {
                const url = `${window.location.origin}/${code}`;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link berhasil disalin!');
                });
            }
        </script>
    </head>

    <body>
        <div class="container mt-5">
            <h1 class="mb-4 text-center">MasFana's ShortLink</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card mb-4 p-4">
                <form method="POST" action="{{ route('shorten.link.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="url">URL</label>
                        <input class="form-control" id="url" name="url" type="url" placeholder="Enter URL"
                            required>
                        @error('url')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="code">Custom Link (Optional)</label>
                        <input class="form-control" id="code" name="code" type="text"
                            placeholder="Enter custom code">
                        @error('code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Generate Short Link</button>
                </form>
            </div>

            <div class="container">
                <table class="table-dark table-hover table">
                    <thead>
                        <tr>
                            <th>Short Link</th>
                            <th></th>
                            <th>Original URL</th>
                            <th>Clicks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shortLinks as $link)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a class="text-info me-2" href="{{ route('shorten.link', $link->code) }}"
                                            target="_blank">
                                            {{ $link->code }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-sm btn-outline-secondary"
                                            onclick="copyToClipboard('{{ $link->code }}')">
                                            Copy
                                        </button>
                                    </div>
                                </td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $link->url }}</td>
                                <td>{{ $link->click_count }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-info"
                                            href="{{ route('shorten.link.edit', $link->id) }}">Edit</a>
                                        <form class="d-inline" action="{{ route('shorten.link.destroy', $link->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger ms-1" type="submit"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </body>

</html>

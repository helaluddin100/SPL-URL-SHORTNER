<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SPL Url Shortener</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="antialiased">



    <main class="main">

        <section class="landing">
            <div class="landing-text">
                <h1>More than just shorter links</h1>
                <p>
                    Build your brand’s recognition and get detailed insights on how your
                    links are performing.
                </p>
            </div>

        </section>
        <!-- Features -->
        <section class="features" id="features">
            <div class="container">
                <!-- Short URL Feature -->
                <div class="url-shorten-feature">
                    <form class="url-shorten-form" id="url-shorten-form">
                        @csrf
                        <div>
                            <input type="text" class="url-input" placeholder="Shorten a link here..."
                                autocomplete="off" />
                            <span class="alert"></span>
                        </div>
                        <button type="submit" class="btn btn-lg btn-plus-icon">Shorten It!</button>
                    </form>
                    <div class="url-shorten-results"></div>


                </div>

            </div>
        </section>

    </main>



    {{-- js --}}

    <script>
        document.getElementById('url-shorten-form').addEventListener('submit', async function(event) {
            event.preventDefault();

            const urlInput = document.querySelector('.url-input');
            const resultsDiv = document.querySelector('.url-shorten-results');
            const originalUrl = urlInput.value.trim();

            if (!originalUrl) {
                alert('Please enter a valid URL!');
                return;
            }

            try {
                const response = await fetch('/shorten', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        original_url: originalUrl
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to shorten URL.');
                }

                const data = await response.json();
                resultsDiv.innerHTML = `
                        <div class="shortened-url">
                            <p>Short URL: <a href="${data.short_url}" target="_blank">${data.short_url}</a></p>
                        </div>
                    `;
            } catch (error) {
                resultsDiv.innerHTML = `<p class="error">Error: ${error.message}</p>`;
            }
        });
    </script>

</body>

</html>

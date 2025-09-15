<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset='UTF-8'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/product/app.css', 'resources/js/product/app.js'])
    @endif
    <title>Карточка продукта</title>
</head>
<body>
<header class='d-flex flex-wrap justify-content-center py-3 border-bottom'>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-3 bg-body-tertiary rounded-3">

            </ol>
        </nav>
    </div>
</header>
<main class='d-flex' data-product-id='{{$id}}'>
    <div class='col-lg-8 mx-auto p-4 py-md-5 border-bottom'>
        <h1 class="text-body-emphasis"></h1>
        <p class="price fs-4 col-md-8"></p>
        <div class="mt-5">
            <a href="/catalog" class="btn btn-primary btn-lg px-4">Вернуться в каталог</a>
        </div>
    </div>
</main>
</body>
</html>

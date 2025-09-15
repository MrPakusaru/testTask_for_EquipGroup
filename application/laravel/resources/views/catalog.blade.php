<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset='UTF-8'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/catalog/app.css', 'resources/js/catalog/app.js'])
    @endif
    <title>Каталог</title>
</head>
<body>
    <header class='d-flex flex-wrap justify-content-center py-3 border-bottom'>
        <a class='d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none'>
            <svg class='bi me-2' width='40' height='32' aria-hidden='true'><use xlink:href='#bootstrap'></use></svg>
            <span class='fs-4'>Главная</span>
        </a>
    </header>
    <main class='d-flex'>
        <nav class='sidebar flex-shrink-0 p-3'>
            <div class='d-flex pb-3 mb-3 link-primary text-decoration-none border-bottom'>
                <span class='fs-5 fw-semibold'>Категории</span>
            </div>
            <ul class='categories list-unstyled ps-0'></ul>
        </nav>
        <div class='container d-flex flex-shrink-0 p-3 flex-column justify-content-between'>
            <div class='sort_by d-flex pb-3 mb-3 link-dark text-decoration-none border-bottom fs-5 justify-content-center align-items-start'>
                Сортировать:&nbsp;
                <a class='sort_by link-primary' data-sort='price_desc'>По цене &#8593;</a>
                &nbsp;|&nbsp;
                <a class='sort_by link-primary' data-sort='price'>По цене &#8595;</a>
                &nbsp;|&nbsp;
                <a class='sort_by link-primary' data-sort='name_desc'>По названию &#8593;</a>
                &nbsp;|&nbsp;
                <a class='sort_by link-primary' data-sort='name'>По названию &#8595;</a>
            </div>
            <ul class='product_list list-unstyled'></ul>
            <nav class='align-items-end'>
                <ul class="pagination justify-content-center"></ul>
            </nav>
        </div>
    </main>
</body>
</html>

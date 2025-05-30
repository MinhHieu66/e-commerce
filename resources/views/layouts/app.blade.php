<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục - E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-lg font-bold">E-Trade Admin</a>
            <div>
                <a href="{{ route('categories.index') }}" class="hover:text-gray-300 mx-2">Danh mục</a>
                {{-- Thêm các liên kết quản trị khác nếu cần --}}
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cozy Admin</title>
        <!-- Include Tailwind CSS stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <!-- Top Header -->
        <header class="bg-white shadow">
            <div class="container mx-auto flex justify-between items-center py-4 px-6">
                <!-- Left Side - Logo and Name -->
                <div class="flex items-center gap-2">
                <img src="{{ asset('logo.png') }}" class="h-10 w-20 rounded-md"/>
                    <a href="/" class="text-2xl font-semibold text-gray-800">Admin</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex flex-grow">
            <!-- Main Content Area -->
            <div class="flex-1 p-10">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>

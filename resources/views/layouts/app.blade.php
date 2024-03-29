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
        <header class="bg-gray-100 border-b">
            <div class="container mx-auto flex justify-between items-center py-4 px-6">
                <!-- Left Side - Logo and Name -->
                <div class="flex items-center gap-2">
                <img src="{{ asset('logo.png') }}" class="h-10 w-20 rounded-md"/>
                    <a href="/" class="text-2xl font-semibold text-gray-800">Admin</a>
                </div>
                <!-- Right Side - Logout Button -->
                <div>
                    @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-md font-semibold text-red-500 hover:text-red-600 focus:outline-none focus:underline"><i class="fas fa-sign-out-alt mr-2"></i>Logout</button>
                    </form>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex flex-grow">
            <!-- Sidebar -->
           <!-- Sidebar -->
<aside class="bg-gray-100  w-64 flex-shrink-0 border-r">
    <nav class="mt-10">
        <ul>
            <li>
                <a href="/" class="flex items-center py-4 px-4 pl-8  {{ request()->is('/') ? 'text-gray-100 bg-red-500' : 'text-gray-800' }}">
                    <i class="fas fa-tachometer-alt mr-4"></i> <!-- Dashboard Icon -->
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/users" class="flex items-center py-4 px-4 pl-8    {{ request()->is('users') ? 'text-gray-100 bg-red-500' : 'text-gray-800' }}">
                    <i class="fas fa-users mr-4"></i> <!-- Users Icon -->
                    Manage Users
                </a>
            </li>
            <li>
                <a href="/providers" class="flex items-center py-4 px-4 pl-8   {{ request()->is('providers') ? 'text-gray-100 bg-red-500' : 'text-gray-800' }}">
                    <i class="fas fa-building mr-4"></i> <!-- Service Providers Icon -->
                    Manage Providers
                </a>
            </li>
            <li>
                <a href="/categories" class="flex items-center py-4 px-4 pl-8    {{ request()->is('categories') ? 'text-gray-100 bg-red-500' : 'text-gray-800' }}">
                    <i class="fas fa-tags mr-4"></i> <!-- Categories Icon -->
                    Manage Categories
                </a>
            </li>
            <li>
                <a href="/services" class="flex items-center py-4 px-4 pl-8    {{ request()->is('services') ? 'text-gray-100 bg-red-500' : 'text-gray-800' }}">
                    <i class="fas fa-tools mr-4"></i> <!-- Services Icon -->
                    Manage Services
                </a>
            </li>
            <li>
                <a href="/discounts" class="flex items-center py-4 px-4 pl-8   {{ request()->is('discounts') ? 'text-gray-100 bg-red-500' : 'text-gray-800' }}">
                    <i class="fas fa-percent mr-4"></i> <!-- Discount Icon -->
                    Manage Discount
                </a>
            </li>
            <li>
                <a href="/bookings" class="flex items-center py-4 px-4 pl-8   {{ request()->is('bookings') ? 'text-gray-100 bg-red-500' : 'text-gray-800' }}">
                    <i class="fas fa-list mr-4"></i> <!-- Discount Icon -->
                    Manage Bookings
                </a>
            </li>
        </ul>
    </nav>
</aside>


            <!-- Main Content Area -->
            <div class="flex-1 p-10">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>

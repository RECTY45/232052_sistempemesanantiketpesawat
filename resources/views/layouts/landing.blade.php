<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Nusantara Airways - Jelajahi Keindahan Indonesia' }}</title>
    <meta name="description"
        content="Temukan keindahan Nusantara dengan Nusantara Airways. Pesan tiket pesawat dengan mudah dan nikmati perjalanan yang tak terlupakan ke seluruh penjuru Indonesia.">
    <meta name="keywords" content="tiket pesawat, indonesia, nusantara, travel, wisata, penerbangan">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon/travelo-logo.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-purple': '#696cff',
                        'secondary-purple': '#5f61e6',
                        'light-purple': '#e7e7ff',
                        'accent-gold': '#FFD700',
                        'biru-laut': '#1e40af',
                        'hijau-tropis': '#059669',
                        'coklat-tanah': '#92400e',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom Nusantara CSS -->
    <link href="{{ asset('css/nusantara.css') }}" rel="stylesheet">

    <style>
        /* Custom Sneat Purple Theme Colors */
        :root {
            --primary-purple: #696cff;
            --secondary-purple: #5f61e6;
            --light-purple: #e7e7ff;
            --putih-indonesia: #FFFFFF;
            --accent-gold: #FFD700;
            --biru-laut: #1e40af;
            --hijau-tropis: #059669;
            --coklat-tanah: #92400e;
        }

        .font-jakarta {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-crimson {
            font-family: 'Crimson Text', serif;
        }

        /* Ensure CTA section text is white */
        .cta-section h2,
        .cta-section p {
            color: #ffffff !important;
        }

        .cta-section p {
            opacity: 0.95;
        }

        .bg-batik {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23059669' fill-opacity='0.05'%3E%3Cpath d='M30 0c16.569 0 30 13.431 30 30 0 16.569-13.431 30-30 30C13.431 60 0 46.569 0 30 0 13.431 13.431 0 30 0zm0 6c13.255 0 24 10.745 24 24 0 13.255-10.745 24-24 24-13.255 0-24-10.745-24-24 0-13.255 10.745-24 24-24z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .gradient-indonesia {
            background: linear-gradient(135deg, #FF0000 0%, #FFFFFF 50%, #FF0000 100%);
        }

        .shadow-nusantara {
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.2), 0 0 0 1px rgba(255, 215, 0, 0.1);
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Custom animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'merah-putih': '#FF0000',
                        'putih-indonesia': '#FFFFFF',
                        'emas-nusantara': '#FFD700',
                        'biru-laut': '#1e40af',
                        'hijau-tropis': '#059669',
                        'coklat-tanah': '#92400e',
                    },
                    fontFamily: {
                        'jakarta': ['Plus Jakarta Sans', 'sans-serif'],
                        'crimson': ['Crimson Text', 'serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="font-jakarta bg-white">
    @yield('content')

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom Nusantara JavaScript -->
    <script src="{{ asset('js/nusantara.js') }}"></script>

    <script>
        AOS.init({
            duration: 1200,
            once: true,
            offset: 100
        });
    </script>

    @stack('scripts')
</body>

</html>
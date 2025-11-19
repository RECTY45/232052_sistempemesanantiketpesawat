@extends('layouts.landing')

@section('content')
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-md shadow-lg transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div>
                        <img src="{{ asset('img/favicon/travelo-logo.svg') }}" alt="Logo Travelo" class="h-12 w-auto">
                        <p class="text-xs text-gray-600">Jelajahi Keindahan Indonesia</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda"
                        class="text-gray-700 hover:text-primary-purple transition-colors font-medium">Beranda</a>
                    <a href="#destinasi"
                        class="text-gray-700 hover:text-primary-purple transition-colors font-medium">Destinasi</a>
                    <a href="#layanan"
                        class="text-gray-700 hover:text-primary-purple transition-colors font-medium">Layanan</a>
                    <a href="#tentang"
                        class="text-gray-700 hover:text-primary-purple transition-colors font-medium">Tentang</a>
                    <a href="{{ route('AuthLogin') }}"
                        class="bg-gradient-to-r from-primary-purple to-secondary-purple text-white px-6 py-2 rounded-full hover:shadow-lg transition-all duration-300 font-medium">
                        Masuk
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-merah-putih">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-4">
                    <a href="#beranda" class="text-gray-700 hover:text-primary-purple transition-colors">Beranda</a>
                    <a href="#destinasi" class="text-gray-700 hover:text-primary-purple transition-colors">Destinasi</a>
                    <a href="#layanan" class="text-gray-700 hover:text-primary-purple transition-colors">Layanan</a>
                    <a href="#tentang" class="text-gray-700 hover:text-primary-purple transition-colors">Tentang</a>
                    <a href="{{ route('AuthLogin') }}"
                        class="bg-gradient-to-r from-primary-purple to-secondary-purple text-white px-6 py-2 rounded-full text-center">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda"
        class="min-h-screen bg-gradient-to-br from-light-purple via-white to-blue-50 pt-20 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-batik opacity-30"></div>

        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-secondary-purple/20 rounded-full float-animation"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-primary-purple/20 rounded-full float-animation"
            style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-20 w-12 h-12 bg-light-purple/30 rounded-full float-animation"
            style="animation-delay: 4s;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center lg:text-left" data-aos="fade-right">
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-800 mb-6 font-crimson leading-tight">
                        Jelajahi
                        <span
                            class="bg-gradient-to-r from-primary-purple to-secondary-purple bg-clip-text text-transparent">
                            Keindahan
                        </span>
                        <br>Nusantara
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Temukan pesona Indonesia dari Sabang sampai Merauke. Pesan tiket pesawat dengan mudah dan nikmati
                        perjalanan yang tak terlupakan ke seluruh penjuru nusantara.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register.index') }}"
                            class="bg-gradient-to-r from-primary-purple to-secondary-purple text-white px-8 py-4 rounded-full font-semibold text-lg hover:shadow-nusantara transition-all duration-300 hover-scale">
                            <i class="fas fa-plane-departure mr-2"></i>
                            Mulai Perjalanan
                        </a>
                        <a href="#destinasi"
                            class="border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-full font-semibold text-lg hover:border-primary-purple hover:text-primary-purple transition-all duration-300">
                            <i class="fas fa-map-marked-alt mr-2"></i>
                            Lihat Destinasi
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary-purple font-crimson">500+</div>
                            <div class="text-sm text-gray-600">Destinasi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-secondary-purple font-crimson">50K+</div>
                            <div class="text-sm text-gray-600">Penumpang</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary-purple font-crimson">99%</div>
                            <div class="text-sm text-gray-600">Kepuasan</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative" data-aos="fade-left">
                    <div class="relative z-10">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                            alt="Keindahan Indonesia" class="rounded-2xl shadow-2xl hover-scale">
                    </div>
                    <!-- Decorative elements -->
                    <div
                        class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-secondary-purple to-primary-purple rounded-full opacity-20">
                    </div>
                    <div
                        class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-light-purple to-secondary-purple rounded-full opacity-20">
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#destinasi" class="text-gray-600 hover:text-primary-purple transition-colors">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </section>

    <!-- Destinations Section -->
    <section id="destinasi" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6 font-crimson">
                    Destinasi
                    <span class="bg-gradient-to-r from-primary-purple to-secondary-purple bg-clip-text text-transparent">
                        Populer
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Jelajahi keajaiban Indonesia mulai dari pantai eksotis, gunung megah, hingga budaya yang kaya di setiap
                    sudut nusantara
                </p>
            </div>

            <!-- Destinations Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Bali -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover-scale" data-aos="fade-up"
                    data-aos-delay="100">
                    <img src="https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                        alt="Bali" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-2xl font-bold mb-2 font-crimson">Bali</h3>
                        <p class="text-sm opacity-90 mb-3">Pulau Dewata yang memesona</p>
                        <div class="flex items-center text-primary-purple">
                            <span class="text-lg font-semibold">Dari Rp 850.000</span>
                        </div>
                    </div>
                    <div
                        class="absolute top-4 right-4 bg-primary-purple text-white px-3 py-1 rounded-full text-sm font-medium">
                        Populer
                    </div>
                </div>

                <!-- Yogyakarta -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover-scale" data-aos="fade-up"
                    data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                        alt="Yogyakarta"
                        class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-2xl font-bold mb-2 font-crimson">Yogyakarta</h3>
                        <p class="text-sm opacity-90 mb-3">Kota budaya dan sejarah</p>
                        <div class="flex items-center text-primary-purple">
                            <span class="text-lg font-semibold">Dari Rp 650.000</span>
                        </div>
                    </div>
                </div>

                <!-- Lombok -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover-scale" data-aos="fade-up"
                    data-aos-delay="300">
                    <img src="https://images.unsplash.com/photo-1505142468610-359e7d316be0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                        alt="Lombok"
                        class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-2xl font-bold mb-2 font-crimson">Lombok</h3>
                        <p class="text-sm opacity-90 mb-3">Keindahan alam yang menawan</p>
                        <div class="flex items-center text-primary-purple">
                            <span class="text-lg font-semibold">Dari Rp 950.000</span>
                        </div>
                    </div>
                    <div
                        class="absolute top-4 right-4 bg-secondary-purple text-white px-3 py-1 rounded-full text-sm font-medium">
                        Trending
                    </div>
                </div>

                <!-- Jakarta -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover-scale" data-aos="fade-up"
                    data-aos-delay="400">
                    <img src="https://images.unsplash.com/photo-1555993539-1732b0258235?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                        alt="Jakarta"
                        class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-2xl font-bold mb-2 font-crimson">Jakarta</h3>
                        <p class="text-sm opacity-90 mb-3">Ibu kota yang dinamis</p>
                        <div class="flex items-center text-primary-purple">
                            <span class="text-lg font-semibold">Dari Rp 750.000</span>
                        </div>
                    </div>
                </div>

                <!-- Medan -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover-scale" data-aos="fade-up"
                    data-aos-delay="500">
                    <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                        alt="Medan"
                        class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-2xl font-bold mb-2 font-crimson">Medan</h3>
                        <p class="text-sm opacity-90 mb-3">Kuliner dan budaya Sumatera</p>
                        <div class="flex items-center text-primary-purple">
                            <span class="text-lg font-semibold">Dari Rp 800.000</span>
                        </div>
                    </div>
                </div>

                <!-- Makassar -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover-scale" data-aos="fade-up"
                    data-aos-delay="600">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                        alt="Makassar"
                        class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 class="text-2xl font-bold mb-2 font-crimson">Makassar</h3>
                        <p class="text-sm opacity-90 mb-3">Gerbang Sulawesi</p>
                        <div class="flex items-center text-primary-purple">
                            <span class="text-lg font-semibold">Dari Rp 900.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="700">
                <a href="#"
                    class="inline-flex items-center bg-gradient-to-r from-primary-purple to-secondary-purple text-white px-8 py-4 rounded-full font-semibold hover:shadow-nusantara transition-all duration-300">
                    <i class="fas fa-map-marked-alt mr-2"></i>
                    Lihat Semua Destinasi
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-20 bg-gradient-to-br from-light-purple/30 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6 font-crimson">
                    Mengapa Memilih
                    <span class="bg-gradient-to-r from-primary-purple to-secondary-purple bg-clip-text text-transparent">
                        Nusantara Airways?
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Kami berkomitmen memberikan pengalaman penerbangan terbaik dengan layanan berkualitas tinggi dan
                    nilai-nilai Indonesia
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 hover-scale"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-primary-purple to-secondary-purple rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-crimson">Keamanan Terjamin</h3>
                    <p class="text-gray-600 mb-6">
                        Standar keamanan internasional dengan teknologi terdepan dan kru berpengalaman untuk menjamin
                        keselamatan perjalanan Anda.
                    </p>
                    <div class="flex items-center text-primary-purple font-semibold">
                        <span>Pelajari lebih lanjut</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 hover-scale"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-secondary-purple to-light-purple rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-crimson">Pelayanan Ramah</h3>
                    <p class="text-gray-600 mb-6">
                        Keramahan khas Indonesia dalam setiap layanan. Crew kami siap melayani dengan senyuman dan
                        kehangatan tradisi nusantara.
                    </p>
                    <div class="flex items-center text-secondary-purple font-semibold">
                        <span>Pelajari lebih lanjut</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 hover-scale"
                    data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-primary-purple to-accent-gold rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-dollar-sign text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-crimson">Harga Terjangkau</h3>
                    <p class="text-gray-600 mb-6">
                        Nikmati perjalanan berkualitas dengan harga yang bersahabat. Berbagai promo menarik untuk
                        menjelajahi Indonesia.
                    </p>
                    <div class="flex items-center text-primary-purple font-semibold">
                        <span>Pelajari lebih lanjut</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 hover-scale"
                    data-aos="fade-up" data-aos-delay="400">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-secondary-purple to-primary-purple rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-crimson">Tepat Waktu</h3>
                    <p class="text-gray-600 mb-6">
                        Komitmen ketepatan waktu yang tinggi. 95% penerbangan kami berangkat dan tiba sesuai jadwal yang
                        telah ditentukan.
                    </p>
                    <div class="flex items-center text-secondary-purple font-semibold">
                        <span>Pelajari lebih lanjut</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>

                <!-- Service 5 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 hover-scale"
                    data-aos="fade-up" data-aos-delay="500">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-primary-purple to-light-purple rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-wifi text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-crimson">Fasilitas Modern</h3>
                    <p class="text-gray-600 mb-6">
                        WiFi gratis, hiburan in-flight, dan fasilitas modern lainnya untuk kenyamanan perjalanan Anda ke
                        seluruh nusantara.
                    </p>
                    <div class="flex items-center text-primary-purple font-semibold">
                        <span>Pelajari lebih lanjut</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>

                <!-- Service 6 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 hover-scale"
                    data-aos="fade-up" data-aos-delay="600">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-light-purple to-secondary-purple rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-globe-asia text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-crimson">Jangkauan Luas</h3>
                    <p class="text-gray-600 mb-6">
                        Menghubungkan seluruh Indonesia dari Sabang hingga Merauke dengan jaringan rute terlengkap dan
                        frekuensi penerbangan optimal.
                    </p>
                    <div class="flex items-center text-secondary-purple font-semibold">
                        <span>Pelajari lebih lanjut</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Content -->
                <div data-aos="fade-right">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6 font-crimson">
                        Tentang
                        <span
                            class="bg-gradient-to-r from-primary-purple to-secondary-purple bg-clip-text text-transparent">
                            Nusantara Airways
                        </span>
                    </h2>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Nusantara Airways lahir dari cinta mendalam terhadap Indonesia. Kami percaya bahwa setiap perjalanan
                        adalah kesempatan untuk menemukan keindahan, budaya, dan keramahan yang tersebar di ribuan pulau
                        nusantara.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Dengan armada modern dan crew yang berpengalaman, kami berkomitmen menghadirkan pengalaman
                        penerbangan yang aman, nyaman, dan berkesan. Setiap detail dirancang dengan sentuhan Indonesia yang
                        autentik.
                    </p>

                    <!-- Values -->
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-primary-purple rounded-full flex items-center justify-center mt-1 mr-4">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Keamanan & Kenyamanan</h4>
                                <p class="text-gray-600">Prioritas utama dalam setiap penerbangan</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-6 h-6 bg-secondary-purple rounded-full flex items-center justify-center mt-1 mr-4">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Keramahan Indonesia</h4>
                                <p class="text-gray-600">Layanan dengan hati dan senyuman tulus</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-light-purple rounded-full flex items-center justify-center mt-1 mr-4">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-1">Cinta Nusantara</h4>
                                <p class="text-gray-600">Memperkenalkan keindahan Indonesia ke dunia</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="relative" data-aos="fade-left">
                    <div class="relative z-10">
                        <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                            alt="Tentang Nusantara Airways" class="rounded-2xl shadow-2xl">
                    </div>

                    <!-- Achievement Cards -->
                    <div class="absolute -bottom-8 -left-8 bg-white p-6 rounded-xl shadow-lg z-20">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-primary-purple rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-trophy text-white text-sm"></i>
                            </div>
                            <span class="font-semibold text-gray-800">10+ Tahun</span>
                        </div>
                        <p class="text-sm text-gray-600">Pengalaman melayani</p>
                    </div>

                    <div class="absolute -top-8 -right-8 bg-white p-6 rounded-xl shadow-lg z-20">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-secondary-purple rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-star text-white text-sm"></i>
                            </div>
                            <span class="font-semibold text-gray-800">4.9/5</span>
                        </div>
                        <p class="text-sm text-gray-600">Rating kepuasan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section
        class="cta-section py-20 bg-gradient-to-r from-primary-purple via-secondary-purple to-primary-purple relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-batik opacity-10"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6 font-crimson text-shadow" style="color: #ffffff !important;"
                data-aos="fade-up">
                Siap Jelajahi Indonesia?
            </h2>
            <p class="text-xl mb-10 leading-relaxed text-shadow" style="color: rgba(255, 255, 255, 0.95) !important;"
                data-aos="fade-up" data-aos-delay="100">
                Bergabunglah dengan ribuan traveler yang telah mempercayai Nusantara Airways untuk menjelajahi keindahan
                Indonesia
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('register.index') }}"
                    class="bg-white text-primary-purple px-10 py-4 rounded-full font-bold text-lg hover:shadow-xl transition-all duration-300 hover-scale">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </a>
                <a href="{{ route('AuthLogin') }}"
                    class="border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-primary-purple transition-all duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('img/favicon/travelo-logo.svg') }}" alt="Logo Travelo" class="h-12 w-auto">
                        <div>
                            <h3 class="text-xl font-bold font-crimson">Nusantara Airways</h3>
                            <p class="text-sm text-gray-400">Jelajahi Keindahan Indonesia</p>
                        </div>
                    </div>
                    <p class="text-gray-300 leading-relaxed mb-6">
                        Menghubungkan Indonesia dari Sabang hingga Merauke dengan pelayanan terbaik dan keamanan terjamin.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-purple transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-purple transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-purple transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary-purple transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 font-crimson">Tautan Cepat</h4>
                    <ul class="space-y-4">
                        <li><a href="#beranda" class="text-gray-300 hover:text-primary-purple transition-colors">Beranda</a>
                        </li>
                        <li><a href="#destinasi"
                                class="text-gray-300 hover:text-primary-purple transition-colors">Destinasi</a></li>
                        <li><a href="#layanan" class="text-gray-300 hover:text-primary-purple transition-colors">Layanan</a>
                        </li>
                        <li><a href="#tentang" class="text-gray-300 hover:text-primary-purple transition-colors">Tentang
                                Kami</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary-purple transition-colors">Hubungi Kami</a>
                        </li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 font-crimson">Layanan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-300 hover:text-primary-purple transition-colors">Pemesanan
                                Tiket</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary-purple transition-colors">Check-in
                                Daring</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary-purple transition-colors">Status
                                Penerbangan</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-primary-purple transition-colors">Informasi
                                Bagasi</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-primary-purple transition-colors">Layanan
                                Pelanggan</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 font-crimson">Kontak</h4>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-primary-purple mt-1 mr-3"></i>
                            <p class="text-gray-300">Jl. Kemerdekaan No. 17, Jakarta Pusat, Indonesia</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-primary-purple mr-3"></i>
                            <p class="text-gray-300">+62 21 1500 123</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-primary-purple mr-3"></i>
                            <p class="text-gray-300">info@nusantara-airways.co.id</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-800 my-12">

            <!-- Bottom Footer -->
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">
                    © 2025 Nusantara Airways. Seluruh hak cipta dilindungi undang-undang.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-primary-purple transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="text-gray-400 hover:text-primary-purple transition-colors">Syarat Layanan</a>
                    <a href="#" class="text-gray-400 hover:text-primary-purple transition-colors">Kebijakan Cookie</a>
                </div>
            </div>
        </div>
    </footer>

    @push('scripts')
        <script>
            // Toggle menu mobile
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });

            // Smooth scrolling untuk tautan anchor
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        // Tutup menu mobile jika terbuka
                        mobileMenu.classList.add('hidden');
                    }
                });
            });

            // Background navbar saat scroll
            window.addEventListener('scroll', function () {
                const navbar = document.getElementById('navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('bg-white/98');
                } else {
                    navbar.classList.remove('bg-white/98');
                }
            });

            // Tambah efek parallax ke hero section
            window.addEventListener('scroll', function () {
                const scrolled = window.pageYOffset;
                const hero = document.querySelector('#beranda');
                if (hero) {
                    hero.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });
        </script>
    @endpush
@endsection
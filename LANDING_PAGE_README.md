# Nusantara Airways Landing Page

Sebuah landing page yang cantik, berkualitas, dan profesional dengan kesan nusantara untuk sistem pemesanan tiket pesawat.

## 🎨 Fitur Desain

### Tema Nusantara

-   **Palet Warna Indonesia**: Merah Putih, Emas Nusantara, Hijau Tropis, Biru Laut
-   **Tipografi**: Kombinasi Plus Jakarta Sans (modern) dan Crimson Text (klasik)
-   **Pattern Batik**: Background dengan motif batik yang halus
-   **Gradien Indonesia**: Menggunakan warna bendera dan alam Indonesia

### Komponen Landing Page

#### 1. Navigation Bar

-   Logo dengan ikon pesawat dan gradient Indonesia
-   Menu responsive dengan mobile hamburger
-   Smooth scrolling ke section
-   Background blur saat scroll

#### 2. Hero Section

-   Judul dengan animasi typing effect
-   Background gradient dengan floating elements
-   Call-to-action buttons dengan hover effects
-   Statistik dengan animasi counter
-   Parallax scrolling effect

#### 3. Destinasi Populer

-   Grid layout responsive
-   Card hover dengan scale dan shadow effects
-   Badge untuk destinasi populer/trending
-   Gradient overlay pada gambar
-   Harga tiket dengan formatting Indonesia

#### 4. Layanan/Keunggulan

-   6 service cards dengan ikon dan animasi
-   Hover effects dengan glow dan lift
-   Ripple effect saat diklik
-   Gradien background yang berbeda untuk setiap card

#### 5. Tentang Perusahaan

-   Layout dua kolom dengan gambar dan teks
-   Achievement cards yang floating
-   Value proposition dengan checklist
-   Animasi fade-in saat scroll

#### 6. Call-to-Action Section

-   Background gradient merah-emas
-   Pattern batik overlay
-   Multiple CTA buttons
-   Text shadow untuk readability

#### 7. Footer

-   Grid layout dengan informasi lengkap
-   Social media icons dengan hover effects
-   Contact information
-   Quick links navigation

## 🚀 Fitur Teknis

### Responsivitas

-   Mobile-first design approach
-   Breakpoints untuk tablet dan desktop
-   Grid system yang flexible
-   Touch-friendly interactions

### Animasi & Interaksi

-   AOS (Animate On Scroll) library
-   Custom CSS animations
-   JavaScript hover effects
-   Smooth scrolling navigation
-   Loading transitions
-   Ripple effects

### Performance

-   Lazy loading untuk gambar
-   Optimized CSS dengan custom properties
-   Minified resources
-   Progressive enhancement

### Accessibility

-   Semantic HTML structure
-   ARIA labels untuk screen readers
-   Keyboard navigation support
-   High contrast ratios
-   Focus indicators

## 🛠️ Teknologi yang Digunakan

-   **Frontend**: HTML5, CSS3, JavaScript (ES6+)
-   **Framework**: Laravel Blade Templates
-   **Styling**: Tailwind CSS + Custom CSS
-   **Animations**: AOS Library + Custom Animations
-   **Icons**: Font Awesome 6
-   **Fonts**: Google Fonts (Plus Jakarta Sans, Crimson Text)
-   **Images**: Unsplash API untuk placeholder

## 📁 Struktur File

```
resources/views/
├── layouts/
│   └── landing.blade.php      # Layout khusus landing page
└── welcome.blade.php          # Landing page utama

public/
├── css/
│   └── nusantara.css         # Custom CSS untuk tema Indonesia
├── js/
│   └── nusantara.js          # JavaScript untuk interaktivitas
└── img/
    └── nusantara-logo.svg    # Logo custom dengan tema Garuda
```

## 🎯 Optimasi SEO

-   Meta tags yang optimal
-   Open Graph tags
-   Structured data untuk search engines
-   Semantic HTML untuk better indexing
-   Fast loading times
-   Mobile-friendly design

## 🌍 Tema Indonesia

### Nilai Kultural

-   Keramahan khas Indonesia
-   Slogan "Jelajahi Keindahan Indonesia"
-   Referensi "Sabang sampai Merauke"
-   Penggunaan bahasa Indonesia yang hangat

### Visual Elements

-   Palet warna bendera Indonesia
-   Motif batik sebagai background pattern
-   Ikon dan ilustrasi yang mencerminkan budaya
-   Gradient yang terinspirasi dari alam Indonesia

### Content Strategy

-   Destinasi populer di Indonesia
-   Nilai-nilai perusahaan yang sesuai budaya
-   Testimoni dan layanan yang relatable
-   Call-to-action yang mengajak eksplorasi

## 🔧 Setup & Installation

1. Pastikan Laravel sudah terinstall
2. Copy file-file yang diperlukan ke direktori yang sesuai
3. Update route di `web.php`
4. Akses halaman melalui root URL "/"

## 📱 Browser Support

-   Chrome 80+
-   Firefox 70+
-   Safari 13+
-   Edge 80+
-   Mobile browsers (iOS Safari, Chrome Mobile)

## 🎨 Customization

### Mengubah Warna

Edit variabel CSS di `nusantara.css`:

```css
:root {
    --merah-putih: #ff0000;
    --emas-nusantara: #ffd700;
    --hijau-tropis: #059669;
    /* ... */
}
```

### Menambah Destinasi

Edit section destinasi di `welcome.blade.php` dan tambahkan card baru dengan struktur yang sama.

### Kustomisasi Animasi

Modifikasi timing dan easing di `nusantara.js` atau tambahkan animasi CSS baru.

## 🚀 Next Steps

-   Integrasi dengan sistem booking yang sesungguhnya
-   Penambahan fitur pencarian destinasi
-   Implementasi sistem review dan rating
-   Penambahan blog/artikel travel
-   Integrasi dengan social media
-   Implementasi PWA features

---

**Dibuat dengan ❤️ untuk Indonesia**

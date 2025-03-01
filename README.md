<h1>PHP MVC Manajemen Perpustakaan Sederhana</h1>
<p>Proyek ini adalah aplikasi manajemen perpustakaan sederhana yang dibangun menggunakan PHP dengan pola arsitektur MVC (Model-View-Controller). Aplikasi ini memiliki fitur login, CRUD untuk data Kategori, Buku, dan Mahasiswa, serta Create & Update untuk Peminjaman dan Pengembalian. Logika di dalam data petugas juga diimplementasikan.</p>

<h2>Fitur</h2>
<ul>
    <li><strong>Login:</strong> Sistem login untuk petugas perpustakaan.</li>
    <li><strong>CRUD Kategori:</strong> Manajemen data kategori buku.</li>
    <li><strong>CRUD Buku:</strong> Manajemen data buku.</li>
    <li><strong>CRUD Mahasiswa:</strong> Manajemen data mahasiswa.</li>
    <li><strong>Peminjaman:</strong> Fitur peminjaman buku oleh mahasiswa.</li>
    <li><strong>Pengembalian:</strong> Fitur pengembalian buku oleh mahasiswa.</li>
    <li><strong>Logika Petugas:</strong> Hanya petugas dengan ID terkecil yang dapat menambahkan data petugas baru dan mengedit semua data petugas.</li>
</ul>

<h2>Persyaratan Sistem</h2>
<ul>
    <li><strong>Laragon:</strong> Sebagai lingkungan pengembangan lokal.</li>
    <li><strong>PHP:</strong> Versi 8.3.15.</li>
    <li><strong>MySQL:</strong> Versi 8.0.30.</li>
    <li><strong>Browser:</strong> Chrome, Firefox, atau browser modern lainnya.</li>
</ul>

<h2>Instalasi</h2>
<h3>1. Persiapkan Lingkungan Pengembangan</h3>
<p><strong>Unduh dan Install Laragon:</strong></p>
<ul>
    <li>Unduh Laragon dari situs resmi Laragon.</li>
    <li>Install Laragon di komputer Anda.</li>
</ul>
<p><strong>Pastikan PHP dan MySQL Terinstall:</strong></p>
<ul>
    <li>Buka Laragon, pastikan PHP versi 8.3.15 dan MySQL versi 8.0.30 sudah terinstall.</li>
</ul>

<h3>2. Clone atau Unduh Proyek</h3>
<p><strong>Clone Repository:</strong></p>
<pre><code>git clone https://github.com/kuroxsub/repository-name.git</code></pre>

<p><strong>Letakkan Proyek di Folder www Laragon:</strong></p>
<ul>
    <li>Salin folder proyek ke dalam folder <code>www</code> Laragon </li>
    <li>Beri nama folder sesuai keinginan, misalnya <code>library</code>.</li>
</ul>

<h3>3. Buat Database</h3>
<ul>
    <li>Buka Laragon, lalu klik <strong>Start All</strong>.</li>
    <li>Buka browser dan akses <code>http://localhost/phpmyadmin</code>.</li>
    <li>Buat database baru dengan nama <code>library</code>.</li>
    <li>Import file SQL proyek (bernama <code>library.sql</code>).</li>
</ul>

<h3>4. Konfigurasi Proyek</h3>
<p><strong>Atur File Konfigurasi:</strong></p>
<pre><code>define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library');</code></pre>
<p><strong>Atur Base URL:</strong></p>
<pre><code>define('BASEURL', 'http://localhost/{nama_folder}/public');</code></pre>

<h3>5. Jalankan Aplikasi</h3>
<ul>
    <li>Buka browser dan akses <code>http://localhost/{nama_folder}/public/</code>.</li>
    <li>Login dengan kredensial berikut:</li>
</ul>
<pre><code>Username: admin
Password: admin123</code></pre>
<pre><code>Username: petugas1
Password: petugas123</code></pre>
<pre><code>Username: petugas2
Password: petugas123</code></pre>

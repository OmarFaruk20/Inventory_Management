<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tooltip Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various help texts.
    |
    */

    'product_stock_alert' => "Produk stok sudah rendah.<br/><small class='text-muted'>Berdasarkan kuantitas peringatan produk yang diatur di layar tambah produk.<br> Beli produk ini sebelum stok terakhir.</small>",

    'payment_dues' => "Pembayaran tertunda untuk pembelian. <br/><small class='text-muted'>Berdasarkan jangka waktu pembayaran pemasok. <br/> Menampilkan pembayaran yang harus dibayar dalam 7 hari atau kurang.</small>",

    'input_tax' => 'Total pajak yang dipungut untuk penjualan dalam periode waktu yang dipilih.',

    'output_tax' => 'Total pajak yang dibayarkan untuk pembelian dalam periode waktu yang dipilih.',

    'tax_overall' => 'Perbedaan antara jumlah pajak yang dikumpulkan dan jumlah pajak yang dibayarkan dalam periode waktu yang dipilih.',

    'purchase_due' => 'Jumlah total yang belum dibayar untuk pembelian.',

    'sell_due' => 'Jumlah total yang akan diterima dari penjualan',

    'over_all_sell_purchase' => '-ve value = Jumlah yang harus dibayar <br>+ve Nilai = Jumlah yang akan diterima',

    'no_of_products_for_trending_products' => 'Jumlah produk paling terlaris akan dibandingkan dalam bagan di bawah ini.',

    'top_trending_products' => "Produk terlaris dari toko Anda. <br/><small class='text-muted'>Terapkan filter untuk mengetahui produk terlaris dalam Kategori, Merek, Lokasi Bisnis dll.</small>",

    'sku' => "ID produk unik atau Penyimpanan stok satuan <br><br>Biarkan kosong untuk membuat sku secara otomatis.<br><small class='text-muted'>Anda dapat memodifikasi awalan sku dalam pengaturan Bisnis.</small>",

    'enable_stock' => "Mengaktifkan atau menonaktifkan manajemen stok untuk suatu produk. <br><br><small class='text-muted'>Manajemen Stok harus dinonaktifkan biasanya untuk layanan. Contoh: Gunting Rambut, Reparasi, dll.</small>",

    'alert_quantity' => "Dapatkan peringatan ketika stok produk yang tercapai atau arahkan di bawah jumlah yang ditentukan.<br><br><small class='text-muted'>Produk dengan stok rendah akan ditampilkan di dasbor - bagian Peringatan Stok Produk.</small>",

    'product_type' => '<b>Single product</b>: Produk tanpa varian.
         <br> <b> Produk variabel </b>: Produk dengan varian seperti ukuran, warna, dll.',

    'profit_percent' => "Margin keuntungan default untuk produk. <br><small class='text-muted'>(<i>Anda dapat mengelola profit margin default di Pengaturan Bisnis.</i>)</small>",

    'pay_term' => "Pembayaran harus dibayar untuk pembelian/penjualan dalam periode waktu tertentu.<br/><small class='text-muted'>Semua pembayaran yang akan datang atau jatuh tempo akan ditampilkan di dasbor - Bagian Pembayaran Karena</small>",

    'order_status' => 'Produk dalam pembelian ini hanya akan tersedia untuk dijual jika <b> Status Pemesanan </b> adalah <b> Item Diterima</b>.',

    'purchase_location' => 'Lokasi bisnis dimana tempat produk yang dibeli akan tersedia untuk dijual.',

    'sale_location' => 'Lokasi bisnis dari tempat Anda ingin menjual',

    'sale_discount' => "Tetapkan 'Diskon Penjualan Default' untuk semua penjualan di Pengaturan Bisnis. Klik ikon edit di bawah untuk menambah/memperbarui diskon.",

    'sale_tax' => "Tetapkan 'Pajak Penjualan Defaul' untuk semua penjualan di Pengaturan Bisnis. Klik ikon edit di bawah ini untuk menambah/memperbarui Pajak Pesanan.",

    'default_profit_percent' => "Margin profit produk. <br><small class='text-muted'>Digunakan untuk menghitung harga jual berdasarkan harga pembelian yang dimasukkan. <br/> Anda dapat mengubah nilai ini untuk produk individual sambil menambahkan</small>",

    'fy_start_month' => 'Mulai bulan Tahun Keuangan untuk bisnis Anda',

    'business_tax' => 'Nomor pajak terdaftar untuk bisnis Anda.',

    'invoice_scheme' => "Skema Faktur juga format penomoran faktur. Pilih skema yang akan digunakan untuk lokasi bisnis ini<br><small class='text-muted'><i>Anda dapat menambahkan Skema Faktur baru </b> di Pengaturan Faktur</i></small>",

    'invoice_layout' => "Tata Letak Faktur yang akan digunakan untuk lokasi bisnis ini<br><small class='text-muted'>(<i>Anda dapat menambahkan <b> Tata Letak Faktur </b> baru di <b> Pengaturan Faktur<b></i>)</small>",

    'invoice_scheme_name' => 'Berikan nama singkat bermakna untuk Skema Faktur.',

    'invoice_scheme_prefix' => 'Awalan untuk Skema Faktur. <br> Awalan dapat berupa teks khusus atau tahun berjalan. Contoh: # XXXX0001, # 2018-0002',

    'invoice_scheme_start_number' => "Nomor mulai untuk penomoran faktur. <br><small class='text-muted'>Anda dapat membuatnya 1 atau nomor lain dari mana penomoran akan dimulai.</small>",

    'invoice_scheme_count' => 'Jumlah total faktur yang dihasilkan untuk Skema Faktur',

    'invoice_scheme_total_digits' => 'Panjang Nomor Faktur tidak termasuk Awalan Faktur',

    'tax_groups' => 'Tarif Grup Pajak - ditentukan di atas, untuk digunakan dalam kombinasi di bagian Pembelian/Jual.',

    'unit_allow_decimal' => "Desimal memungkinkan Anda untuk menjual produk terkait dalam pecahan.",

    'print_label' => 'Tambahkan produk -> Pilih informasi untuk ditampilkan dalam Label -> Pilih Pengaturan Barcode -> Tampilkan Label -> Cetak',

    'expense_for' => 'Pilih pengguna yang terkait dengan pengeluaran. <i>(Optional)</i><br/><small>Contoh: Gaji karyawan.</small>',
    
    'all_location_permission' => 'Jika <b> Semua Lokasi </b> dipilih, peran ini akan memiliki izin untuk mengakses semua lokasi bisnis',

    'dashboard_permission' => 'Jika tidak dicentang, hanya pesan Selamat Datang yang akan ditampilkan di Beranda.',

    'access_locations_permission' => 'Pilih semua lokasi yang dapat diakses oleh wewenang ini. Semua data untuk lokasi yang dipilih hanya akan ditampilkan menurut pengguna.<br/><br/><small>Sebagai Contoh: Anda dapat menggunakan ini untuk mendefinisikan <i> Mengelola Toko/Kasir/Stok/Cabang, </i> dari Lokasi tertentu.</small>',

    'print_receipt_on_invoice' => 'Aktifkan atau Nonaktifkan pencetakan otomatis faktur pada penyelesaian',

    'receipt_printer_type' => "<i> Pencetakan Berbasis Browser </i>: Tampilkan kotak dialog cetak di browser dengan melihat faktur <br/> <br/> <i> Gunakan Printer Receipt yang Dikonfigurasi </i>: Pilih printer receipt/termal yang dikonfigurasi untuk pencetakan",

    'adjustment_type' => '<i>Normal</i>: Penyesuaian untuk alasan normal seperti Kebocoran, Kerusakan dll. <br/><br/> <i>Abnormal</i>: Penyesuaian untuk alasan seperti Kebakaran, Kecelakaan, dll.',

    'total_amount_recovered' => 'Jumlah yang diperoleh dari asuransi atau memo penjualan atau lainnya',

    'express_checkout' => 'Tandai pembayaran & checkout selesai',
    'total_card_slips' => 'Jumlah total pembayaran kartu yang digunakan dalam register ini',
    'total_cheques' => 'Jumlah total cek yang digunakan dalam register ini',

    'capability_profile' => "Dukungan untuk perintah dan halaman kode bervariasi antara vendor dan model printer. Jika Anda tidak yakin, sebaiknya gunakan Profil Kemampuan 'simple'",

    'purchase_different_currency' => 'Pilih opsi ini jika pembelian Anda dalam mata uang yang berbeda dari mata uang bisnis Anda',

    'currency_exchange_factor' => "1 Beli Mata Uang =? Mata Uang Dasar <br> <small class='text-muted'>Anda dapat mengaktifkan/menonaktifkan 'Pembelian dalam mata uang lain' pada pengaturan bisnis.</small>",

    'accounting_method' => 'Metode akuntansi',

    'transaction_edit_days' => 'Jumlah hari dari Tanggal Transaksi hingga transaksi masih dapat diedit.',
    'stock_expiry_alert' => "Daftar stok yang berakhir pada :days hari <br> <small class='text-muted'>Anda dapat mengatur no. hari pada Pengaturan Bisnis </small>",
    'sub_sku' => "SKU adalah opsional. <br><br><small>Biarkan kosong untuk membuat SKU secara otomatis.<small>",
    'shipping' => "Tetapkan detail pengiriman dan biaya pengiriman. Klik ikon edit di bawah untuk menambah/memperbarui rincian dan biaya pengiriman."
];

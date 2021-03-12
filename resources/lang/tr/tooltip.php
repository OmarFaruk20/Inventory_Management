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

    'product_stock_alert' => "Düşük stoklu ürünleri<br/><small class='text-muted'>Ürün ekleme ekranında ayarlanan ürün uyarısı miktarına göre <br> Bu ürünleri stok bitmeden önce satın alın.</small>",

    'payment_dues' => "Ödeme beklenen Satın alımlar için <br/><small class='text-muted'>Tedarikçinin ödeme vadesine göre <br/> 7 gün veya daha kısa sürede ödenecek ödemeleri gösterir.</small>",

    'input_tax' => 'Seçilen sürede satışlar için toplanan toplam vergi.',

    'output_tax' => 'Seçilen süre boyunca satın alımlara ödenen toplam vergi.',

    'tax_overall' => 'Toplanan toplam vergi ile seçilen süre içinde ödenen toplam vergi arasındaki fark.',

    'purchase_due' => 'Satın alımlar için toplam ödenmemiş miktar.',

    'sell_due' => 'Satışlardan elde edilecek toplam tutar',

    'over_all_sell_purchase' => '-ve Değer = Ödenecek miktar <br>+ve Değer = Alınacak miktar',

    'no_of_products_for_trending_products' => 'Aşağıdaki tabloda karşılaştırılacak en çok göze çarpan trend ürün sayısı.',

    'top_trending_products' => "Mağazanızın en çok satan ürünleri. <br/><small class='text-muted'>Belirli Kategori, Marka, Şube vb. Trend ürünlerini görmek için filtreler uygulayın.</small>",

    'sku' => "Benzersiz ürün kimliği veya Stok  Birimi için <br><br> Stok kodu Sku'yu otomatik olarak oluşturmak için boş bırakın.<br><small class='text-muted'>İşletme ayarlarında sku önekini değiştirebilirsiniz.</small>",

    'enable_stock' => "Bir ürün için stok yönetimini etkinleştirin veya devre dışı bırakın. <br><br><small class='text-muted'>Stok Yönetimi çoğunlukla hizmetler için devre dışı bırakılmalıdır. Örnek: Saç Kesme, Onarım vb.</small>",

    'alert_quantity' => "Ürün stoğu belirtilen miktara ulaştığında veya altına düştüğünde uyarı alın.<br><br><small class='text-muted'>Stokları düşük olan ürünler kontrol panelinde gösterilecektir - Ürün Stok Uyarısı bölümü.</small>",

    'product_type' => '<b>Tek ürün</b>: Değişmeyen Ürün.
    <br><b>Değişen Ürün</b>: Ürün ve ürünün çeşitleri Boyut, renk vb.',

    'profit_percent' => "Ürün için varsayılan kar marjı. <br><small class='text-muted'>(<i>İş Ayarlarında varsayılan kar marjını yönetebilirsiniz.</i>)</small>",

    'pay_term' => "Verilen süre içerisinde alımlar için ödenecek ödemeler.<br/><small class='text-muted'>Yaklaşan tüm ödemeler veya vadesi gelen ödemeler gösterge panosunda gösterilecektir - Ödeme Süresi bölümü</small>",

    'order_status' => 'Bu satın alımdaki ürünler, yalnızca <b>Sipariş durumu</b> <b> Siparişi alınan öğelerden oluşur</b>.',

    'purchase_location' => 'Satın alınan ürünün satışa sunulacağı şube.',

    'sale_location' => 'Satmak istediğiniz yerin bulunduğu şube',

    'sale_discount' => "İşletme Ayarları'ndaki tüm satışlar için 'Varsayılan Satış İndirimi' değerini ayarlayın. İndirim eklemek / güncellemek için aşağıdaki düzenle simgesine tıklayın.",

    'sale_tax' => "İşletme Ayarları'ndaki tüm satışlar için 'Varsayılan Satış Vergisi'ni ayarlayın. Sipariş Vergisi eklemek / güncellemek için aşağıdaki düzenle simgesine tıklayın.",

    'default_profit_percent' => "Bir ürünün varsayılan kar marjı  <br><small class='text-muted'>Girilen satın alma fiyatına göre satış fiyatı üzerinden hesaplanır.<br/> Ekleme yaparken, tek tek ürünler için bu değeri değiştirebilirsiniz.</small>",

    'fy_start_month' => 'İşletmeniz için Mali Yıl Ayından Başlayın',

    'business_tax' => 'İşletmeniz için kayıtlı vergi numarası.',

    'invoice_scheme' => "Fatura Şeması, fatura numaralandırma formatı anlamına gelir. Bu şube için kullanılacak şemayı seçin<br><small class='text-muted'><i> Yeni Fatura Düzenini ekleyebilirsiniz</b> in Invoice Settings</i></small>",

    'invoice_layout' => "Bu şube için kullanılacak Fatura Düzeni<br><small class='text-muted'>(<i>Yeni ekleyebilirsiniz <b>Fatura Düzeni</b> in <b>Fatura Ayarları<b></i>)</small>",

    'invoice_scheme_name' => 'Fatura tasarımına kısa ve anlamlı bir ad verin.',

    'invoice_scheme_prefix' => 'Fatura tasarım Düzeninin Öneki.<br> Bir ön ek, özel bir metin veya geçerli bir yıl olabilir. Örnek: #XXXX0001, #2018-0002',

    'invoice_scheme_start_number' => "Fatura numaralandırması için başlangıç numarası. <br><small class='text-muted'> Numaralandırma başlangıcı için 1 veya herhangi bir numarayı yapabilirsiniz.</small>",

    'invoice_scheme_count' => 'Fatura tasarımı şeması için oluşturulan toplam fatura sayısı',

    'invoice_scheme_total_digits' => 'Fatura Öneki hariç Fatura Numarasının Uzunluğu',

    'tax_groups' => 'Grup Vergi Oranları - Yukarıda tanımlanmış, Alış / Satış bölümlerinde bir arada kullanılacak.',

    'unit_allow_decimal' => "Ondalıklar, ilgili ürünleri kesirlerle satmanıza izin verir.",

    'print_label' => 'Ürün ekle -> Etiketler de gösterilecek bilgileri seç -> Barkod Ayarını Seç -> Etiketleri Önizle -> Yazdır',

    'expense_for' => 'Giderin ilişkili olduğu kullanıcıyı seçin. <i>(İsteğe bağlı)</i><br/><small>Örnek: Bir çalışanın maaşı.</small>',
    
    'all_location_permission' => 'Eğer <b>Tüm Şubeler</b> bu rol seçilirse tüm şubelere erişim iznine sahip olacaktır',

    'dashboard_permission' => 'İşaretlenmezse, yalnızca Hoş Geldiniz mesajı Ana Sayfada görüntülenir.',

    'access_locations_permission' => 'Bu rolün erişebileceği tüm şubeleri seçin. Seçilen şubeler için tüm veriler sadece kullanıcıya gösterilecektir.<br/><br/><small>Örnek: Bunu tanımlamak için kullanabilirsiniz. <i>Mağaza Müdürü / Kasiyer / Stok Müdürü / Şube Müdürü, </i>belirli bir yerin.</small>',

    'print_receipt_on_invoice' => 'Faturanın otomatik yazdırılmasını etkinleştirin veya devre dışı bırakın',

    'receipt_printer_type' => "<i>Internet tarayıcı tabanlı yazıcı</i>: Fatura önizlemesini internet tarayıcıda yazdırma iletişim kutusunda göster <br/><br/> <i>Yapılandırılmış Fiş Yazıcısı Kullan</i>: Yazdırmak için yapılandırılmış bir fiş / termal yazıcı seçin",

    'adjustment_type' => '<i>Normal</i>: Kaçak, Hasar vb. Normal nedenlerden dolayı ayar yapılması. <br/><br/> <i>Anormal</i>: Yangın, Kaza vb. Sebeplerden dolayı ayar yapılması.',

    'total_amount_recovered' => 'Sigorta ya da hurda satışı veya diğerlerinden elde edilen meblağ',

    'express_checkout' => 'Tamamlanmış ödeme ve ödeme işlemi olarak işaretleyin',
    'total_card_slips' => 'Bu kasada kullanılan toplam kart ödeme sayısı',
    'total_cheques' => 'Bu kasada kullanılan toplam çek ödeme sayısı',

    'capability_profile' => "Komutlar ve kod sayfaları için yazıcı ayarları, yazıcı satıcıları ve modelleri arasında değişir. Emin değilseniz, 'basit' Yetenek Profilini kullanmak iyi bir fikirdir",

    'purchase_different_currency' => 'İşletme para biriminden farklı bir para biriminde satın alıyorsanız bu seçeneği seçin',

    'currency_exchange_factor' => "1 Satın Alma Para Birimi = ? Baz Alınacak Para Birimi <br> <small class='text-muted'>İşletme ayarlarından 'Diğer para biriminde satın alma' özelliğini etkinleştirebilir / devre dışı bırakabilirsiniz.</small>",

    'accounting_method' => 'Muhasebe yöntemi',

    'transaction_edit_days' => 'İşlem Tarihinden itibaren bir işlemin düzenlenebileceği gün sayısı.',
    'stock_expiry_alert' => "Süresi dolmuş stokların listesi :days gün <br> <small class='text-muted'>Gün numaralarını İşletme Ayarlarından Yapabilirsiniz.</small>",
    'sub_sku' => "Stok Kodu SKU isteğe bağlı.<br><br><small> Stok Kodu SKU Otomatik olarak oluşturmak için boş bırakın.<small>",
    'shipping' => "Nakliye ayrıntılarını ve nakliye ücretlerini ayarlayın. Gönderim detaylarını ve ücretlerini eklemek / güncellemek için aşağıdaki düzenle simgesine tıklayın."
];

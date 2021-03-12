<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Barcode;

class BarcodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Barcode::create([
            'id'=>1,
            'name'=>'20 Labels per Sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 4" x 1"\r\nLabels per sheet: 20',
            'width'=>3.75,
            'height'=>1,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.5,
            'row_distance'=>0.00,
            'col_distance'=>0.15625,
            'stickers_in_one_row'=>2,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>20,
            'business_id'=>null,
            'created_at'=>'2017-12-18 06:13:44',
            'updated_at'=>'2017-12-18 06:13:44'
        ]);
            
        Barcode::create([
            'id'=>2,
            'name'=>'30 Labels per sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 2.625" x 1"\r\nLabels per sheet: 30',
            'width'=>2.625,
            'height'=>1,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.21975,
            'row_distance'=>0.00,
            'col_distance'=>0.14,
            'stickers_in_one_row'=>3,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>30,
            'business_id'=>null,
            'created_at'=>'2017-12-18 06:04:39',
            'updated_at'=>'2017-12-18 06:10:40'
        ]);
            
        Barcode::create([
            'id'=>3,
            'name'=>'32 Labels per sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 2" x 1.25"\r\nLabels per sheet: 32',
            'width'=>2,
            'height'=>1.25,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.25,
            'row_distance'=>0.00,
            'col_distance'=>0,
            'stickers_in_one_row'=>4,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>32,
            'business_id'=>null,
            'created_at'=>'2017-12-18 05:55:40',
            'updated_at'=>'2017-12-18 05:55:40'
        ]);
            
        Barcode::create([
            'id'=>4,
            'name'=>'40 Labels per sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 2" x 1"\r\nLabels per sheet: 40',
            'width'=>2,
            'height'=>1,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.25,
            'row_distance'=>0.00,
            'col_distance'=>0.00,
            'stickers_in_one_row'=>4,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>40,
            'business_id'=>null,
            'created_at'=>'2017-12-18 05:58:40',
            'updated_at'=>'2017-12-18 05:58:40'
        ]);
            
        Barcode::create([
            'id'=>5,
            'name'=>'50 Labels per Sheet - (8.5" x 11")',
            'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 1.5" x 1"\r\nLabels per sheet: 50',
            'width'=>1.5,
            'height'=>1,
            'paper_width'=>8.5,
            'paper_height'=>11,
            'top_margin'=>0.5,
            'left_margin'=>0.5,
            'row_distance'=>0.00,
            'col_distance'=>0.00,
            'stickers_in_one_row'=>5,
            'is_default'=>0,
            'is_continuous'=>0,
            'stickers_in_one_sheet'=>50,
            'business_id'=>null,
            'created_at'=>'2017-12-18 05:51:10',
            'updated_at'=>'2017-12-18 05:51:10'
        ]);

        Barcode::create([
            'id'=>6,
            'name'=>'Continuous Rolls - 31.75mm x 25.4mm',
            'description'=>'Label Size: 31.75mm x 25.4mm\r\nGap: 3.18mm',
            'width'=>1.25,
            'height'=>1,
            'paper_width'=>1.25,
            'paper_height'=>0.00,
            'top_margin'=>0.125,
            'left_margin'=>0.00,
            'row_distance'=>0.125,
            'col_distance'=>0.00,
            'stickers_in_one_row'=>1,
            'is_default'=>0,
            'is_continuous'=>1,
            'stickers_in_one_sheet'=>null,
            'business_id'=>null,
            'created_at'=>'2017-12-18 05:51:10',
            'updated_at'=>'2017-12-18 05:51:10'
        ]);
            
        // Barcode::create( [
        // 	'name'=>'154 Per Sheet - (8.5" x 11")',
        // 	'description'=>'Sheet Size: 8.5" x 11"\r\nLabel Size: 25.4mm x 9.52mm\r\nLabels per sheet: 154',
        // 	'width'=>25.40,
        // 	'height'=>9.52,
        // 	'paper_width'=>8.5,
        // 	'paper_height'=>11,
        // 	'top_margin'=>8.79,
        // 	'left_margin'=>11.43,
        // 	'row_distance'=>2.54,
        // 	'col_distance'=>2.49,
        // 	'stickers_in_one_row'=>7,
        // 	'is_default'=>0,
        // 	'is_continuous'=>0,
        // 	'stickers_in_one_sheet'=>154,
        // 	'business_id'=>null,
        // 	'created_at'=>'2017-12-18 05:43:01',
        // 	'updated_at'=>'2017-12-18 05:45:54'
        // ] );
    }
}

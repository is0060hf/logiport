<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VouchersFixture
 *
 */
class VouchersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID', 'autoIncrement' => true, 'precision' => null],
        'deliveryman_name' => ['type' => 'string', 'length' => 128, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '氏名', 'precision' => null, 'fixed' => null],
        'car_numb' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '車番', 'precision' => null, 'fixed' => null],
        'cs' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'c/s', 'precision' => null, 'fixed' => null],
        'shipper_sign' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '荷主サイン有無', 'precision' => null, 'fixed' => null],
        'customers_name' => ['type' => 'string', 'length' => 256, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '得意先', 'precision' => null, 'fixed' => null],
        'delivery_dest' => ['type' => 'string', 'length' => 256, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '積込先', 'precision' => null, 'fixed' => null],
        'arrival_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '入庫時間', 'precision' => null],
        'departure_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '出庫時間', 'precision' => null],
        'customers_phone' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '得意先の連絡先', 'precision' => null, 'fixed' => null],
        'has_return_cargo' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '帰り荷の有無', 'precision' => null, 'fixed' => null],
        'appendix' => ['type' => 'string', 'length' => 1024, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '備考', 'precision' => null, 'fixed' => null],
        'dist_outward' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '往路距離', 'precision' => null, 'fixed' => null],
        'dist_return' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '復路距離', 'precision' => null, 'fixed' => null],
        'price_outword' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '往路金額', 'precision' => null, 'fixed' => null],
        'price_return' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '復路金額', 'precision' => null, 'fixed' => null],
        'cargo_handling_fee' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '荷扱い料', 'precision' => null, 'fixed' => null],
        'cargo_waiting_fee' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '貨物待料', 'precision' => null, 'fixed' => null],
        'sum_price1' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '計', 'precision' => null, 'fixed' => null],
        'tax' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '消費税', 'precision' => null, 'fixed' => null],
        'sum_price2' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '合計', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'データ作成日', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'データ更新日', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'deliveryman_name' => 'Lorem ipsum dolor sit amet',
                'car_numb' => 'Lorem ipsum dolor sit amet',
                'cs' => 'Lorem ipsum dolor sit amet',
                'shipper_sign' => 'Lorem ipsum dolor sit amet',
                'customers_name' => 'Lorem ipsum dolor sit amet',
                'delivery_dest' => 'Lorem ipsum dolor sit amet',
                'arrival_time' => '2018-12-28 05:28:48',
                'departure_time' => '2018-12-28 05:28:48',
                'customers_phone' => 'Lorem ipsum dolor sit amet',
                'has_return_cargo' => 'Lorem ipsum dolor sit amet',
                'appendix' => 'Lorem ipsum dolor sit amet',
                'dist_outward' => 'Lorem ipsum dolor sit amet',
                'dist_return' => 'Lorem ipsum dolor sit amet',
                'price_outword' => 'Lorem ipsum dolor sit amet',
                'price_return' => 'Lorem ipsum dolor sit amet',
                'cargo_handling_fee' => 'Lorem ipsum dolor sit amet',
                'cargo_waiting_fee' => 'Lorem ipsum dolor sit amet',
                'sum_price1' => 'Lorem ipsum dolor sit amet',
                'tax' => 'Lorem ipsum dolor sit amet',
                'sum_price2' => 'Lorem ipsum dolor sit amet',
                'created' => '2018-12-28 05:28:48',
                'modified' => '2018-12-28 05:28:48'
            ],
        ];
        parent::init();
    }
}

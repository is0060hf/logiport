<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DeliveriesFixture
 *
 */
class DeliveriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID', 'autoIncrement' => true, 'precision' => null],
        'voucher_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '伝票ID', 'precision' => null, 'autoIncrement' => null],
        'deliveries_or_cargo' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '積み込みor納品', 'precision' => null, 'fixed' => null],
        'destination' => ['type' => 'string', 'length' => 256, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '納品/積込先', 'precision' => null, 'fixed' => null],
        'distance' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '距離', 'precision' => null, 'autoIncrement' => null],
        'receipt_flg' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '受領書フラグ', 'precision' => null, 'fixed' => null],
        'arrival_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '到着時刻', 'precision' => null],
        'complete_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '完了時刻', 'precision' => null],
        'temperature' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '温度', 'precision' => null, 'fixed' => null],
        'receipt_sign' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '受領サイン有無', 'precision' => null, 'fixed' => null],
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
                'voucher_id' => 1,
                'deliveries_or_cargo' => 'Lorem ipsum dolor sit amet',
                'destination' => 'Lorem ipsum dolor sit amet',
                'distance' => 1,
                'receipt_flg' => 'Lorem ipsum dolor sit amet',
                'arrival_time' => '2018-12-28 05:29:11',
                'complete_time' => '2018-12-28 05:29:11',
                'temperature' => 'Lorem ipsum dolor sit amet',
                'receipt_sign' => 'Lorem ipsum dolor sit amet',
                'created' => '2018-12-28 05:29:11',
                'modified' => '2018-12-28 05:29:11'
            ],
        ];
        parent::init();
    }
}

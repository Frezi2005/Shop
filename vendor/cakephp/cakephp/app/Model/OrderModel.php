<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class Order extends Model {
    /**
     * @var String
     * @Primary
     * @Column(column="id", length="36", null="false")
     */
    public $id;

    /**
     * @var String
     * @Foreign
     * @Origin(table="customers")
     * @Column(column="customer_id", length="36", null="true")
     */
    public $customer_id;

    /**
     * @var String
     * @Column(column="country", length="56", null="true")
     */
    public $country;

    /**
     * @var String
     * @Column(column="city", length="85", null="true")
     */
    public $city;

    /**
     * @var String
     * @Column(column="street", length="75", null="true")
     */
    public $street;

    /**
     * @var String
     * @Column(column="house_number", length="5", null="true")
     */
    public $house_number;

    /**
     * @var String
     * @Column(column="products", length="255", null="false")
     */
    public $products;

    /**
     * @var String
     * @Column(column="delivery_type", length="255", null="false")
     */
    public $delivery_type;

    /**
     * @var String
     * @Column(column="order_date", length="-", null="false")
     */
    public $order_date;

    /**
     * @var String
     * @Column(column="order_date", length="-", null="false")
     */
    public $shipment_date;

    /**
     * @var Int
     * @Column(column="total_price", length="-", null="false")
     */
    public $total_price;

    /**
     * @var String
     * @Column(column="payment_method", length="255", null="false")
     */
    public $payment_method;

    /**
     * @var Int
     * @Column(column="order_points", length="-", null="false")
     */
    public $order_points;

    /**
     * @var String
     * @Foreign
     * @Origin(table="promo_codes")
     * @Column(column="promo_code_id", length="36", null="true")
     */
    public $promo_code_id;

    /**
     * @var String
     * @Column(column="currency", length="3", null="false")
     */
    public $currency;

    /**
     * @var String
     * @Foreign
     * @Origin(table="shops")
     * @Column(column="shop_id", length="36", null="true")
     */
    public $shop_id;

}

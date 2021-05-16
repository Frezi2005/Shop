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
class Product extends Model {
    /**
     * @var String
     * @Origin
     * @Column(column="id", length="36", null="false")
     */
    public $id;

    /**
     * @var String
     * @Column(column="name", length="50", null="false")
     */
    public $name;

    /**
     * @var String
     * @Column(column="description", length="255", null="false")
     */
    public $description;

    /**
     * @var Float
     * @Column(column="price", length="10", null="false", decimalPoints="2")
     */
    public $price;

    /**
     * @var String
     * @Column(column="category_name", length="50", null="false")
     */
    public $category_name;

    /**
     * @var Float
     * @Column(column="discount_value", length="3", null="false", decimalPoints="2")
     */
    public $discount_value;

    /**
     * @var String
     * @Foreign
     * @Origin(table="shops")
     * @Column(column="shop_id", length="36", null="true")
     */
    public $shop_id;

    /**
     * @var Float
     * @Column(column="tax", length="3", null="false", decimalPoints="2")
     */
    public $tax;

    /**
     * @var String
     * @Column(column="image", length="255", null="false")
     */
    public $image;

    /**
     * @var Int
     * @Column(column="product_count", length="-", null="false")
     */
    public $product_count;
}

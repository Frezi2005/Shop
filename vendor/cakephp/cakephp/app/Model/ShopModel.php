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
class Shop extends Model {
    /**
     * @var String
     * @Primary
     * @Column(column="id", length="36", null="false")
     */
    public $id;

    /**
     * @var String
     * @Column(column="name", length="255", null="false")
     */
    public $name;

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
     * @var Int
     * @Column(column="employee_count", length="-", null="false")
     */
    public $employee_count;

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
     * @var Float
     * @Column(column="budget", length="17", null="false", decimalPoints="2")
     */
    public $budget;

    /**
     * @var Float
     * @Column(column="income", length="17", null="false", decimalPoints="2")
     */
    public $income;

    /**
     * @var String
     * @Foreign
     * @Origin(table="products")
     * @Column(column="product_id", length="36", null="true")
     */
    public $product_id;

    /**
     * @var Int
     * @Column(column="product_count", length="-", null="false")
     */
    public $product_count;

}

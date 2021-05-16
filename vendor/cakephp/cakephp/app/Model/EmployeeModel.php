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
class Employee extends Model {
    /**
     * @var String
     * @Primary
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
     * @Column(column="surname", length="100", null="false")
     */
    public $surname;

    /**
     * @var String
     * @Column(column="email", length="255", null="false")
     */
    public $email;

    /**
     * @var String
     * @Column(column="password", length="255", null="false")
     */
    public $password;

    /**
     * @var String
     * @Column(column="birth_date", length="-", null="false")
     */
    public $birth_date;

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
     * @Column(column="flat_number", length="5", null="true")
     */
    public $flat_number;

    /**
     * @var String
     * @Column(column="phone_number", length="15", null="false")
     */
    public $phone_number;

    /**
     * @var String
     * @Column(column="id_number_and_series", length="9", null="false")
     */
    public $id_number_and_series;

    /**
     * @var Float
     * @Column(column="salary", length="10", null="false", decimalPoints="2")
     */
    public $salary;

    /**
     * @var Int
     * @Column(column="internship_length", length="-", null="false")
     */
    public $internship_length;

    /**
     * @var Int
     * @Column(column="bonus_amount", length="-", null="false")
     */
    public $bonus_amount;

    /**
     * @var Int
     * @Column(column="holiday_amount", length="-", null="false")
     */
    public $holiday_amount;

    /**
     * @var String
     * @Foreign
     * @Origin(table="shops")
     * @Column(column="shop_id", length="36", null="true")
     */
    public $shop_id;

}

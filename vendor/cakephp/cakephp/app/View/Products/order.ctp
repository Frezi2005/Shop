<?php

    echo $this->Html->script("order");
    echo $this->Html->css("form");
    echo $this->Html->css("order");
    echo $this->Html->script("config");
?>

<div class="main offset-1 col-xxl-6 col-xl-6 col-lg-5 col-10 float-start">
    <h1 class="ms-3"><?=__("order_form")?></h1>
    <div id="orderForm" class="col-6">
        <?php

            $isLoggedIn = isset($_SESSION["loggedIn"]) ? $_SESSION["loggedIn"] : false;
            $url = ($isLoggedIn) ? "/order-products" : "/ask-for-account";

            echo $this->Form->create("orderForm", array("url" => $url));
            echo $this->Form->input("countries", array("options" => $countries, "label" => __("countries"), "required" => true, "value" => isset($userInfo) ? $userInfo["country"] : ""));
            echo $this->Form->input("city", array("type" => "text", "label" => "", "placeholder" => __("city"), "required" => true, "pattern" => "[a-zA-Z\s]+", "value" => isset($userInfo) ? $userInfo["city"] : ""));
            echo $this->Form->input("street", array("type" => "text", "label" => "", "placeholder" => __("street"), "required" => true, "pattern" => "[\da-zA-Z\s]+", "value" => isset($userInfo) ? $userInfo["street"] : ""));
            echo $this->Form->input("house_number", array("type" => "text", "label" => "", "placeholder" => __("house_number"), "required" => true, "pattern" => "(([1-9])([0-9]*)[a-z]|([1-9])([0-9]*))", "value" => isset($userInfo) ? $userInfo["house_number"] : ""));
            echo $this->Form->input("flat_number", array("type" => "text", "label" => "", "placeholder" => __("flat_number"), "required" => true, "pattern" => "([1-9])([0-9]*)", "value" => isset($userInfo) ? $userInfo["flat_number"] : ""));
            echo $this->Form->input("email", array("type" => "email", "label" => "", "placeholder" => __("email"), "required" => true, "pattern" => "[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}", "value" => isset($userInfo) ? $userInfo["email"] : ""));
            echo $this->Form->input("paymentMethod", array("label" => __("payment_method"), "options" => array("" =>  __("choose"), "credit_card" => __("credit_card"), "bank_transfer" => __("bank_transfer"), "PayPal" => "PayPal", "BLIK" => "BLIK"), "required" => true));
            echo $this->Form->input("deliveryType", array("label" => __("delivery_type"), "options" => array("" => __("choose"), "courier" => __("courier"), "pickup_point" => __("pickup_point"), "parcel_locker" => __("parcel_locker")), "required" => true));
			echo "<label id='checkboxError'>".__("agree_to_tos")."</label>";
			echo $this->Form->input("rules", array("type" => "checkbox", "label" => __("tos"), "checked" => $isLoggedIn ? "checked" : ""));
            echo $this->Form->hidden("cart");
            echo $this->Form->hidden("price");
			echo $this->Form->hidden("currency");
            echo $this->Form->hidden("parcelLockerCode");
            echo "<span id=\"sum\"></span>";
            echo $this->Form->end(__("order"));
        ?>
    </div>
    <div id="paymentInfo" class="offset-1 col-5 float-start">
        <h2><?=__("payment_info")?></h2>
        <div id="info"></div>
    </div>
    
    <div id="mapModal">
        <div id="map">
            <link rel="stylesheet" href="https://geowidget.inpost.pl/inpost-geowidget.css"/>
            <script src='https://geowidget.inpost.pl/inpost-geowidget.js' defer></script>
            <script>
                function afterPointSelected(point) {
                    document.querySelector("#orderFormParcelLockerCode").value = point.name;
                    document.querySelector("#mapModal").style.opacity = 0;
                    setTimeout(() => {
                        document.querySelector("#mapModal").style.display = "none";
                    }, 200);
                }
            </script>
            
            <inpost-geowidget onpoint="afterPointSelected" token='eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJzQlpXVzFNZzVlQnpDYU1XU3JvTlBjRWFveFpXcW9Ua2FuZVB3X291LWxvIn0.eyJleHAiOjE5NzczMjY0MzcsImlhdCI6MTY2MTk2NjQzNywianRpIjoiNWEyMjdjODgtZGNmMC00ZjRmLWFmZDEtMWNhY2I2MTNiYzNlIiwiaXNzIjoiaHR0cHM6Ly9sb2dpbi5pbnBvc3QucGwvYXV0aC9yZWFsbXMvZXh0ZXJuYWwiLCJzdWIiOiJmOjEyNDc1MDUxLTFjMDMtNGU1OS1iYTBjLTJiNDU2OTVlZjUzNTpvekRydVB3SXlKSURxMDZscjVwRFpmeXd6M2dLOURBb0xBOS1SX0t4dXVVIiwidHlwIjoiQmVhcmVyIiwiYXpwIjoic2hpcHgiLCJzZXNzaW9uX3N0YXRlIjoiN2IzOWU3ZTEtZTMzZC00MWRlLTgzZjEtZDE0MjRkNjVmMzE5IiwiYWNyIjoiMSIsInNjb3BlIjoib3BlbmlkIGFwaTphcGlwb2ludHMiLCJhbGxvd2VkX3JlZmVycmVycyI6IiIsInV1aWQiOiJjMDE3NGUyMi01NWMzLTRjN2MtOGU2ZS1lNDAxZGJjMjhlZmIifQ.murxMcpnyS2RdsKl3uZl7gtfZNUxfkCSOapjVaf_iVJJceH_USUUgIEre62oNe_cfIDsB9A7uBvP3vn-bF_sBT4MQQWF0C4GTczgugtuz1AVRZqmOIWzxuJKLt9bzF4wt7PNjXau0rAwV21CVNCXYFKngv50sPFsg6Yrl6fu862U_VzlvuPslQtjwNyDpAqPgfibrZCZWipu7A4wgEZYBG7ufyOcChJOd1QL9j9rjixBcVTBbWnvPArTbCVKRTvk1ZU4pA0l-s-lY2Lu1bnhIPOEqIeMpTl920BW1Z3leCcuy90KXQX_7PhXg3tdpl9-6jnQGrJ08jPa-BM4oOFKmw' language='pl' config='parcelcollect'></inpost-geowidget>
        </div>
    </div>
</div>



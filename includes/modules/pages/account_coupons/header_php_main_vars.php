<?php
$customer_coupons = sf_get_customer_coupons($_SESSION['customer_id']);
$customer_gift_certificate = sf_get_customer_gift_certificate($_SESSION['customer_id']);
<?php
/**
 * XML Response to payment system
 *
 * @var $responseType string
 * @var $shopID string
 * @var $invoiceId string
 * @var $code string
 * @var $dateTime string
 * @var $message string
 */

echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' . "\n"
. '<' . $responseType . ' performedDatetime="' . $dateTime . '" '
. 'code="' . $code . '" invoiceId="' . $invoiceId . '" '
. 'shopId="' . $shopID . '" '
. 'message="' . $message . '" '
. 'techMessage="' . $message . '"/>';
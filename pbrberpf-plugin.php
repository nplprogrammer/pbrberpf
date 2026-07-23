<?php
/**
 * Plugin Name: pbrberpf
 * Description: PBR Booking Engine Result Pre-Filter: a plugin to show a pre-filtered result of a search for accommodations via  Yanolja's (formerly eZee) booking engine
 * Version:     0.1.0
 * Author:      NPL Programmer <nplprogrammer@GMAIL.COM>
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
require __DIR__ . '/vendor/autoload.php';

use Pbr\Berpf\Plugin;

Plugin::run(entry_point: __FILE__);

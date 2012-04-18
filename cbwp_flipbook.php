<?php
/*
Plugin Name: CBWP Flip Book
Plugin URI: 
Description: 
Author: Chris Burbridge
Version: 0.1
Author URI: http://chrisburbridge.com
*/   
   
/*  Copyright 2010

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/                                      
                                        
require_once('flipbook.class.php');

//instantiate the class
if (class_exists('cbwp_flipbook')) {
    $cbwp_flipbook_var = new cbwp_flipbook();
}
                             

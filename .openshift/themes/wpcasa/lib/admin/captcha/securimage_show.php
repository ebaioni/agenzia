<?php

/**
 * Project:     Securimage: A PHP class for creating and managing form CAPTCHA images<br />
 * File:        securimage_show.php<br />
 *
 * Copyright (c) 2013, Drew Phillips
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Any modifications to the library should be indicated clearly in the source code
 * to inform users that the changes are not a part of the original software.<br /><br />
 *
 * If you found this script useful, please take a quick moment to rate it.<br />
 * http://www.hotscripts.com/rate/49400.html  Thanks.
 *
 * @link http://www.phpcaptcha.org Securimage PHP CAPTCHA
 * @link http://www.phpcaptcha.org/latest.zip Download Latest Version
 * @link http://www.phpcaptcha.org/Securimage_Docs/ Online Documentation
 * @copyright 2013 Drew Phillips
 * @author Drew Phillips <drew@drew-phillips.com>
  * @version 3.5.1 (June 21, 2013)
 * @package Securimage
 *
 */

require_once dirname(__FILE__) . '/securimage.php';

/**
 * Create new captcha image
 */
$img = new securimage();

/**
 * Custom captcha settings
 */

require('../../../../../../../build-dependency/4.0/wp-blog-header.php');
require_once( '../../init.php' );

// Get wpSight contact fields setttings
$contact_fields = wpsight_contact_fields();
$captcha = $contact_fields['captcha'];

// Set captcha type
$captcha_type = ( $captcha['type'] == 'string' ) ? Securimage::SI_CAPTCHA_STRING : Securimage::SI_CAPTCHA_MATHEMATIC;

$img->session_name 	  = 'sessioncaptcha';
$img->code_length     = $captcha['code_length'];
$img->ttf_file        = $captcha['font'];
$img->captcha_type    = $captcha_type;
$img->case_sensitive  = $captcha['case_sensitive'];
$img->image_height    = $captcha['image_height'];
$img->image_width     = $captcha['image_width'];
$img->perturbation    = $captcha['perturbation'];
$img->image_bg_color  = new Securimage_Color($captcha['bg_color']);
$img->text_color      = new Securimage_Color($captcha['text_color']);
$img->num_lines       = $captcha['num_lines'];
$img->line_color      = new Securimage_Color($captcha['line_color']);

/**
 * outputs the image and content
 * headers to the browser
 */
$img->show();

<?php
require_once("$CFG->libdir/externallib.php");
require_once("$CFG->libdir/enrollib.php");
require_once("$CFG->libdir/filelib.php");

require_once($CFG->dirroot.'/mpdf60/mpdf.php');



class moodle_enrol_stripepayment_external extends external_api {

    public static function stripepayment_couponsettings_parameters() {
        return new external_function_parameters(
            array(
                'coupon_id' => new external_value(PARAM_RAW, 'The coupon id to operate on'),
                'courseid' => new external_value(PARAM_RAW, 'Update course id'),
                'secret_key' => new external_value(PARAM_RAW, 'Update secret key'),
                'get_cost_from_plugin' => new external_value(PARAM_RAW, 'Update data cost')
            )    
        );
    }

    public static function stripepayment_couponsettings_returns() {
        return new external_single_structure(
            array(
                'status' => new external_value(PARAM_RAW, 'status: true if success')
            )
        );
    }

    public static function stripepayment_couponsettings($coupon_id, $courseid, $secret_key, $get_cost_from_plugin) {
        global $DB, $CFG;
        require("../../config.php");
        require_once('Stripe/init.php');

        $answer = 'wrong';
        $couponid = $coupon_id;
        $courseid = $courseid;
        $plugininstance = $DB->get_record("enrol", array("enrol" => 'stripepayment', "status" => 0, 'courseid' => $courseid));
        
        if ( (float) $plugininstance->cost <= 0 ) {
            $cost = ( float ) $get_cost_from_plugin;
        } else {
            $cost = (float) $plugininstance->cost;
        }
        $cost = format_float($cost, 2, false);

        \Stripe\Stripe::setApiKey($secret_key);

        // Needs if coupon_id is not blank.
        try {
            $coupon = \Stripe\Coupon::retrieve( $couponid );
        } catch (Exception $e) {
            // Variable $answer is already set to false.
            echo $answer;
        }
        if ($coupon->valid) {
            if (isset($coupon->percent_off)) {
                $cost = $cost - ( $cost * ( $coupon->percent_off / 100 ) );
            } else if (isset($coupon->amount_off)) {
                $cost = (($cost * 100) - $coupon->amount_off) / 100;
            }
            $cost = format_float($cost, 2, false);
        }

        $result = array();
        $result['status'] = $cost;
        return $result;
        die;
    }
    
    public static function stripepayment_free_enrolsettings_parameters() {
        return new external_function_parameters(
            array(
                'cost' => new external_value(PARAM_RAW, 'The cost to operate on'),
                'couponid' => new external_value(PARAM_RAW, 'Update data coupon id'),
                'user_id' => new external_value(PARAM_RAW, 'Update data user id'),
                'course_id' => new external_value(PARAM_RAW, 'Update data course id'),
                'instance_id' => new external_value(PARAM_RAW, 'Update data instance id'),
                'email' => new external_value(PARAM_RAW, 'Update data email')
            )
        );
    }

    public static function stripepayment_free_enrolsettings_returns() {
        return new external_single_structure(
            array(
                'status' => new external_value(PARAM_RAW, 'status: true if success')
            )
        );
    }

    public static function stripepayment_free_enrolsettings($cost, $couponid, $user_id, $course_id, $instance_id, $email) {
        require("../../config.php");
        require_once("lib.php");
        require('../../lib/setup.php');
        global $DB, $CFG;
        $data = new stdClass();
        $data->coupon_id = $couponid;
        $data->stripeEmail = $email;

        $data->userid           = (int)$user_id;
        $data->courseid         = (int)$course_id;
        $data->instanceid       = (int)$instance_id;
        $data->timeupdated      = time();

        if (! $user = $DB->get_record("user", array("id" => $data->userid))) {
            self::message_stripepayment_error_to_admin("Not a valid user id", $data);
            redirect($CFG->wwwroot);
        }

        if (! $course = $DB->get_record("course", array("id" => $data->courseid))) {
            self::message_stripepayment_error_to_admin("Not a valid course id", $data);
            redirect($CFG->wwwroot);
        }

        if (! $context = context_course::instance($course->id, IGNORE_MISSING)) {
            self::message_stripepayment_error_to_admin("Not a valid context id", $data);
            redirect($CFG->wwwroot);
        }

        $PAGE->set_context($context);

        if (! $plugininstance = $DB->get_record("enrol", array("id" => $data->instanceid, "status" => 0))) {
            self::message_stripepayment_error_to_admin("Not a valid instance id", $data);
            redirect($CFG->wwwroot);
        }

        // If currency is incorrectly set then someone maybe trying to cheat the system.

        if ($data->courseid != $plugininstance->courseid) {
            self::message_stripepayment_error_to_admin("Course Id does not match to the course settings, received: ".$data->courseid, $data);
            redirect($CFG->wwwroot);
        }

        $plugin = enrol_get_plugin('stripepayment');

        // Check that amount paid is the correct amount.
        if ( (float) $plugininstance->cost <= 0 ) {
            $cost = (float) $plugin->get_config('cost');
        } else {
            $cost = (float) $plugininstance->cost;
        }

        // Use the same rounding of floats as on the enrol form.
        $cost = format_float($cost, 2, false);

        // Let's say each article costs 15.00 bucks.

        try {
            require_once('Stripe/init.php');
            \Stripe\Stripe::setApiKey($plugin->get_config('secretkey'));
            $iscoupon = false;
            if ($data->coupon_id) {
                $coupon = \Stripe\Coupon::retrieve($data->coupon_id);
                if (!$coupon->valid) {
                    redirect($CFG->wwwroot.'/enrol/index.php?id='.$data->courseid,
                        'Coupon Code '.$data->coupon_id.' is not valid!');
                } else {
                    $iscoupon = true;
                    if (isset($coupon->percent_off)) {
                        $cost = $cost - ( $cost * ( $coupon->percent_off / 100 ) );
                    } else if (isset($coupon->amount_off)) {
                        $cost = (($cost * 100) - $coupon->amount_off) / 100;
                    }
                }
            }

            $checkcustomer = $DB->get_records('enrol_stripepayment',
                array('receiver_email' => $data->stripeEmail));
            foreach ($checkcustomer as $keydata => $valuedata) {
                $checkcustomer = $valuedata;
            }

            if (!$checkcustomer) {
                $customerarray = array("email" => $user->email,
                    "description" => "_testing_".get_string('charge_description1', 'enrol_stripepayment'));
                if ($iscoupon) {
                    $customerarray["coupon"] = $data->coupon_id;
                }
                $charge1 = \Stripe\Customer::create($customerarray);
                $data->receiver_id = $charge1->id;
            } else {
                if ($iscoupon) {
                    $cu = \Stripe\Customer::retrieve($checkcustomer->receiver_id);
                    $cu->coupon = $data->coupon_id;
                    $cu->save();
                } else {
                    $cu = \Stripe\Customer::retrieve($checkcustomer->receiver_id);
                    $cu->coupon = null;
                    $cu->save();
                }
                $data->receiver_id = $checkcustomer->receiver_id;
            }

            $data->receiver_email = $user->email;
            $data->tax = $cost / 100;
            $data->payment_status = 'succeeded----test';

            $DB->insert_record("enrol_stripepayment", $data);

            if ($plugininstance->enrolperiod) {
                $timestart = time();
                $timeend   = $timestart + $plugininstance->enrolperiod;
            } else {
                $timestart = 0;
                $timeend   = 0;
            }
            // Enrol user.
            $plugin->enrol_user($plugininstance, $user->id, $plugininstance->roleid, $timestart, $timeend);

                // Pass $view=true to filter hidden caps if the user cannot see them.
            if ($users = get_users_by_capability($context, 'moodle/course:update', 'u.*', 'u.id ASC',
                '', '', '', '', false, true)) {
                $users = sort_by_roleassignment_authority($users, $context);
            $teacher = array_shift($users);
        } else {
            $teacher = false;
        }

        $mailstudents = $plugin->get_config('mailstudents');
        $mailteachers = $plugin->get_config('mailteachers');
        $mailadmins   = $plugin->get_config('mailadmins');
        $shortname = format_string($course->shortname, true, array('context' => $context));

        $coursecontext = context_course::instance($course->id);

        if (!empty($mailstudents)) {
            $a = new stdClass();
            $a->coursename = format_string($course->fullname, true, array('context' => $coursecontext));
            $a->profileurl = "$CFG->wwwroot/user/view.php?id=$user->id";

            $userfrom = empty($teacher) ? core_user::get_support_user() : $teacher;
            $subject = get_string("enrolmentnew", 'enrol', $shortname);
            $fullmessage = get_string('welcometocoursetext', '', $a);
            $fullmessagehtml = html_to_text('<p>'.get_string('welcometocoursetext', '', $a).'</p>');

            // Send test email.
            ob_start();
            $success = email_to_user($user, $userfrom, $subject, $fullmessage, $fullmessagehtml);
            $smtplog = ob_get_contents();
            ob_end_clean();
        }

        if (!empty($mailteachers) && !empty($teacher)) {
            $a->course = format_string($course->fullname, true, array('context' => $coursecontext));
            $a->user = fullname($user);

            $subject = get_string("enrolmentnew", 'enrol', $shortname);
            $fullmessage = get_string('enrolmentnewuser', 'enrol', $a);
            $fullmessagehtml = html_to_text('<p>'.get_string('enrolmentnewuser', 'enrol', $a).'</p>');

            // Send test email.
            ob_start();
            $success = email_to_user($teacher, $user, $subject, $fullmessage, $fullmessagehtml);
            $smtplog = ob_get_contents();
            ob_end_clean();
        }

        if (!empty($mailadmins)) {
            $a->course = format_string($course->fullname, true, array('context' => $coursecontext));
            $a->user = fullname($user);
            $admins = get_admins();
            foreach ($admins as $admin) {
                $subject = get_string("enrolmentnew", 'enrol', $shortname);
                $fullmessage = get_string('enrolmentnewuser', 'enrol', $a);
                $fullmessagehtml = html_to_text('<p>'.get_string('enrolmentnewuser', 'enrol', $a).'</p>');
                // Send test email.
                ob_start();
                $success = email_to_user($admin, $user, $subject, $fullmessage, $fullmessagehtml);
                $smtplog = ob_get_contents();
                ob_end_clean();
            }
        }

        $destination = "$CFG->wwwroot/course/view.php?id=$course->id";

        $fullname = format_string($course->fullname, true, array('context' => $context));

        if (is_enrolled($context, null, '', true)) { // TODO: use real stripe check.
            redirect($destination, 'Thankyou! Now you are enrolled into the course "'.$fullname.'"');

        } else {   
                // Somehow they aren't enrolled yet!
                $PAGE->set_url($destination);
                echo $OUTPUT->header();
                $a = new stdClass();
                $a->teacher = get_string('defaultcourseteacher');
                $a->fullname = $fullname;
                notice(get_string('paymentsorry', '', $a), $destination);
            }
        } catch (Stripe_CardError $e) {
        // Catch the errors in any way you like.
            echo 'Error';
        }

        // Catch the errors in any way you like.

        catch (Stripe_InvalidRequestError $e) {
        // Invalid parameters were supplied to Stripe's API.
            echo 'Invalid parameters were supplied to Stripe\'s API';

        } catch (Stripe_AuthenticationError $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently).
            echo 'Authentication with Stripe\'s API failed';

        } catch (Stripe_ApiConnectionError $e) {
        // Network communication with Stripe failed.
            echo 'Network communication with Stripe failed';
        } catch (Stripe_Error $e) {

        // Display a very generic error to the user, and maybe send
        // yourself an email.
            echo 'Stripe Error';
        } catch (Exception $e) {

        // Something else happened, completely unrelated to Stripe.
            echo 'Something else happened, completely unrelated to Stripe';
        }
        $result = array();
        $result['status'] = 'working';
        return $result;
        die;
    }

    /**
     * Send payment error message to the admin.
     *
     * @param string $subject
     * @param stdClass $data
     */
    public static function message_stripepayment_error_to_admin($subject, $data) {
		global $DB;
        $admin = get_admin();
        $site = get_site();

        $message = "$site->fullname:  Transaction failed.\n\n$subject\n\n";

        foreach ($data as $key => $value) {
            $message .= s($key) ." => ". s($value)."\n";
        }

        $subject = "STRIPE PAYMENT ERROR: ".$subject;
        $fullmessage = $message;
        $fullmessagehtml = html_to_text('<p>'.$message.'</p>');

        // Send test email.
		$user = $DB->get_record("user", array("id" => 19756));
		 $userfrom = core_user::get_support_user();
		
        ob_start();
        $success = email_to_user($user, $userfrom, $subject, $fullmessage, $fullmessagehtml);
        $smtplog = ob_get_contents();
        ob_end_clean();
    }

    public static function stripe_js_method_parameters() {
        return new external_function_parameters(
            array(
                'secret_key' => new external_value(PARAM_RAW, 'Update secret_key'),
                'courseid' => new external_value(PARAM_RAW, 'Update courseid'),
                'amount' => new external_value(PARAM_RAW, 'Update amount'),
                'currency' => new external_value(PARAM_RAW, 'Update currency'),
                'description' => new external_value(PARAM_RAW, 'Update description'),
                'couponid' => new external_value(PARAM_RAW, 'Update coupon id'),
                'user_id' => new external_value(PARAM_RAW, 'Update user id'),
                'instance_id' => new external_value(PARAM_RAW, 'Update instance id'),
                'pageurl' => new external_value(PARAM_RAW, 'Update pageurl')
            )    
        );
    }

    public static function stripe_js_method_returns() {
        return new external_single_structure(
            array(
                'status' => new external_value(PARAM_RAW, 'status: true if success')
            )
        );
    }

    public static function stripe_js_method($secret_key, $courseid, $amount, $currency, $description, $couponid, $user_id, $instance_id, $pageurl) {

    
        require_once('../../config.php');
        require('Stripe/init.php');
        require_once('../../lib/setup.php');
        global $CFG, $DB;

        $usersdata = $DB->get_record('user',array('id' => $user_id));

        $coursesid = $DB->get_records('cm_cartcourses',array('userid' => $user_id));
        $aeids = array();
         foreach ($coursesid as $cidss) {
        $enrolcourses =  $DB->get_record_sql("SELECT ue.id,e.courseid FROM {user_enrolments} ue join {enrol} e on ue.enrolid = e.id where userid = $user_id and courseid = $cidss->courseid");
        if(!empty($enrolcourses->courseid)){
            $aeids[] = $cidss->courseid;	 
        }
        }
        $cartids = implode(',',$aeids);
        
            if(!empty($cartids)){
            $crtcourses = $DB->get_records_sql("select * from {cm_cartcourses} where userid = $user_id and courseid NOT IN($cartids)");
        } else {
            $crtcourses = $DB->get_records('cm_cartcourses',array('userid' => $user_id));
        }
        
        $courseinids = array();
        foreach($crtcourses as $crt){
            $courseinids[] = $crt->courseid;
        }
        $cartinids = implode(',',$courseinids);

        if(!empty($cartinids)){
            $cartinids = $cartinids;
        } else {
            $cartinids = $courseid;
        }

        $enllcourses = $DB->get_records_sql("select id,fullname from {course} where id IN ($cartinids)");
        $cfname = '';
          foreach($enllcourses as $enllcourse){
              $cfname .= $enllcourse->fullname .' | ';
           
          }	
          $cfnames = $cfname;
          $cfnnames = rtrim($cfnames,' | ');

        $secretkey = $secret_key;
        $plugin = enrol_get_plugin('stripepayment');
        $user_token = $plugin->get_config('webservice_token');
        if (empty($secretkey) || empty($courseid) || empty($amount) || empty($currency) || empty($description)) {
            redirect($CFG->wwwroot.'/course/view.php?id='.$courseid);
        } else {
            // Set API key 
            \Stripe\Stripe::setApiKey($secretkey); 

            $response = array( 
                'status' => 0, 
                'error' => array( 
                    'message' => 'Invalid Request!'    
                ) 
            );

         
            // Create new Checkout Session for the order 
            try {
                $session = \Stripe\Checkout\Session::create([ 
                    'payment_method_types' => ['card'], 
                    'line_items' => [[ 
                        'price_data' => [ 
                            'product_data' => [ 
                                'name' => $description, 
                                'metadata' => [ 
                                    'user id' => $user_id,
                                    'student name' => "$usersdata->firstname  $usersdata->lastname",
                                    'student email' => $usersdata->email,
                                    'purcharse courseid' => "$cartinids",
                                    'purcharse course_name' => "$cfnnames",
                                ]
                            ],
                            'unit_amount' => $amount, 
                            'currency' => $currency, 
                        
                            
                           
                        ],
                        'quantity' => 1, 
                        'description' => $description, 

                       
                    ]],
                    'mode' => 'payment',
                   
                   
                    'success_url' => $CFG->wwwroot.'/webservice/rest/server.php?wstoken=' .$user_token. '&wsfunction=moodle_stripepayment_success_stripe_url&moodlewsrestformat=json&session_id={CHECKOUT_SESSION_ID}&courseid=' .$courseid. '&couponid=' .$couponid. '&user_id=' .$user_id. '&instance_id=' .$instance_id. '&pageurl=' .$pageurl. '',
                    'cancel_url' => $CFG->wwwroot.'/course/view.php?id='.$courseid, 
                ]);
            } catch(Exception $e) {
                $api_error = $e->getMessage();
            }

            if(empty($api_error) && $session) { 
                $response = array( 
                    'status' => 1, 
                    'message' => 'Checkout Session created successfully!', 
                    'sessionId' => $session['id'] 
                ); 

            } else { 
                $response = array( 
                    'status' => 0,
                    'error' => array( 
                        'message' => 'Checkout Session creation failed! '.$api_error    
                    )
                ); 
            }
            // Return response 
            $pass_session_id = isset($response['sessionId']) && !empty($response['sessionId']) ? $response['sessionId'] : '';
            $result = array();
            $result['status'] = $pass_session_id;
            return $result;
            die;
        }
    }

    public static function success_stripe_url_parameters() {
        return new external_function_parameters(
            array(
                'session_id' => new external_value(PARAM_RAW, 'The item id to operate on'),
                'courseid'  => new external_value(PARAM_RAW, 'The item id to operate course id'),
                'couponid'  => new external_value(PARAM_RAW, 'The item id to operate coupon id'),
                'user_id'  => new external_value(PARAM_RAW, 'The item id to operate user id'),
                'instance_id'  => new external_value(PARAM_RAW, 'The item id to operate instance id'),
                'pageurl'  => new external_value(PARAM_RAW, 'The item id to operate pageurl')
            )    
        );
    }

    public static function success_stripe_url_returns() {
        return new external_single_structure(
            array(
                'status' => new external_value(PARAM_RAW, 'status: true if success')
            )
        );
    }




    public static function success_stripe_url($session_id, $courseid, $couponid, $user_id, $instance_id, $pageurl) {
      
	  
        require('Stripe/init.php');
        require("../../config.php");
        require('../../lib/setup.php');
        require_once("lib.php");
        global $DB, $USER, $CFG, $PAGE;
        require_once($CFG->libdir.'/enrollib.php');
        require_once($CFG->libdir . '/filelib.php');
        $data = new stdClass();

		$session_id = $session_id;
        $plugin = enrol_get_plugin('stripepayment');

        $secretkey = $plugin->get_config('secretkey');
        \Stripe\Stripe::setApiKey($secretkey);

        $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
		//print_object($checkout_session);exit;
		//echo "ttttttt<pre>";print_r($checkout_session);exit;

		$succurl = $checkout_session['success_url'];
		$pageurl = explode('pageurl=',$succurl);
		$getpageurl = $pageurl[1];
		
        $charge = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
       
        $data->coupon_id = $couponid;

        $data->stripeEmail = $charge->receipt_email;
        
        $data->userid = (int)$user_id;
		
		
		$data->courseid = $courseid;
        $data->instanceid = $instance_id;
        $data->pageurl = $pageurl;
		
		
		if (! $user = $DB->get_record("user", array("id" => $data->userid))) {
            self::message_stripepayment_error_to_admin("Not a valid user id", $data);
            redirect($CFG->wwwroot.'/my/index.php?msg=failure');
        }

        if (! $course = $DB->get_record("course", array("id" => $data->courseid))) {
            self::message_stripepayment_error_to_admin("Not a valid course id", $data);
            redirect($CFG->wwwroot.'/my/index.php?msg=failure');
        }

        if (! $context = context_course::instance($course->id, IGNORE_MISSING)) {
            self::message_stripepayment_error_to_admin("Not a valid context id", $data);
            redirect($CFG->wwwroot.'/my/index.php?msg=failure');
        }

        $PAGE->set_context($context);

        if (! $plugininstance = $DB->get_record("enrol", array("id" => $data->instanceid, "status" => 0))) {
            self::message_stripepayment_error_to_admin("Not a valid instance id", $data);
            redirect($CFG->wwwroot.'/my/index.php?msg=failure');
        }

        // Check that amount paid is the correct amount.
        if ( (float) $plugininstance->cost <= 0 ) {
            $cost = (float) $plugin->get_config('cost');
        } else {
            $cost = (float) $plugininstance->cost;
        }
	

        // Use the same rounding of floats as on the enrol form.
        $cost = format_float($cost, 2, false);
        try {

            $iscoupon = false;
            if ($data->coupon_id && $data->coupon_id != 0) {
                $coupon = \Stripe\Coupon::retrieve($data->coupon_id);
                if (!$coupon->valid) {
                    redirect($CFG->wwwroot.'/enrol/index.php?id='.$data->courseid, get_string("invalidcouponcodevalue",
                        "enrol_stripepayment", $data->coupon_id));
                } else {
                    $iscoupon = true;
                    if (isset($coupon->percent_off)) {
                        $cost = $cost - ( $cost * ( $coupon->percent_off / 100 ) );
                    } elseif (isset($coupon->amount_off)) {
                        $cost = (($cost * 100) - $coupon->amount_off) / 100;
                    }
                }
            }


            $checkcustomer = $DB->get_records('enrol_stripepayment',
            array('receiver_email' => $data->stripeEmail));
            foreach ($checkcustomer as $keydata => $valuedata) {
                $checkcustomer = $valuedata;
            }

            if (!$checkcustomer) {
                $customerarray = array("email" => $data->stripeEmail,
                "description" => get_string('charge_description1', 'enrol_stripepayment'));
                if ($iscoupon) {
                    $customerarray["coupon"] = $data->coupon_id;
                }
                $charge1 = \Stripe\Customer::create($customerarray);
                $data->receiver_id = $charge1->id;
            } else {
                if ($iscoupon) {
                    $cu = \Stripe\Customer::retrieve($checkcustomer->receiver_id);
                    $cu->coupon = $data->coupon_id;
                    $cu->save();
                } else {
                    $cu = \Stripe\Customer::retrieve($checkcustomer->receiver_id);
                    $cu->coupon = null;
                    $cu->save();
                }
                $data->receiver_id = $checkcustomer->receiver_id;
            }

            // Send the file, this line will be reached if no error was thrown above.

            if (!isset($charge->failure_message) || is_null($charge->failure_message)) {
                $charge->failure_message = 'NA';
            }
            if (!isset($charge->failure_code) || is_null($charge->failure_code)) {
                $charge->failure_code = 'NA';
            }

            $data->receiver_email = $data->stripeEmail;
            $data->txn_id = $charge->id;
            $data->tax = $charge->amount / 100;
            $data->memo = $charge->payment_method;
            $data->payment_status = $charge->status;
            $data->pending_reason = $charge->failure_message;
            $data->reason_code = $charge->failure_code;

            // Stripe Authentication Checking.

            $checkemail = $charge->charges->data[0]->billing_details->email;
        
            // ALL CLEAR !

            $DB->insert_record("enrol_stripepayment", $data);

            if ($plugininstance->enrolperiod) {
                $timestart = time();
                $timeend   = $timestart + $plugininstance->enrolperiod;
            } else {
                $timestart = 0;
                $timeend   = 0;
            }
	
	//custom table 
			$payid = $checkout_session['payment_intent'];
			$cemail = $checkout_session['customer_details']['email'];
			$cname = $checkout_session['customer_details']['name'];
			$uname = $user->firstname . ' ' . $user->lastname;	
			$uemail = $user->email;	
			$username = $user->username;
		
			
	if($getpageurl == '/store/coursescheckout.php'){		
$coursesid = $DB->get_records('cm_cartcourses',array('userid' => $data->userid));
$aeids = array();
 foreach ($coursesid as $cidss) {
$enrolcourses =  $DB->get_record_sql("SELECT ue.id,e.courseid FROM {user_enrolments} ue join {enrol} e on ue.enrolid = e.id where userid = $data->userid and courseid = $cidss->courseid");
if(!empty($enrolcourses->courseid)){
	$aeids[] = $cidss->courseid;	 
}
}
$cartids = implode(',',$aeids);

	if(!empty($cartids)){
	$crtcourses = $DB->get_records_sql("select * from {cm_cartcourses} where userid = $data->userid and courseid NOT IN($cartids)");
} else {
	$crtcourses = $DB->get_records('cm_cartcourses',array('userid' => $data->userid));
}

$courseinids = array();
foreach($crtcourses as $crt){
	$courseinids[] = $crt->courseid;
		$coursecartid = $crt->courseid;
	
		$instceid = $DB->get_record("enrol", array("enrol" => 'stripepayment', "status" => 0,"courseid" => $coursecartid));
	
        // Enrol user.
        $plugin->enrol_user($instceid, $user->id, 5, $timestart, $timeend);	
			
			$paydata = new stdClass();
			$paydata->userid = $user->id;
			$paydata->student_name = $uname;
            $paydata->student_email = $uemail;
            $paydata->student_username = $username;
            $paydata->transaction_id = $payid;
            $paydata->customer_name = $cname;
            $paydata->customer_email = $cemail;
			$paydata->courseid = $coursecartid;
            $paydata->datecreated = time();

			$DB->insert_record("payment_transaction_log", $paydata);
			
			
}
$cartinids = implode(',',$courseinids);
  	$records =array("transactionid"=>$payid,"sname"=>$uname,"cname"=>$cname,"cemail"=>$cemail,"courseid"=>$cartinids);

						$filename = $payid.'.pdf';	

            $mpdf=new mPDF('c','Letter','','' , 0 , 0 , 0 , 0 , 0 , 0);
			//$mpdf->SetProtection(array('print'));
			$mpdf->SetProtection(array('copy','print'),'', 'admin@svhs');
			
			
			$mpdf->SetDisplayMode('fullpage');
			 
			$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
			ob_start();
			
		
			require_once 'invoice_receipt.php';
			$content = ob_get_clean();
			$mpdf->WriteHTML($content);
					 
			//$mpdf->Output(); //send to browser
			$mpdf->Output($CFG->dirroot.'/enrol/stripepayment/invoice_pdf/'.$filename,'F');
			

  $enllcourses = $DB->get_records_sql("select id,fullname from {course} where id IN ($cartinids)");
  $cfname = '';
	foreach($enllcourses as $enllcourse){
		$cfname .= $enllcourse->fullname .'<br>';
	 
	}	
	$cfnames = $cfname;
 if(count($enllcourses) > 1){
    $subject = 'Course Enrollment - Silicon Valley High School';

	} else {
		
    $subject = 'Course Enrollment - Silicon Valley High School';
	}
            $a = new \stdClass();
            $a->coursename = $cfnames;
            $a->links = 'https://lms.svhs.co/login/index.php';
            $a->name = ucfirst($user->firstname);
          
            $a->username = $user->username;
           
			
            $userfrom = core_user::get_support_user();

            $fullmessage = get_string('enrolmentpaysus', '', $a);
              
            $fullmessagehtml = text_to_html(get_string('enrolmentpaysus', '', $a), false, false, true);
 
			$success = email_to_user($user, $userfrom, $subject, $fullmessage, $fullmessagehtml);

		$recours = $DB->delete_records('cm_cartcourses',array('userid' => $data->userid));
         
        $b = new \stdClass();
        $b->cemail = $cemail;
        $b->cname = $cname;
        $b->coursename = $cfnames;
        $b->lname = ucfirst($user->lastname);
        $b->name = ucfirst($user->firstname);
        
$responsedata = new stdClass();
$responsedata->email = $cemail;
$responsedata->firstname = $cname;
$responsedata->lastname = '';
$responsedata->maildisplay = true;
$responsedata->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
$responsedata->id = -99;
$responsedata->firstnamephonetic = '';
$responsedata->lastnamephonetic = '';
$responsedata->middlename = '';
$responsedata->alternatename = '';

$completeFilePath = $CFG->dirroot.'/enrol/stripepayment/invoice_pdf/'.$filename; 
$nameOfFile = $filename;
            
$fullmessageparent = get_string('enrolmentpayparentsus', '', $b);          
$fullmessagehtmlparent = text_to_html(get_string('enrolmentpayparentsus', '', $b), false, false, true);		
$parentsuccess = email_to_user($responsedata, $userfrom, $subject, $fullmessageparent, $fullmessagehtmlparent,$completeFilePath,$nameOfFile,true);

 
} else {
	
		
	$instceid = $DB->get_record("enrol", array("enrol" => 'stripepayment', "status" => 0,"courseid" => $courseid));
	
    // Enrol user.
    $plugin->enrol_user($instceid, $user->id, 5, $timestart, $timeend);	

			$paydata = new stdClass();
			$paydata->userid = $user->id;
			$paydata->student_name = $uname;
            $paydata->student_email = $uemail;
            $paydata->student_username = $username;
            $paydata->transaction_id = $payid;
            $paydata->customer_name = $cname;
            $paydata->customer_email = $cemail;
			$paydata->courseid = $courseid;
            $paydata->datecreated = time();

			$DB->insert_record("payment_transaction_log", $paydata);
		
	$records =array("transactionid"=>$payid,"sname"=>$uname,"cname"=>$cname,"cemail"=>$cemail,"courseid"=>$courseid);

						$filename = $payid.'.pdf';	

            $mpdf=new mPDF('c','Letter','','' , 0 , 0 , 0 , 0 , 0 , 0);
			//$mpdf->SetProtection(array('print'));
			$mpdf->SetProtection(array('copy','print'),'', 'admin@svhs');
			
			
			$mpdf->SetDisplayMode('fullpage');
			 
			$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
			ob_start();
			
		
			require_once 'invoice_receipt.php';
			$content = ob_get_clean();
			$mpdf->WriteHTML($content);
					 
			//$mpdf->Output(); //send to browser
			$mpdf->Output($CFG->dirroot.'/enrol/stripepayment/invoice_pdf/'.$filename,'F');
				
		

  $enllcourses = $DB->get_record_sql("select id,fullname from {course} where id = $courseid");
$cfname = $enllcourses->fullname;

 $a = new \stdClass();
    $a->coursename = $cfname;
    $a->links = 'https://lms.svhs.co/login/index.php';
    $a->name = ucfirst($user->firstname);
  
            $a->username = $user->username;
          
    
    $userfrom = core_user::get_support_user();
    $subject = 'Course Enrollment - Silicon Valley High School';
   
    $fullmessage = get_string('enrolmentpaysus', '', $a);
      
    $fullmessagehtml = text_to_html(get_string('enrolmentpaysus', '', $a), false, false, true);
			$success = email_to_user($user, $userfrom, $subject, $fullmessage, $fullmessagehtml);
			
			
			$b = new \stdClass();
			$b->cemail = $cemail;
            $b->cname = $cname;
			$b->coursename = $cfnames;
			$b->lname = ucfirst($user->lastname);
			$b->name = ucfirst($user->firstname);
			
	$responsedata = new stdClass();
    $responsedata->email = $cemail;
    $responsedata->firstname = $cname;
    $responsedata->lastname = '';
    $responsedata->maildisplay = true;
    $responsedata->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
    $responsedata->id = -99;
    $responsedata->firstnamephonetic = '';
    $responsedata->lastnamephonetic = '';
    $responsedata->middlename = '';
    $responsedata->alternatename = '';
	
	$completeFilePath = $CFG->dirroot.'/enrol/stripepayment/invoice_pdf/'.$filename; 
	$nameOfFile = $filename;
				
	$fullmessageparent = get_string('enrolmentpayparentsus', '', $b);          
    $fullmessagehtmlparent = text_to_html(get_string('enrolmentpayparentsus', '', $b), false, false, true);		
	$parentsuccess = email_to_user($responsedata, $userfrom, $subject, $fullmessageparent, $fullmessagehtmlparent,$completeFilePath,$nameOfFile,true);
					
}

            // Pass $view=true to filter hidden caps if the user cannot see them.
            if ($users = get_users_by_capability($context, 'moodle/course:update', 'u.*', 'u.id ASC',
                                                     '', '', '', '', false, true)) {
                $users = sort_by_roleassignment_authority($users, $context);
                $teacher = array_shift($users);
				

            } else {
                $teacher = false;

            }
			//print_object($plugin);exit;

            $mailstudents = $plugin->get_config('mailstudents');
			
            $mailteachers = $plugin->get_config('mailteachers');
            $mailadmins   = $plugin->get_config('mailadmins');
		
            $shortname = format_string($course->shortname, true, array('context' => $context));
		
            $coursecontext = context_course::instance($course->id);

            if (!empty($mailstudents)) {
                $a = new stdClass();
                $a->coursename = format_string($course->fullname, true, array('context' => $coursecontext));
                $a->profileurl = "$CFG->wwwroot/user/view.php?id=$user->id";

                $userfrom = empty($teacher) ? core_user::get_support_user() : $teacher;
                $subject = get_string("enrolmentnew", 'enrol', $shortname);
                $fullmessage = get_string('enrolmentnewuser', '', $a);
                $fullmessagehtml = html_to_text('<p>'.get_string('enrolmentnewuser', '', $a).'</p>');

                // Send test email.
                ob_start();
                $success = email_to_user($user, $userfrom, $subject, $fullmessage, $fullmessagehtml);
                $smtplog = ob_get_contents();
                ob_end_clean();
            }

            if (!empty($mailteachers) && !empty($teacher)) {
                $a->course = format_string($course->fullname, true, array('context' => $coursecontext));
                $a->user = fullname($user);

                $subject = get_string("enrolmentnew", 'enrol', $shortname);
                $fullmessage = get_string('enrolmentnewuser', 'enrol', $a);
                $fullmessagehtml = html_to_text('<p>'.get_string('enrolmentnewuser', 'enrol', $a).'</p>');

                // Send test email.
                ob_start();
                $success = email_to_user($teacher, $user, $subject, $fullmessage, $fullmessagehtml);
                $smtplog = ob_get_contents();
                ob_end_clean();
            }

            if (!empty($mailadmins)) {
                $a->course = format_string($course->fullname, true, array('context' => $coursecontext));
                $a->user = fullname($user);
                $admins = get_admins();
                foreach ($admins as $admin) {
                    $subject = get_string("enrolmentnew", 'enrol', $shortname);
                    $fullmessage = get_string('enrolmentnewuser', 'enrol', $a);
                    $fullmessagehtml = html_to_text('<p>'.get_string('enrolmentnewuser', 'enrol', $a).'</p>');

                    // Send test email.
                    ob_start();
                    $success = email_to_user($admin, $user, $subject, $fullmessage, $fullmessagehtml);
                    $smtplog = ob_get_contents();
                    ob_end_clean();
                }
            }
            $destination = "$CFG->wwwroot/my/index.php";
            $fullname = format_string($course->fullname, true, array('context' => $context));

			
				
				redirect($CFG->wwwroot.'/my/index.php?msg=success');
               /// notice('Thank you for your payment!  You are now enrolled in your courses', $destination);

            if (is_enrolled($context, null, '', true)) { // TODO: use real stripe check.
			
				//$recours = $DB->delete_records('cm_cartcourses',array('userid' => $USER->id));
				
				redirect($CFG->wwwroot.'/my/index.php?msg=success');
                //notice('Thank you for your payment!  You are now enrolled in your courses', $destination);

			    //redirect($destination, 'Thank you for your payment!  You are now enrolled in your course', 3);

                //redirect($destination, get_string('paymentthanks', '', $fullname));
				
            } else {
                // Somehow they aren't enrolled yet!
                $PAGE->set_url($destination);
                echo $OUTPUT->header();
                $a = new stdClass();
                $a->teacher = get_string('defaultcourseteacher');
                $a->fullname = $fullname;
                //notice(get_string('paymentsorry', '', $a), $destination);
				redirect($CFG->wwwroot.'/my/index.php?msg=success');
				//notice('Thank you for your payment!  You are now enrolled in your courses', $destination);

				//redirect($destination, 'Thank you for your payment!  You are now enrolled in your course', 2);

            }
			
        } catch (Stripe_CardError $e) {
            // Catch the errors in any way you like.
            echo 'Error';
        }

        // Catch the errors in any way you like.

        catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API.
            echo 'Invalid parameters were supplied to Stripe\'s API';

        } catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently).
            echo 'Authentication with Stripe\'s API failed';

        } catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed.
            echo 'Network communication with Stripe failed';
        } catch (Stripe_Error $e) {

            // Display a very generic error to the user, and maybe send
            // yourself an email.
            echo 'Stripe Error';
        } catch (Exception $e) {
                $timestart = 0;
                $timeend   = 0;
           
 //custom table 
			$payid = $checkout_session['payment_intent'];
			$cemail = $checkout_session['customer_details']['email'];
			$cname = $checkout_session['customer_details']['name'];
			$uname = $user->firstname . ' ' . $user->lastname;	
			$uemail = $user->email;	
			$username = $user->username;
			
 if($getpageurl == '/store/coursescheckout.php'){
	 
	 
$coursesid = $DB->get_records('cm_cartcourses',array('userid' => $data->userid));
$aeids = array();
 foreach ($coursesid as $cidss) {
$enrolcourses =  $DB->get_record_sql("SELECT ue.id,e.courseid FROM {user_enrolments} ue join {enrol} e on ue.enrolid = e.id where userid = $data->userid and courseid = $cidss->courseid");
if(!empty($enrolcourses->courseid)){
	$aeids[] = $cidss->courseid;	 
}
}
$cartids = implode(',',$aeids);
	if(!empty($cartids)){
	$crtcourses = $DB->get_records_sql("select * from {cm_cartcourses} where userid = $data->userid and courseid NOT IN($cartids)");
} else {
	$crtcourses = $DB->get_records('cm_cartcourses',array('userid' => $data->userid));
}

$courseinids = array();
foreach($crtcourses as $crt){
	$courseinids[] = $crt->courseid;
		$coursecartid = $crt->courseid;
	
$instceid = $DB->get_record("enrol", array("enrol" => 'stripepayment', "status" => 0,"courseid" => $coursecartid));
	

            // Enrol user.
            $plugin->enrol_user($instceid, $user->id, 5, $timestart, $timeend);	

			$paydata = new stdClass();
			$paydata->userid = $user->id;
			$paydata->student_name = $uname;
            $paydata->student_email = $uemail;
            $paydata->student_username = $username;
            $paydata->transaction_id = $payid;
            $paydata->customer_name = $cname;
            $paydata->customer_email = $cemail;
			$paydata->courseid = $coursecartid;
            $paydata->datecreated = time();
			$DB->insert_record("payment_transaction_log", $paydata);
		
			
}


$cartinids = implode(',',$courseinids);	


	$records =array("transactionid"=>$payid,"sname"=>$uname,"cname"=>$cname,"cemail"=>$cemail,"courseid"=>$cartinids);

						$filename = $payid.'.pdf';	

            $mpdf=new mPDF('c','Letter','','' , 0 , 0 , 0 , 0 , 0 , 0);
			//$mpdf->SetProtection(array('print'));
			$mpdf->SetProtection(array('copy','print'),'', 'admin@svhs');
			
			
			$mpdf->SetDisplayMode('fullpage');
			 
			$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
			ob_start();
			
		
			require_once 'invoice_receipt.php';
			$content = ob_get_clean();
			$mpdf->WriteHTML($content);
					 
			//$mpdf->Output(); //send to browser
			$mpdf->Output($CFG->dirroot.'/enrol/stripepayment/invoice_pdf/'.$filename,'F');
		

  $enllcourses = $DB->get_records_sql("select id,fullname from {course} where id IN ($cartinids)");
  $cfname = '';
	foreach($enllcourses as $enllcourse){
		$cfname .= $enllcourse->fullname .'<br>';
	 
	}	
	$cfnames = $cfname;
 if(count($enllcourses) > 1){
            $subject = 'Course Enrollment - Silicon Valley High School';
} else {
    $subject = 'Course Enrollment - Silicon Valley High School';
}			
			     $a = new \stdClass();
            $a->coursename = $cfnames;
            $a->links = 'https://lms.svhs.co/login/index.php';
            $a->name = ucfirst($user->firstname);
			
            $a->username = $user->username;
			
			
            $userfrom = core_user::get_support_user();
           
           
            $fullmessage = get_string('enrolmentpaysus', '', $a);
              
            $fullmessagehtml = text_to_html(get_string('enrolmentpaysus', '', $a), false, false, true);
 
			$success = email_to_user($user, $userfrom, $subject, $fullmessage, $fullmessagehtml);
						$recours = $DB->delete_records('cm_cartcourses',array('userid' => $data->userid));
						
					
                        $b = new \stdClass();
                        $b->cemail = $cemail;
                        $b->cname = $cname;
                        $b->coursename = $cfnames;
                        $b->lname = ucfirst($user->lastname);
                        $b->name = ucfirst($user->firstname);
                        
                $responsedata = new stdClass();
                $responsedata->email = $cemail;
                $responsedata->firstname = $cname;
                $responsedata->lastname = '';
                $responsedata->maildisplay = true;
                $responsedata->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
                $responsedata->id = -99;
                $responsedata->firstnamephonetic = '';
                $responsedata->lastnamephonetic = '';
                $responsedata->middlename = '';
                $responsedata->alternatename = '';
                
                $completeFilePath = $CFG->dirroot.'/enrol/stripepayment/invoice_pdf/'.$filename; 
                $nameOfFile = $filename;
                            
                $fullmessageparent = get_string('enrolmentpayparentsus', '', $b);          
                $fullmessagehtmlparent = text_to_html(get_string('enrolmentpayparentsus', '', $b), false, false, true);		
                $parentsuccess = email_to_user($responsedata, $userfrom, $subject, $fullmessageparent, $fullmessagehtmlparent,$completeFilePath,$nameOfFile,true);
            
         
 
 } else {
	
		
	$instceid = $DB->get_record("enrol", array("enrol" => 'stripepayment', "status" => 0,"courseid" => $courseid));
	
    // Enrol user.
    $plugin->enrol_user($instceid, $user->id, 5, $timestart, $timeend);	
	
			$paydata = new stdClass();
			$paydata->userid = $user->id;
			$paydata->student_name = $uname;
            $paydata->student_email = $uemail;
            $paydata->student_username = $username;
            $paydata->transaction_id = $payid;
            $paydata->customer_name = $cname;
            $paydata->customer_email = $cemail;
			$paydata->courseid = $courseid;
            $paydata->datecreated = time();
			$DB->insert_record("payment_transaction_log", $paydata);
		
		$records =array("transactionid"=>$payid,"sname"=>$uname,"cname"=>$cname,"cemail"=>$cemail,"courseid"=>$courseid);

						$filename = $payid.'.pdf';	

            $mpdf=new mPDF('c','Letter','','' , 0 , 0 , 0 , 0 , 0 , 0);
			//$mpdf->SetProtection(array('print'));
			$mpdf->SetProtection(array('copy','print'),'', 'admin@svhs');
			
			
			$mpdf->SetDisplayMode('fullpage');
			 
			$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
			ob_start();
			
		
			require_once 'invoice_receipt.php';
			$content = ob_get_clean();
			$mpdf->WriteHTML($content);
					 
			//$mpdf->Output(); //send to browser
			$mpdf->Output($CFG->dirroot.'/enrol/stripepayment/invoice_pdf/'.$filename,'F');
				
		
		

  $enllcourses = $DB->get_record_sql("select id,fullname from {course} where id = $courseid");
$cfname = $enllcourses->fullname;

 $a = new \stdClass();
    $a->coursename = $cfname;
    $a->links = 'https://lms.svhs.co/login/index.php';
    $a->name = ucfirst($user->firstname);
    
            $a->username = $user->username;
			
	
    $userfrom = core_user::get_support_user();
    $subject = 'Course Enrollment - Silicon Valley High School';
   
    $fullmessage = get_string('enrolmentpaysus', '', $a);
      
    $fullmessagehtml = text_to_html(get_string('enrolmentpaysus', '', $a), false, false, true);
 
			$success = email_to_user($user, $userfrom, $subject, $fullmessage, $fullmessagehtml);

            $b = new \stdClass();
			$b->cemail = $cemail;
            $b->cname = $cname;
			$b->coursename = $cfnames;
			$b->lname = ucfirst($user->lastname);
			$b->name = ucfirst($user->firstname);
			
	$responsedata = new stdClass();
    $responsedata->email = $cemail;
    $responsedata->firstname = $cname;
    $responsedata->lastname = '';
    $responsedata->maildisplay = true;
    $responsedata->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
    $responsedata->id = -99;
    $responsedata->firstnamephonetic = '';
    $responsedata->lastnamephonetic = '';
    $responsedata->middlename = '';
    $responsedata->alternatename = '';
	
	$completeFilePath = $CFG->dirroot.'/enrol/stripepayment/invoice_pdf/'.$filename; 
	$nameOfFile = $filename;
				
	$fullmessageparent = get_string('enrolmentpayparentsus', '', $b);          
    $fullmessagehtmlparent = text_to_html(get_string('enrolmentpayparentsus', '', $b), false, false, true);		
	$parentsuccess = email_to_user($responsedata, $userfrom, $subject, $fullmessageparent, $fullmessagehtmlparent,$completeFilePath,$nameOfFile,true);
			
	
	
}

 $destination = "$CFG->wwwroot/my/index.php";
            $fullname = format_string($course->fullname, true, array('context' => $context));

		
				redirect($CFG->wwwroot.'/my/index.php?msg=success');
                //notice('Thank you for your payment!  You are now enrolled in your courses', $destination);

			
            // Something else happened, completely unrelated to Stripe.
           // echo 'Soe happened, completely unrelated to Stripe';
        }
    
	}
}

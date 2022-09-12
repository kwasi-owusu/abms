<?php

!isset($_SESSION) ? session_start() : null;

date_default_timezone_set("Africa/Accra");

require_once dirname(__DIR__) . '/controller/CTRLSecureAgencySetup.php';
require_once dirname(__DIR__, 2) . '/auth/model/MDLUserActivities.php';
require_once dirname(__DIR__, 2) . '/AgentEnum.php';


class CTRLSetupAgency
{

    private string $table_a;
    private string $table_b;
    private string $table_c;
    private string $user_roles;
    private string $geneal_settings;


    public function __construct($table_a, $table_b, $table_c, $user_roles, $geneal_settings)
    {

        $this->table_a          = $table_a;
        $this->table_b          = $table_b;
        $this->table_c          = $table_c;
        $this->user_roles       = $user_roles;
        $this->geneal_settings  = $geneal_settings;
    }

    public function setupAgencyCTRL()
    {

        $error      = false;
        $_token     = trim(strip_tags($_POST['tkn']));

        if (isset($_SESSION['tkn']) && $_SESSION['tkn'] == $_token) {

            $parent_agent       = trim(strip_tags($_SESSION['agent_id']));
            $agency_name        = trim(strip_tags($_POST['agency_name']));
            $agency_type        = trim(strip_tags($_POST['agency_type']));
            $agency_address     = trim(strip_tags($_POST['agency_address']));
            $agency_phone       = trim(strip_tags($_POST['agency_phone']));
            $agency_email       = trim(strip_tags($_POST['agency_email']));
            $contact_person     = trim(strip_tags($_POST['contact_person']));
            $contact_person_phone = trim(strip_tags($_POST['contact_person_phone']));

            if (empty($agency_name) || empty($agency_phone) || empty($contact_person) || empty($contact_person_phone) || empty($agency_address) || empty($agency_type)) {

                $error = true;
                $message        = "All fields are required";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                return;
            }

            $officer_id         = trim(strip_tags($_SESSION['officer_id']));

            //generate agency code
            $n = 10;
            function agency_code($n)
            {
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $transaction_ref = '';

                for ($i = 0; $i < $n; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $transaction_ref .= $characters[$index];
                }

                return $transaction_ref;
            }

            $agency_code =  agency_code($n);

            //generate agent key
            $toHashThis         = $agency_name . $agency_phone;

            $agency_hash_key       = AgentEnum::save_agency->value;
            $agency_key            = hash_hmac('sha512', $toHashThis, $agency_hash_key);


            //create agency slug
            $for_slug = $agency_code . "/" . $agency_name;

            function php_slug($string)
            {
                $slug = preg_replace('/[^a-z0-9-]+/', '-', strtolower($string));
                return $slug;
            }
            $agent_slug = php_slug($for_slug);


            $agent_img       = $_FILES['agent_img'];

            $count = count((array)$_FILES['agent_img']['name']);
            for ($i = 0; $i < $count; $i++) {
                if (is_uploaded_file($_FILES['agent_img']['tmp_name'][$i])) {
                    $mime_type = mime_content_type($_FILES['agent_img']['tmp_name'][$i]);
                    $allowed_file_types = ['image/png', 'image/jpeg'];
                    $file_size = $_FILES["agent_img"]["size"][$i];
                    $file_error = $_FILES["agent_img"]["error"][$i];
                    if (!in_array($mime_type, $allowed_file_types)) {
                        $error = true;
                        echo "Uploaded file not allowed";

                        return;
                    } elseif ($file_size > 2000000) {
                        $error = true;
                        echo "A file exceeds 2MB";
                        return;
                    } elseif ($file_error) {
                        $error = true;
                        echo "There is an upload error";
                        return;
                    }
                }
            }


            //notification
            $notification_desc          = "An Agency has been setup";
            $notification_type          = "Email";
            $send_to                    = "";



            $secure_agency_setup    = new CTRLSecureAgencySetup();

            $is_agent_exist         = $secure_agency_setup->is_agent_exist($this->table_a, $agency_code, $agency_name);
            $is_officer_permitted   = $secure_agency_setup->is_officer_permitted($this->user_roles, $officer_id);
            $is_agency_registration_allowed = $secure_agency_setup->is_agency_registration_allowed($this->geneal_settings);

            if ($is_agent_exist > 0) {
                $error          = true;
                $message        = "Agency already exist";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);
            } elseif ($is_officer_permitted < 1) {
                $error          = true;
                $message        = "You are not permitted to register an agent";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);
            } elseif ($is_agency_registration_allowed == 0) {
                $error          = true;
                $message        = "Agency registration is not allowed now";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);
            }

            if ($is_agent_exist  == 0 && $is_officer_permitted > 0 && $is_agency_registration_allowed == 1) {

                //save entry
                if (!$error) {
                    $data = array(
                        'parent_agent' => $parent_agent,
                        'agency_name' => $agency_name,
                        'agency_type' => $agency_type,
                        'agency_address' => $agency_address,
                        'agency_phone' => $agency_phone,
                        'agency_email' => $agency_email,
                        'contact_person' => $contact_person,
                        'contact_person_phone' => $contact_person_phone,
                        'officer_id' => $officer_id,
                        'agency_code' => $agency_code,
                        'agency_key' => $agency_key,
                        'agent_slug' => $agent_slug,
                        'img' => $agent_img,
                        'notification_desc' => $notification_desc,
                        'notification_type' => $notification_type,
                        'send_to' => $send_to
                    );

                    if (MDLSaveThisAgency::saveThisAgencyMDL($data, $this->table_a, $this->table_b, $this->table_c)) {

                        $error          = false;
                        $message        = "Agency Setup successfully saved";
                        $error_code     = 111;

                        $response_msg   = array(
                            'error' => true,
                            'message' => $message,
                            'code' => $error_code
                        );

                        echo json_encode($response_msg);
                    } else {
                        $error          = true;
                        $message        = "Agency Setup unsuccessful";
                        $error_code     = 112;

                        $response_msg   = array(
                            'error' => true,
                            'message' => $message,
                            'code' => $error_code
                        );

                        echo json_encode($response_msg);
                    }
                }
            } else {
                $error          = true;
                $message        = "Agency Setup not permitted";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);
            }
        } else {

            $error          = true;
            $message        = "Action not permitted";
            $error_code     = 112;

            $response_msg   = array(
                'error' => true,
                'message' => $message,
                'error_code' => $error_code
            );

            echo json_encode($response_msg);
        }
    }
}

$callClass = new CTRLSetupAgency('agency_setup', 'agency_images', 'notifications', 'user_roles', 'general_settings');
$callMethod = $callClass->setupAgencyCTRL();

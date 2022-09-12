<?php

!isset($_SESSION) ? session_start() : null;

date_default_timezone_set("Africa/Accra");

require_once dirname(__DIR__) . '/controller/CTRLSecureTransaction.php';
require_once dirname(__DIR__, 2) . '/auth/model/MDLUserActivities.php';

class CTRLUpdateThisAgent
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

    public function updateThisAgentCTRL()
    {

        $error      = false;
        $_token     = trim(strip_tags($_POST['tkn']));

        if (isset($_SESSION['tkn']) && $_SESSION['tkn'] == $_token) {

            $parent_agent       = trim(strip_tags($_SESSION['agent_id']));
            $agency_code        = trim(strip_tags($_POST['agency_code']));
            $agency_id          = trim(strip_tags($_POST['agency_id']));
            $agency_name        = trim(strip_tags($_POST['agency_name']));
            $agency_type        = trim(strip_tags($_POST['agency_type']));
            $agency_address     = trim(strip_tags($_POST['agency_address']));
            $agency_phone       = trim(strip_tags($_POST['agency_phone']));
            $agency_email       = trim(strip_tags($_POST['agency_email']));
            $contact_person     = trim(strip_tags($_POST['contact_person']));
            $contact_person_phone = trim(strip_tags($_POST['contact_person_phone']));


            if (empty($agency_name) || empty($agency_phone) || empty($contact_person) || empty($contact_person_phone) || empty($agency_address) 
            || empty($agency_type)) {

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


            //create agency slug
            $for_slug = $agency_code . "/" . $agency_name;

            function php_slug($string)
            {
                $slug = preg_replace('/[^a-z0-9-]+/', '-', strtolower($string));
                return $slug;
            }

            $agent_slug = php_slug($for_slug);

            //notification
            $notification_desc          = "An Agency has been setup";
            $notification_type          = "Email";
            $send_to                    = "";

            $secure_agency_setup    = new CTRLSecureAgencySetup();

            $is_agent_exist         = $secure_agency_setup->is_agent_exist($this->table_a, $agency_code, $agency_name);
            $is_officer_permitted   = $secure_agency_setup->is_officer_permitted($this->user_roles, $officer_id);

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
            }

            if ($is_agent_exist  == 0 && $is_officer_permitted > 0) {

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
                        'agent_slug' => $agent_slug,
                        'notification_desc' => $notification_desc,
                        'notification_type' => $notification_type,
                        'send_to' => $send_to,
                        'agency_id' => $agency_id
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
            }
        }
        else {

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

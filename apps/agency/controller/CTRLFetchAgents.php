<?php

!isset($_SESSION) ? session_start() : $_SESSION = null;

date_default_timezone_set("Africa/Accra");

require_once dirname(__DIR__) . '/model/MDLFetchAgents.php';

require_once dirname(__DIR__) . '/controller/CTRLSecureAgencySetup.php';


class CTRLFetchAgents extends MDLFetchAgents
{

    private string $agency_setup;
    private string $officer;
    private string $user_access_level;
    private string $user_roles;
    private string $general_settings;

    public function __construct($agency_setup, $officer, $user_access_level, $user_roles, $geneal_settings)
    {

        $this->agency_setup             = $agency_setup;
        $this->officer                  = $officer;
        $this->user_access_level        = $user_access_level;
        $this->user_roles               = $user_roles;
        $this->geneal_settings          = $geneal_settings;
    }

    public function ctrl_fetchThisAgent($agency_id, $agency_code, $agency_key){
        
        $data = array(
            'agency_id' => $agency_id,
            'agency_code' => $agency_code,
            'agency_key' => $agency_key
        );

        $fetchRst = new MDLFetchAgents();

        $getRst = $fetchRst->fetchThisAgent($this->agency_setup, $data);

        return $getRst;
    }


    public function ctrl_fetchActiveAgent(){

        $fetch_active_agents = new MDLFetchAgents;
        $getRst = $fetch_active_agents->fetchActiveAgent($this->agency_setup);

        return $getRst;
    }


    public function ctrl_fetchDeactivatedAgent(){

        $fetch_deactivated_agents = new MDLFetchAgents;
        $getRst = $fetch_deactivated_agents->fetchDeactivatedAgent($this->agency_setup);

        return $getRst;
    }
}

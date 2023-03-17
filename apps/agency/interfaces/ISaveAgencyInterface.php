<?php

interface ISaveAgencyInterface{
    public function is_agent_exist(string $table_a, string $agent_id, string $agent_key) : int;
    public function is_officer_permitted(string $user_permissions, string $officer_id) : int;
    public function is_agency_registration_allowed(string $geneal_settings) : int;
    
}
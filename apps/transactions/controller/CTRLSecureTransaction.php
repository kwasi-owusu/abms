<?php


require_once dirname(__DIR__) . '/model/MDLSecureTransaction.php';

require_once dirname(__DIR__) . '/controller/ISecureTransactionInterface.php';

class CTRLSecureTransaction implements ISecureTransactionInterface
{


    public function is_agent_active($sec_table_a, $agent_id, $agent_key): int
    {

        $isAgentActiveRst = new MDLSecureTransaction();

        if ($rst    = $isAgentActiveRst->is_agent_active_mdl($sec_table_a, $agent_id, $agent_key)) {

            return 2;
        } else {
            return 0;
        }
    }

    

    public function is_branch_active($table_d, $agent_id, $agency_branch, $branch_key): int
    {


        $isBranchActiveRst = new MDLSecureTransaction();

        if ($rst    = $isBranchActiveRst->is_branch_active_mdl($table_d, $agent_id, $agency_branch, $branch_key)) {

            return 2;
        } else {
            return 0;
        }
    }



    public function is_officer_active($sec_table_c, $agent_id, $officer_id, $user_key): int
    {

        $isOfficerActiveRst = new MDLSecureTransaction();

        if ($rst    = $isOfficerActiveRst->is_officer_active_mdl($sec_table_c, $agent_id, $officer_id, $user_key)) {

            return 2;
        } else {
            return 0;
        }
       
        
    }


    public function is_transaction_allowed($sec_table_d): int
    {
        
        $isOfficerActiveRst = new MDLSecureTransaction();
        $rst    = $isOfficerActiveRst->is_transaction_allowed_mdl($sec_table_d);

        $val = $rst['settings_value'];

        if ($val == '1') {

            return 1;
        } else {
            return 0;
        }
    }



    public function is_transaction_limit_reached($table_a, $account_number, $account_name, $current_transaction_limit): int
    {

        $isOfficerActiveRst = new MDLSecureTransaction();
        $rst    = $isOfficerActiveRst->is_transaction_limit_reached_mdl($table_a, $account_number, $account_name);

        $val = $rst['total_amount'];

        if(floatval($current_transaction_limit) >= $val) {
        
         return 2;

        }

        else {
            return 0;
        }
    }
}

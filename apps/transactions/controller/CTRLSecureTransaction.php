<?php


require_once dirname(__DIR__) . '/model/MDLSecureTransaction.php';

require_once dirname(__DIR__) . '/interfaces/ISecureTransactionInterface.php';
require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

class CTRLSecureTransaction implements ISecureTransactionInterface
{

    private string $transactions_tbl;
    private string $user_activities;
    private string $notifications;
    private string $agency_branches;
    private string $agency_setup;
    private string $abms_users;
    private string $geneal_settings;
    private string $pos_terminal_registration;
    private string $balance_tbl;


    function __construct($transactions_tbl, $user_activities, $notifications, $agency_branches, $agency_setup, $abms_users, $geneal_settings, $pos_terminal_registration, $balance_tbl)
    {

        $this->transactions_tbl     = $transactions_tbl;
        $this->user_activities      = $user_activities;
        $this->notifications        = $notifications;
        $this->agency_branches      = $agency_branches;
        $this->agency_setup         = $agency_setup;
        $this->abms_users           = $abms_users;
        $this->geneal_settings      = $geneal_settings;
        $this->pos_terminal_registration = $pos_terminal_registration;
        $this->balance_tbl = $balance_tbl;
    }

    public function is_agent_active($agent_key): int
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $isAgentActiveRst = new MDLSecureTransaction($newPDO, $thisPDO);
        $rst    = $isAgentActiveRst->is_agent_active_mdl($this->agency_setup, $agent_key);
        return $rst;
    }



    public function is_branch_active($agent_id, $branch_id): int
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $isBranchActiveRst = new MDLSecureTransaction($newPDO, $thisPDO);

        $rst    = $isBranchActiveRst->is_branch_active_mdl($this->agency_branches, $agent_id, $branch_id);
        return $rst;
    }



    public function is_officer_active($agent_id, $teller_id): int
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $isOfficerActiveRst = new MDLSecureTransaction($newPDO, $thisPDO);

        $rst    = $isOfficerActiveRst->is_officer_active_mdl($this->abms_users, $agent_id, $teller_id);
        return $rst;
    }


    public function has_branch_got_enough_balance(int $agency_id, int $branch_id): object
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $hasBranchGotEnoughBalanceRst = new MDLSecureTransaction($newPDO, $thisPDO);

        $rst    = $hasBranchGotEnoughBalanceRst->has_branch_got_enough_balance_mdl($this->balance_tbl, $agency_id, $branch_id);
        return $rst;
    }


    public function is_transaction_allowed(): int
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $isTransactionAllowedRst = new MDLSecureTransaction($newPDO, $thisPDO);
        $rst    = $isTransactionAllowedRst->is_transaction_allowed_mdl($this->geneal_settings);
        return $rst;
    }


    public function is_transaction_allowed_for_agent($agent_key): int
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $isTransactionAllowedForAgentRst = new MDLSecureTransaction($newPDO, $thisPDO);
        $rst    = $isTransactionAllowedForAgentRst->is_transaction_allowed_for_this_agent_mdl($this->agency_setup, $agent_key);
        return $rst;
    }


    public function is_transaction_limit_reached($account_number, $account_name, $current_transaction_limit): object
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $isTransactionLimitReachedRst = new MDLSecureTransaction($newPDO, $thisPDO);
        $rst    = $isTransactionLimitReachedRst->is_transaction_limit_reached_mdl($this->transactions_tbl, $account_number, $account_name);
        return $rst;
    }



    public function is_pos_terminal_authorized(int $agent_id, string $pos_dna): int
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $pos_terminal_authorization = new MDLSecureTransaction($newPDO, $thisPDO);
        $rst    = $pos_terminal_authorization->is_this_pos_terminal_authorized($this->pos_terminal_registration, $agent_id, $pos_dna);

        return $rst;
    }
}

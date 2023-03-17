<?php

// secure hash is a concatenation of page name and save agency
// e.g do.agent_setup.phtmlbsystems_agency_banking_management_solution
enum AgentEnum: string
{
    case agent_setup_page_name  = "do.agent_setup.phtml";
    case save_agency            = "bsystems_agency_banking_management_solution";
    case secure_form_cors_hash  = "6b31dc72ef19b13cb38dc8be761123a911f4ebb50b4015a4c2213bb8d3b005500b2a6645130361dd7a44fbbffd8ce797d54823f3487a03fc875a31118864029b";
}


enum branch_setup_enum: string {
    case branch_setup_page_name = "do.branch_setup.phtml";
    case save_branch = "bsystems_agency_banking_management_solution";
    case secure_branch_form_cors_hash = "60f00a9a53b93ca9b41e94ce3fb824b15e142225d5cda618f45fbed6a8f26bc3a43cdcf55e17a160fce6975da21009d271245f10c2f954b7ba606ffc2c1d9ecf";
}
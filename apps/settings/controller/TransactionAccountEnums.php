<?php
enum TransactionAccountTypes: int
{
    case CashAccount        = 111;
    case CustomerAccount    = 222;
    case BankAccount        = 333;
    case VaultAccount       = 444;
    case TillAccount        = 555;
    case EcashAccount       = 666;
}

enum TransactionHashKeys: string
{
    case save_transaction       = "bsystems_agency_banking_management_solution";
    case password_hash          = "bahrima_kwasi_owusu";
}

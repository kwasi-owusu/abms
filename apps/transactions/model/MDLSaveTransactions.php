<?php

class MDLSaveTransactions{

    public function saveTransactionMDL($data, $table_a, $table_b, $table_c){
        require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        if ($thisPDO->beginTransaction()) {
            try {

                //save transaction
                $stmt = $thisPDO->prepare("INSERT INTO $table_a(trans_category, trans_type, product_id, partner_id, unit_price, total_qty, total_amount,
                 officer_id, narration, id_type, id_number, account_name, account_number, agency_branch, agency_id, transaction_reference, 
                 transaction_key, depositor_payee, depositor_payee_phone) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                 $stmt->execute(array(
                    $data['transaction_category'],
                    $data['transaction_type'],
                    $data['product_id'],
                    $data['partner_id'],
                    $data['unit_price'],
                    $data['total_qty'],
                    $data['total_amount'],
                    $data['officer_id'],
                    $data['narration'],
                    $data['id_type'],
                    $data['id_number'],
                    $data['account_name'],
                    $data['account_number'],
                    $data['agency_branch'],
                    $data['agent_id'],
                    $data['transaction_reference'],
                    $data['transaction_key'],
                    $data['depositor_payee'],
                    $data['depositor_payee_phone'],
                                        
                 ));

                 $last_id = $thisPDO->lastInsertId();
                 
                //save notification
                $stmt_c = $thisPDO->prepare("INSERT INTO $table_c(notification_desc, notification_type, send_to)) VALUES(?, ?, ?)");
                $stmt_c->execute(
                    array(
                        $data['notification_desc'],
                        $data['notification_type'],
                        $data['send_to']
                    )
                );

                $thisPDO->commit();

                return $stmt;

            } catch (PDOException $e) {
                $thisPDO->rollBack();
                echo "Error";
            }

        }

    }

}
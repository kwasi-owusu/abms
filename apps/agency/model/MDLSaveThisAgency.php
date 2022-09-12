<?php
require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

class MDLSaveThisAgency extends ConnectDatabase
{

    public static function saveThisAgencyMDL($data, $table_a, $table_b, $table_c)
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        if ($thisPDO->beginTransaction()) {
            try {

                $stmt   = $thisPDO->prepare("INSERT INTO $table_a(agency_code, parent_agent, agency_name, agent_slug, agency_type, 
        agency_key, agency_address, agency_phone, agency_email, contact_person, contact_person_phone, officer_id) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->execute(array(
                    $data['agency_code'],
                    $data['parent_agent'],
                    $data['agency_name'],
                    $data['agent_slug'],
                    $data['agent_type'],
                    $data['agency_key'],
                    $data['agency_address'],
                    $data['agent_phone'],
                    $data['agent_email'],
                    $data['contact_person'],
                    $data['contact_person_phone'],
                    $data['officer_id']
                ));

                $last_id = $thisPDO->lastInsertId();


                //save attached images
                $imgContent             = '';
                $attached_images = $data['img'];
                $count = count((array)$attached_images['name']);

                $image_desc = "Agent registration documents";

                for ($i = 0; $i < $count; $i++) {
                    if (is_uploaded_file($attached_images['tmp_name'][$i])) {
                        $mime_type = mime_content_type($attached_images['tmp_name'][$i]);
                        $allowed_file_types = ['image/png', 'image/jpeg'];

                        $file_size = $attached_images["size"][$i];
                        $file_error = $attached_images["error"][$i];
                        if (!in_array($mime_type, $allowed_file_types)) {
                            echo "Uploaded file not allowed";

                            return;
                        } elseif ($file_size > 2000000) {
                            
                            echo "A file exceeds 2MB";
                            return;
                        } elseif ($file_error) {
                            
                            echo "There is an upload error";
                            return;
                        } else {
                            $image_base64   = base64_encode(file_get_contents($attached_images['tmp_name'][$i]));
                            $imgContent     .= 'data:image/' . $mime_type . ';base64,' . $image_base64;

                            $save_imgs      = $thisPDO->prepare("INSERT INTO $table_b(agent_id, agent_image_save, image_desc) 
                            VALUES(?, ?, ?)");
                            $save_imgs->execute(array(
                                $last_id,
                                $imgContent
                            ));
                        }
                    }
                }

                //save notification
                $stmt_c = $thisPDO->prepare("INSERT INTO $table_c(notification_desc, notification_type, send_to)) VALUES(?, ?, ?)");
                $stmt_c->execute(
                    array(
                        $data['notification_desc'],
                        $data['notification_type'],
                        $data['send_to'],
                        $image_desc
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

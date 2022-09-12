<?php

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

class MDLUserActivities{

    public function userActivitiesMDL($activity_data, $activity_table) {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("INSERT INTO $activity_table(activity_module, activity_desc, user_id) VALUES(?, ?, ?)");
        $stmt->execute(
            array(
                $activity_data['activity_module'],
                $activity_data['activity_desc'],
                $activity_data['user_id']
            )
        );

    }

}
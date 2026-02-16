<?php

if (!function_exists('log_activity')) {
    /**
     * Log user activity
     *
     * @param string $activity Description of the activity
     * @param int|null $referenceId Optional reference ID (e.g., alat_id, user_id)
     * @return void
     */
    function log_activity(string $activity, ?int $referenceId = null): void
    {
        $activityLogModel = new \App\Models\ActivityLogModel();
        
        $request = \Config\Services::request();
        
        $activityLogModel->insert([
            'user_id'      => session()->get('id_user'),
            'role_user'    => session()->get('role'),
            'activity'     => $activity,
            'reference_id' => $referenceId,
            'ip_addres'   => $request->getIPAddress(),
            'created_at'   => date('Y-m-d H:i:s')
        ]);
    }
}

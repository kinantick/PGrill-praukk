<?php

if (!function_exists('log_activity')) {
    /**
     * Log user activity
     *
     * @param string $activity Description of the activity
     * @param int|null $referenceId Optional reference ID (e.g., alat_id, id_user)
     * @return void
     */
    function log_activity(string $activity, ?int $referenceId = null): void
    {
        try {
            $activityLogModel = new \App\Models\ActivityLogModel();
            
            $request = \Config\Services::request();
            
            $activityLogModel->insert([
                'id_user'      => session()->get('id_user'),
                'role_user'    => session()->get('role'),
                'activity'     => $activity,
                'reference_id' => $referenceId,
                'ip_address'   => $request->getIPAddress(),
                'created_at'   => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Log error tapi jangan throw exception
            // Agar tidak mengganggu proses utama
            log_message('error', 'Failed to log activity: ' . $e->getMessage());
        }
    }
}

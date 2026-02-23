<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ActivityLogController extends BaseController
{
    public function index()
    {
        $activityLogModel = new ActivityLogModel();

        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');
        $date = $this->request->getGet('date');

        $builder = $activityLogModel
            ->select('activity_logs.*, user.nama, user.email')
            ->join('user', 'user.id_user = activity_logs.id_user', 'left')
            ->orderBy('activity_logs.created_at', 'DESC');

        if ($keyword) {
            $builder->groupStart()
                ->like('activity_logs.activity', $keyword)
                ->orLike('user.nama', $keyword)
                ->orLike('user.email', $keyword)
                ->groupEnd();
        }

        if ($role) {
            $builder->where('activity_logs.role_user', $role);
        }

        if ($date) {
            $builder->where('DATE(activity_logs.created_at)', $date);
        }

        $data = [
            'title'    => 'Activity Log',
            'logs'     => $builder->paginate(20),
            'pager'    => $activityLogModel->pager,
            'keyword'  => $keyword,
            'role'     => $role,
            'date'     => $date
        ];

        return view('activity_log/index.php', $data);
    }

    public function clear()
    {
        $activityLogModel = new ActivityLogModel();
        
        $days = $this->request->getPost('days');
        
        if ($days && is_numeric($days)) {
            $date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
            $activityLogModel->where('created_at <', $date)->delete();
            
            return redirect()->to('/activity-log')->with('success', "Log lebih dari {$days} hari berhasil dihapus");
        }

        return redirect()->to('/activity-log')->with('error', 'Parameter tidak valid');
    }
}

<?php

class Updateuser extends Controller
{
    public function index()
    {

        $userModel = new User;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && $_POST['action'] === 'fetch') {
            $userId = (int) $_POST['user_id'];
            $user = $userModel->where(['id' => $userId]);
            if ($user) {
                echo json_encode([
                    'success' => true,
                    'user' => $user
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found']);
            }

            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && $_POST['action'] === 'update') {
            $userId = (int) $_POST['user_id'];
            $data = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'role_id' => $_POST['role_id'] ?? '',
                'status' => $_POST['is_active'] ?? '',
            ];


            if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email'])) {
                echo json_encode(['success' => false, 'message' => 'Missing required fields']);
                return;
            }

            $data['full_name'] = trim($data['first_name'] . ' ' . $data['last_name']);
            unset($data['first_name'], $data['last_name']);
            $data['status'] = ($_POST['is_active'] == '1') ? 'active' : 'inactive';
            $data['id'] = $userId;



            // $logData = [
            //     'data' => $data,
            //     'timestamp' => date('Y-m-d H:i:s')
            // ];
            // file_put_contents(
            //     __DIR__ . '/test_log.txt',             // Adjust path if needed
            //     print_r($logData, true) . "\n",         // Human-readable format
            //     FILE_APPEND                             // Don’t overwrite old logs
            // );


            $updated = $userModel->update($userId, $data);

            if ($updated) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user']);
            }
            return;
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && $_POST['action'] === 'delete') {
            $userId = (int) $_POST['user_id'];
            $result = $userModel->delete($userId);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found']);
            }
            return;
        }


        echo json_encode(['success' => false, 'message' => 'Invalid request']);

        // $URL['view'] = 'usermanage';
        // $this->view('systemadmin', $URL);



    }
}


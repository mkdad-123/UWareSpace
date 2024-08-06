<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait NotificationTrait
{
    protected $model;
    protected $id;

    protected function setModel($model,$id): void
    {
        $this->model = $model;
        $this->id = $id;
    }

    public function index()
    {
        $user = $this->model->find($this->id);

        return response()->json([
            'message' => 'all notifications',
            'data'=> $user->notifications
        ]);
    }

    public function unread()
    {
        $user = $this->model->find($this->id);

        return response()->json([
            'message' => 'Unread notifications',
            'data'=> $user->unreadNotifications
        ]);
    }

    public function markReadAll()
    {
        $user = $this->model->find($this->id);

        $user->unreadNotifications()->update(['read_at' => now()]);

        return response()->json([
            'message' => 'All unread notifications are marked',
            'data'=> response()
        ]);
    }

    public function markRead($id)
    {
        DB::table('notifications')->where('id' , $id)->update(['read_at' => now()]);

        return response()->json([
            'message' => 'A unread notifications are marked',
            'data'=> response()
        ]);
    }

    public function deleteAll()
    {
        $user = $this->model->find($this->id);

        $user->notifications()->delete();

        return response()->json([
            'message' => 'All notifications have been deleted',
            'data'=> response()
        ]);
    }

    public function delete($id)
    {
        DB::table('notifications')->where('id' , $id)->delete();

        return response()->json([
            'message' => 'A notification have been deleted',
            'data'=> response()
        ]);
    }
}

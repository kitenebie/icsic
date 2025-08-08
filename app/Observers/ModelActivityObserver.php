<?php

namespace App\Observers;

use App\Models\SystemLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModelActivityObserver
{
    public function created(Model $model)
    {
        $changes = [
            'new' => $model->getAttributes(),
        ];
        $this->log('created', $model, $changes);
    }

    public function updated(Model $model)
    {
        $changes = [
            'old' => $model->getOriginal(),
            'new' => $model->getChanges(),
        ];
        $this->log('updated', $model, $changes);
    }

    public function deleted(Model $model)
    {
        $changes = [
            'old' => $model->getOriginal(),
        ];
        $this->log('deleted', $model, $changes);
    }

    protected function log(string $action, Model $model, array $changes = null)
    {
        SystemLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'changes' => $changes ? json_encode($changes) : null,
        ]);
    }
}

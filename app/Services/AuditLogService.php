<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditLogService
{
    public function log(
        User $user,
        string $action,
        Model $model,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null
    ): void {
        AuditLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }

    public function getLogsForModel(Model $model, ?int $limit = 10): array
    {
        return AuditLog::where('model_type', get_class($model))
            ->where('model_id', $model->id)
            ->with('user:id,name,email')
            ->latest()
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getLogsForUser(User $user, ?int $limit = 10): array
    {
        return AuditLog::where('user_id', $user->id)
            ->with('user:id,name,email')
            ->latest()
            ->limit($limit)
            ->get()
            ->toArray();
    }
} 
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Pool;
use App\Models\Siding;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PoolController extends BaseController
{
    // List all pools for the authenticated user
    public function index(Request $request)
    {
        $pools = Pool::AcceptRequest(getFillableSort('Pool'))->where('user_id', $request->get('user')->id)->with(['siding', 'media'])->filter()->get();
        return $this->success($pools, 'Pools retrieved successfully');
    }

    // Create new pool
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'siding_id' => 'required|exists:sidings,id',
            'media_id' => 'required|exists:medias,id',
        ]);

        if ($validator->fails()) {
            // هنا نمرر رسالة وerrors مع كود 422
            return $this->error('Validation Error', $validator->errors(), 422);
        }

        $userId = $request->get('user')->id;

        // تحقق أن siding يخص المستخدم
        if (!Siding::where('id', $request->siding_id)->exists()) {
            return $this->error('Invalid siding selected', [], 422);
        }

        // تحقق أن media يخص المستخدم
        if (!Media::where('id', $request->media_id)->exists()) {
            return $this->error('Invalid media selected', [], 422);
        }

        $pool = Pool::create([
            'user_id' => $userId,
            'name' => $request->name,
            'size' => $request->size,
            'siding_id' => $request->siding_id,
            'media_id' => $request->media_id,
        ]);

        return $this->success($pool, 'Pool created successfully', 201);
    }

    // Show single pool
    public function show(Request $request, $id)
    {
        $pool = Pool::where('user_id', $request->get('user')->id)->with(['siding', 'media'])->find($id);

        if (!$pool) {
            return $this->error('Pool not found', [], 404);
        }

        return $this->success($pool, 'Pool retrieved successfully');
    }

    // Update pool
    public function update(Request $request, $id)
    {
        $pool = Pool::where('user_id', $request->get('user')->id)->find($id);

        if (!$pool) {
            return $this->error('Pool not found', [], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'size' => 'sometimes|required|string|max:255',
            'siding_id' => 'sometimes|required|exists:sidings,id',
            'media_id' => 'sometimes|required|exists:medias,id',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', $validator->errors(), 422);
        }

        $userId = $request->get('user')->id;

        if ($request->has('siding_id') && !Siding::where('id', $request->siding_id)->exists()) {
            return $this->error('Invalid siding selected', [], 422);
        }

        if ($request->has('media_id') && !Media::where('id', $request->media_id)->exists()) {
            return $this->error('Invalid media selected', [], 422);
        }

        $pool->update($request->only(['name', 'size', 'siding_id', 'media_id']));

        return $this->success($pool, 'Pool updated successfully');
    }

    // Delete pool
    public function destroy(Request $request, $id)
    {
        $pool = Pool::where('user_id', $request->get('user')->id)->find($id);

        if (!$pool) {
            return $this->error('Pool not found', [], 404);
        }

        $pool->delete();

        return $this->success(null, 'Pool deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequst;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Member::with('activeBorrowing');

        if ($request->has('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email','like',"%{$search}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $members = $query->paginate(10);
        return MemberResource::collection($members);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequst $request)
    {
        $member = Member::create($request->validated());
        return new MemberResource($member);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $member->load(['activeBrrowings','borrowings']);
        return new MemberResource($member);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->update($request->validated());

        return new MemberResource($member);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        if($member->activeBorrowings()->count() > 0){
            return response()->json([
                'message' => 'Cannot delete member with active borrowing',
            ]);
        }

        $member->delete();

        return response()->json([
            'message' => 'Member deleted with success'
        ]);
    }
}

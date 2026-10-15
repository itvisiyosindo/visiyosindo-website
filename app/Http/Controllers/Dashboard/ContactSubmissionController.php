<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactSubmissionController extends Controller
{
    /**
     * Display a listing of contact submissions
     */
    public function index(Request $request)
    {
        $query = ContactSubmission::query()->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $submissions = $query->paginate(20);
        $statusCounts = [
            'all' => ContactSubmission::count(),
            'new' => ContactSubmission::where('status', 'new')->count(),
            'read' => ContactSubmission::where('status', 'read')->count(),
            'replied' => ContactSubmission::where('status', 'replied')->count(),
            'archived' => ContactSubmission::where('status', 'archived')->count(),
        ];

        return view('dashboard.management.contact-submissions.index', compact('submissions', 'statusCounts'));
    }

    /**
     * Show the details of a contact submission
     */
    public function show(ContactSubmission $contactSubmission)
    {
        // Mark as read if it's new
        if ($contactSubmission->status === 'new') {
            $contactSubmission->update(['status' => 'read']);
        }

        return view('dashboard.management.contact-submissions.show', compact('contactSubmission'));
    }

    /**
     * Update the status of a contact submission
     */
    public function updateStatus(Request $request, ContactSubmission $contactSubmission)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,archived',
            'admin_notes' => 'nullable|string'
        ]);

        $contactSubmission->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? $contactSubmission->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    /**
     * Delete a contact submission
     */
    public function destroy(ContactSubmission $contactSubmission)
    {
        $contactSubmission->delete();

        return redirect()->route('dashboard.contact-submissions.index')
            ->with('success', 'Submission berhasil dihapus');
    }

    /**
     * Bulk delete submissions
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contact_submissions,id'
        ]);

        ContactSubmission::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' submission berhasil dihapus'
        ]);
    }
}

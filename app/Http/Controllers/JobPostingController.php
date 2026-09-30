<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;

class JobPostingController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::published()->orderByDesc('published_at')->paginate(9);

        return view('jobs.index', ['jobsList' => $jobs]);
    }

    public function show(JobPosting $jobPosting)
    {
        abort_unless(
            $jobPosting->status === JobPosting::STATUS_PUBLISHED
                && (! $jobPosting->published_at || $jobPosting->published_at->lte(now())),
            404
        );

        $latestJobs = JobPosting::published()
            ->where('id', '!=', $jobPosting->id)
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        return view('jobs.show', ['job' => $jobPosting, 'latestJobs' => $latestJobs]);
    }
}

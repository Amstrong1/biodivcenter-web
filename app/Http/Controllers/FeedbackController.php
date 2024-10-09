<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $search = request('search');
        $query = Feedback::orderBy('id', 'desc');

        if ($search) {
            $query->where('content', 'like', '%' . $search . '%');
        }

        $feedbacks = $query->paginate(15)->withQueryString();

        $feedbacks->getCollection()->transform(function ($feedback) {
            return $feedback->append('user_name')->append('formated_date');
        });

        return Inertia::render('App/Feedback/Index', [
            'feedbacks' => $feedbacks,
            'csrf' => csrf_token(),
            'my_attributes' => $this->feedbackColumns(),
            'filters' => request('search'),
        ]);
    }

    private function feedbackColumns()
    {
        $columns = [
            'user_name' => 'Agent',
            'content' => 'Feedback',
            'formated_date' => 'Date',
        ];
        return $columns;
    }
}

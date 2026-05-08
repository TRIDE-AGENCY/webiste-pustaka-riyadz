<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Setting;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::when(request()->q, function ($query) {
            $query->where(function ($q) {
                $q->where('question', 'like', '%' . request()->q . '%')
                    ->orWhere('answer', 'like', '%' . request()->q . '%');
            });
        })->latest()->paginate(10);

        $faqs->appends(['q' => request()->q]);

        return inertia('Admin/Faq/Index', [
            'faqs' => $faqs,
        ]);
    }

    public function create()
    {
        return inertia('Admin/Faq/Create', [
            'api_tinymce_key' => Setting::value('api_tinymce_key'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->messages());

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.faqs.index');
    }

    public function edit(Faq $faq)
    {
        return inertia('Admin/Faq/Edit', [
            'faq' => $faq,
            'api_tinymce_key' => Setting::value('api_tinymce_key'),
        ]);
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate($this->rules(), $this->messages());

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.faqs.index');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index');
    }

    private function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'status' => ['required', 'in:published,archived'],
        ];
    }

    private function messages(): array
    {
        return [
            'question.required' => 'Pertanyaan tidak boleh kosong.',
            'answer.required' => 'Jawaban tidak boleh kosong.',
            'status.required' => 'Status tidak boleh kosong.',
        ];
    }
}

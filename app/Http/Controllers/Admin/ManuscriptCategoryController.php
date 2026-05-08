<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManuscriptCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManuscriptCategoryController extends Controller
{
    public function index()
    {
        $manuscriptCategories = ManuscriptCategory::when(request()->q, function ($query) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . request()->q . '%')
                    ->orWhere('description', 'like', '%' . request()->q . '%');
            });
        })->latest()->paginate(10);

        $manuscriptCategories->through(function ($category) {
            $category->image_url = $category->image ? asset('storage/' . $category->image) : null;
            $category->document_count = count($category->attached_documents ?? []);

            return $category;
        });

        $manuscriptCategories->appends(['q' => request()->q]);

        return inertia('Admin/ManuscriptCategory/Index', [
            'manuscript_categories' => $manuscriptCategories,
        ]);
    }

    public function create()
    {
        return inertia('Admin/ManuscriptCategory/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $pathImage = $request->file('image')->store('manuscript-categories', 'public');

        ManuscriptCategory::create([
            'image' => $pathImage,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'requirements' => $this->normalizeList($validated['requirements'] ?? []),
            'attachments' => $this->normalizeList($validated['attachments'] ?? []),
            'attached_documents' => $this->storeDocuments($request),
            'submission_method' => $this->normalizeList($validated['submission_method'] ?? []),
        ]);

        return redirect()->route('admin.manuscript_categories.index');
    }

    public function edit(ManuscriptCategory $manuscriptCategory)
    {
        $manuscriptCategory->image_name = basename($manuscriptCategory->image);
        $manuscriptCategory->image_size = Storage::disk('public')->exists($manuscriptCategory->image)
            ? Storage::disk('public')->size($manuscriptCategory->image)
            : 0;
        $manuscriptCategory->existing_documents = collect($manuscriptCategory->attached_documents ?? [])
            ->map(function ($document) {
                return [
                    ...$document,
                    'url' => asset('storage/' . $document['path']),
                ];
            })
            ->values();

        return inertia('Admin/ManuscriptCategory/Edit', [
            'manuscript_category' => $manuscriptCategory,
        ]);
    }

    public function update(Request $request, ManuscriptCategory $manuscriptCategory)
    {
        $validated = $request->validate($this->rules(true), $this->messages());

        $pathImage = $manuscriptCategory->image;
        if ($request->hasFile('image')) {
            if ($pathImage && Storage::disk('public')->exists($pathImage)) {
                Storage::disk('public')->delete($pathImage);
            }

            $pathImage = $request->file('image')->store('manuscript-categories', 'public');
        }

        $removedDocuments = collect($request->input('removed_documents', []))
            ->filter()
            ->values()
            ->all();

        $existingDocuments = collect($manuscriptCategory->attached_documents ?? [])
            ->reject(fn ($document) => in_array($document['path'] ?? null, $removedDocuments))
            ->values();

        foreach ($removedDocuments as $documentPath) {
            if (Storage::disk('public')->exists($documentPath)) {
                Storage::disk('public')->delete($documentPath);
            }
        }

        $newDocuments = collect($this->storeDocuments($request));

        $manuscriptCategory->update([
            'image' => $pathImage,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'requirements' => $this->normalizeList($validated['requirements'] ?? []),
            'attachments' => $this->normalizeList($validated['attachments'] ?? []),
            'attached_documents' => $existingDocuments->merge($newDocuments)->values()->all(),
            'submission_method' => $this->normalizeList($validated['submission_method'] ?? []),
        ]);

        return redirect()->route('admin.manuscript_categories.index');
    }

    public function destroy(ManuscriptCategory $manuscriptCategory)
    {
        if ($manuscriptCategory->image && Storage::disk('public')->exists($manuscriptCategory->image)) {
            Storage::disk('public')->delete($manuscriptCategory->image);
        }

        foreach ($manuscriptCategory->attached_documents ?? [] as $document) {
            if (!empty($document['path']) && Storage::disk('public')->exists($document['path'])) {
                Storage::disk('public')->delete($document['path']);
            }
        }

        $manuscriptCategory->delete();

        return redirect()->route('admin.manuscript_categories.index');
    }

    private function rules(bool $isUpdate = false): array
    {
        return [
            'image' => [$isUpdate ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'array', 'min:1'],
            'requirements.*' => ['required', 'string', 'max:1000'],
            'attachments' => ['required', 'array', 'min:1'],
            'attachments.*' => ['required', 'string', 'max:1000'],
            'submission_method' => ['required', 'array', 'min:1'],
            'submission_method.*' => ['required', 'string', 'max:1000'],
            'attached_documents' => ['nullable', 'array'],
            'attached_documents.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,rar,zip,7z', 'max:20480'],
            'removed_documents' => ['nullable', 'array'],
            'removed_documents.*' => ['string'],
        ];
    }

    private function messages(): array
    {
        return [
            'image.required' => 'Gambar tidak boleh kosong.',
            'image.image' => 'Gambar kategori naskah harus berupa file gambar.',
            'image.mimes' => 'Gambar kategori naskah harus berekstensi jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran gambar kategori naskah maksimal 10MB.',
            'title.required' => 'Judul tidak boleh kosong.',
            'description.required' => 'Deskripsi tidak boleh kosong.',
            'requirements.required' => 'Persyaratan tidak boleh kosong.',
            'attachments.required' => 'Lampiran tidak boleh kosong.',
            'submission_method.required' => 'Metode pengiriman tidak boleh kosong.',
            'attached_documents.*.mimes' => 'Dokumen harus berupa pdf, doc, docx, xls, xlsx, ppt, pptx, rar, zip, atau 7z.',
            'attached_documents.*.max' => 'Ukuran setiap dokumen maksimal 20MB.',
        ];
    }

    private function normalizeList(array $items): array
    {
        return collect($items)
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }

    private function storeDocuments(Request $request): array
    {
        if (! $request->hasFile('attached_documents')) {
            return [];
        }

        return collect($request->file('attached_documents'))
            ->map(function ($document) {
                $path = $document->store('manuscript-categories/documents', 'public');

                return [
                    'name' => $document->getClientOriginalName(),
                    'path' => $path,
                    'size' => $document->getSize(),
                    'extension' => strtolower($document->getClientOriginalExtension()),
                ];
            })
            ->values()
            ->all();
    }
}

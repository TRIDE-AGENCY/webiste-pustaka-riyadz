<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcessStep;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProcessStepController extends Controller
{
    public function index()
    {
        $this->ensureDefaults();

        return inertia('Admin/ProcessStep/Index', [
            'process_steps' => ProcessStep::orderBy('position')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $this->ensureDefaults();

        $validated = $request->validate([
            'steps' => ['required', 'array', 'size:3'],
            'steps.*.id' => ['required', 'distinct', Rule::exists('process_steps', 'id')],
            'steps.*.position' => ['required', 'integer', 'between:1,3', 'distinct'],
            'steps.*.title' => ['required', 'string', 'max:255'],
            'steps.*.description' => ['required', 'string', 'max:500'],
        ], [
            'steps.required' => 'Data alur tidak boleh kosong.',
            'steps.size' => 'Alur terstruktur harus berisi tepat 3 data.',
            'steps.*.title.required' => 'Judul alur tidak boleh kosong.',
            'steps.*.description.required' => 'Deskripsi alur tidak boleh kosong.',
        ]);

        collect($validated['steps'])
            ->sortBy('position')
            ->each(function ($step) {
                ProcessStep::whereKey($step['id'])->update([
                    'title' => $step['title'],
                    'description' => $step['description'],
                ]);
            });

        return redirect()->route('admin.process_steps.index');
    }

    private function ensureDefaults(): void
    {
        $defaults = [
            [
                'position' => 1,
                'title' => 'Unggah Dokumen',
                'description' => 'Lengkapi berkas administrasi sesuai persyaratan yang ditentukan.',
            ],
            [
                'position' => 2,
                'title' => 'Verifikasi Data',
                'description' => 'Tim admin akan memeriksa validitas dokumen yang telah dikirimkan.',
            ],
            [
                'position' => 3,
                'title' => 'Selesai Terintegrasi',
                'description' => 'Dokumen berhasil divalidasi dan siap digunakan dalam sistem.',
            ],
        ];

        foreach ($defaults as $default) {
            ProcessStep::firstOrCreate(
                ['position' => $default['position']],
                [
                    'title' => $default['title'],
                    'description' => $default['description'],
                ],
            );
        }
    }
}
